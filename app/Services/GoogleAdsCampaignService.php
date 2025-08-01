<?php

namespace App\Services;

use Exception;
use Google\Ads\GoogleAds\Lib\V19\GoogleAdsClientBuilder;
use Google\Ads\GoogleAds\Lib\OAuth2TokenBuilder;
use Google\Ads\GoogleAds\Lib\V19\GoogleAdsException;
use Google\Ads\GoogleAds\V19\Errors\AuthenticationErrorEnum\AuthenticationError;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Google\Ads\GoogleAds\V19\Common\{
    AdScheduleInfo,
    KeywordInfo,
    ManualCpc,
    LocationInfo,
    ProximityInfo,
    AddressInfo,
};
use Google\Ads\GoogleAds\V19\Enums\{
    AdGroupAdStatusEnum\AdGroupAdStatus,
    AdGroupCriterionStatusEnum\AdGroupCriterionStatus,
    AdGroupStatusEnum\AdGroupStatus,
    AdvertisingChannelTypeEnum\AdvertisingChannelType,

    CampaignStatusEnum\CampaignStatus,
    BudgetDeliveryMethodEnum\BudgetDeliveryMethod,
    KeywordMatchTypeEnum\KeywordMatchType,
    ProximityRadiusUnitsEnum\ProximityRadiusUnits,
    GeoTargetConstantStatusEnum\GeoTargetConstantStatus
};
use Google\Ads\GoogleAds\V19\Enums\DayOfWeekEnum\DayOfWeek;
use Google\Ads\GoogleAds\V19\Enums\MinuteOfHourEnum\MinuteOfHour;
use Google\Ads\GoogleAds\V19\Resources\{

    AdGroup,
    AdGroupAd,
    AdGroupCriterion,
    Campaign,
    CampaignBudget,
    CampaignCriterion,
    Campaign\NetworkSettings,
};
use Google\Ads\GoogleAds\V19\Services\{
    AdGroupAdOperation,
    AdGroupCriterionOperation,
    AdGroupOperation,
    CampaignBudgetOperation,
    CampaignOperation,
    CampaignCriterionOperation,

    MutateAdGroupAdsRequest,
    MutateAdGroupCriteriaRequest,
    MutateAdGroupsRequest,
    MutateCampaignBudgetsRequest,
    MutateCampaignsRequest,
    MutateCampaignCriteriaRequest,
    SearchGoogleAdsRequest,

    SuggestGeoTargetConstantsRequest,
};
use Google\Ads\GoogleAds\V19\Services\SuggestGeoTargetConstantsRequest\LocationNames as SuggestGeoTargetConstantsRequestLocationNames;

class GoogleAdsCampaignService
{
    private $googleAdsClient;
    private $customerId;
    private $googleAccount;
    private $lastTokenRefresh;
    private $refreshToken;
    private $isMcc;

    public function __construct(string $customerId, string $refreshToken, bool $isMcc = false, ?string $googleAccount = null)
    {
        $this->customerId = $customerId;
        $this->googleAccount = $googleAccount;
        $this->refreshToken = $refreshToken;
        $this->lastTokenRefresh = now();
        $this->isMcc = $isMcc;
        $this->initializeGoogleAdsClient();
    }

    /**
     * Obtiene el token de actualización actual
     * 
     * @return string El token de actualización
     */
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    private function initializeGoogleAdsClient(): void
    {
        try {
            $oAuth2Credential = (new OAuth2TokenBuilder())
                ->withClientId(config('services.google_ads.client_id'))
                ->withClientSecret(config('services.google_ads.client_secret'))
                ->withRefreshToken($this->refreshToken)
                ->build();

            $builder = (new GoogleAdsClientBuilder())
                ->withDeveloperToken(config('services.google_ads.developer_token'))
                ->withOAuth2Credential($oAuth2Credential);

            if ($this->googleAccount) {
                $builder->withLoginCustomerId($this->googleAccount);
            }

            $this->googleAdsClient = $builder->build();
        } catch (\Exception $e) {
            Log::error('Error al inicializar Google Ads Client', [
                'error' => $e->getMessage(),
                'customer_id' => $this->customerId,
                'is_mcc' => $this->isMcc
            ]);
            throw new \RuntimeException('Error al conectar con Google Ads: ' . $e->getMessage());
        }
    }

    /**
     * Valida y refresca el token de Google Ads
     * 
     * @return bool true si el token es válido y se pudo refrescar, false si necesita renovación
     * @throws \RuntimeException si hay un error al validar el token
     */
    public function validateAndRefreshToken(): bool
    {
        try {
            // Verificar si han pasado más de 50 minutos desde el último refresh
            if ($this->lastTokenRefresh->diffInMinutes(now()) >= 50) {
                // Intentar una operación simple para forzar el refresh del token
                $googleAdsService = $this->googleAdsClient->getGoogleAdsServiceClient();
                $query = "SELECT customer.id FROM customer LIMIT 1";
                
                try {
                    $response = $googleAdsService->search(
                        (new SearchGoogleAdsRequest())
                            ->setCustomerId($this->customerId)
                            ->setQuery($query)
                    );

                    // Si llegamos aquí, el token se refrescó correctamente
                    $this->lastTokenRefresh = now();
                    
                    // Obtener el nuevo token del cliente
                    $oAuth2Credential = $this->googleAdsClient->getOAuth2Credential();
                    $this->refreshToken = $oAuth2Credential->getRefreshToken();
                    
                    Log::info('Token de Google Ads refrescado exitosamente', [
                        'customer_id' => $this->customerId
                    ]);
                    return true;
                } catch (GoogleAdsException $e) {
                    // Si el error es por token inválido, intentamos reinicializar el cliente
                    if ($this->isTokenInvalidError($e)) {
                        return $this->handleInvalidToken();
                    }
                    throw $e;
                }
            }
            return true;
        } catch (\Exception $e) {
            Log::error('Error al validar/refrescar token de Google Ads', [
                'error' => $e->getMessage(),
                'customer_id' => $this->customerId
            ]);
            throw new \RuntimeException('Error al validar el token de Google Ads: ' . $e->getMessage());
        }
    }

    /**
     * Verifica si el error es por token inválido
     */
    private function isTokenInvalidError(GoogleAdsException $e): bool
    {
        foreach ($e->getGoogleAdsFailure()->getErrors() as $error) {
            if ($error->getErrorCode()->getAuthenticationError() === AuthenticationError::INVALID_AUTHENTICATION_TOKEN) {
                return true;
            }
        }
        return false;
    }

    /**
     * Maneja el caso de token inválido
     * @return bool true si se pudo reinicializar el token, false si necesita renovación
     */
    private function handleInvalidToken(): bool
    {
        Log::warning('Token inválido detectado, intentando reinicializar el cliente', [
            'customer_id' => $this->customerId
        ]);

        try {
            // Intentar reinicializar el cliente
            $this->initializeGoogleAdsClient();
            
            // Verificar si la reinicialización fue exitosa
            $googleAdsService = $this->googleAdsClient->getGoogleAdsServiceClient();
            $query = "SELECT customer.id FROM customer LIMIT 1";
            
            $response = $googleAdsService->search(
                (new SearchGoogleAdsRequest())
                    ->setCustomerId($this->customerId)
                    ->setQuery($query)
            );

            $this->lastTokenRefresh = now();
            Log::info('Cliente de Google Ads reinicializado exitosamente', [
                'customer_id' => $this->customerId
            ]);
            return true;
        } catch (\Exception $e) {
            Log::error('Error al reinicializar el cliente de Google Ads', [
                'error' => $e->getMessage(),
                'customer_id' => $this->customerId
            ]);
            return false;
        }
    }

    /**
     * Crea una campaña completa con segmentación geográfica
     */
    public function createCampaign(array $campaignData): array
    {
        try {
            // Verificar y refrescar el token antes de comenzar
            $this->validateAndRefreshToken();

            // 1. Crear presupuesto
            $budgetResourceName = $this->createBudget(
                $campaignData['campaign_template'],
                $campaignData['daily_budget'],
                $campaignData['name_campaign'],
            );

            // 2. Crear campaña
            $campaignResourceName = $this->createCampaignResource(
                $campaignData['campaign_template'],
                $campaignData['location_data']['city'],
                $budgetResourceName,
                null,
                null,
                $campaignData['name_campaign']
            );

            // 3. Configurar horario
            $scheduleAds  = $this->addAdSchedule($campaignResourceName, $campaignData['ad_schedule']);

            // 4. Configurar targeting de ubicación
            $locationResourceName = $this->findLocationId(
                $campaignData['location_data']['city'],
                $campaignData['location_data']['state']
            );
            $this->addLocationTargeting($campaignResourceName, $locationResourceName);

            // 5. Añadir palabras clave negativas
            $this->addNegativeKeywords($campaignResourceName);

            // 6. Crear grupo de anuncios
            $adGroupResourceName = $this->createAdGroupResource(
                $campaignResourceName,
                $campaignData['campaign_template']
            );

            // 7. Añadir palabras clave
            $this->addKeywordsToAdGroup($adGroupResourceName, $campaignData['keywords']);

            // 8. Crear anuncios
            $this->createAds($adGroupResourceName, $campaignData['ads']);

            return [
                'success' => true,
                'message' => 'Campaign created successfully',
                'campaign_resource_name' => $campaignResourceName,
                'schedule_resoyrce_name' => $scheduleAds,
                'ad_group_resource_name' => $adGroupResourceName,
                'budget_resource_name' => $budgetResourceName,
                'location_resource_name' => $locationResourceName
            ];
        } catch (GoogleAdsException $e) {
            $errors = $this->processGoogleAdsException($e);
            throw new Exception(json_encode($errors));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Busca constantes geográficas por nombre de ubicación
     */
    public function findGeoTargetConstants(array $locationNames, string $locale = 'es', string $countryCode = 'US'): array
    {
        $geoTargetConstantServiceClient = $this->googleAdsClient->getGeoTargetConstantServiceClient();

        try {
            $response = $geoTargetConstantServiceClient->suggestGeoTargetConstants(
                new SuggestGeoTargetConstantsRequest([
                    'locale' => $locale,
                    'country_code' => $countryCode,
                    'location_names' => new SuggestGeoTargetConstantsRequestLocationNames(['names' => $locationNames])
                ])
            );

            $results = [];
            foreach ($response->getGeoTargetConstantSuggestions() as $suggestion) {
                $geoTargetConstant = $suggestion->getGeoTargetConstant();
                $results[] = [
                    'resource_name' => $geoTargetConstant->getResourceName(),
                    'id' => substr($geoTargetConstant->getResourceName(), strrpos($geoTargetConstant->getResourceName(), '/') + 1),
                    'name' => $geoTargetConstant->getName(),
                    'country_code' => $geoTargetConstant->getCountryCode(),
                    'status' => GeoTargetConstantStatus::name($geoTargetConstant->getStatus()),
                    'search_term' => $suggestion->getSearchTerm(),
                    'canonical_name' => $geoTargetConstant->getCanonicalName()
                ];
            }

            return $results;
        } catch (Exception $e) {
            Log::error('Error buscando constantes geográficas: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Añade targeting por proximidad (radio) a la campaña
     */
    public function addProximityTargeting(string $campaignResourceName, array $proximityData): ?string
    {
        // Validar datos requeridos
        if (empty($proximityData['radius'])) {
            Log::error('Radio no proporcionado para targeting por proximidad');
            return null;
        }

        // Crear objeto de proximidad
        $proximityInfo = new ProximityInfo([
            'radius' => (float) $proximityData['radius'],
            'radius_units' => ProximityRadiusUnits::MILES
        ]);

        // Configurar dirección básica
        $address = new AddressInfo([
            'city_name' => $proximityData['city_name'] ?? '',
            'country_code' => $proximityData['country_code'] ?? 'US'
        ]);

        if (!empty($proximityData['state'])) {
            $address->setProvinceName($proximityData['state']);
        }

        $proximityInfo->setAddress($address);

        // Crear criterio de campaña
        $campaignCriterion = new CampaignCriterion([
            'campaign' => $campaignResourceName,
            'proximity' => $proximityInfo
        ]);

        $operation = new CampaignCriterionOperation();
        $operation->setCreate($campaignCriterion);

        try {
            $response = $this->googleAdsClient->getCampaignCriterionServiceClient()->mutateCampaignCriteria(
                MutateCampaignCriteriaRequest::build($this->customerId, [$operation])
            );
            return $response->getResults()[0]->getResourceName();
        } catch (\Exception $e) {
            Log::error('Error añadiendo targeting por proximidad: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Encuentra el ID correcto de una ubicación por nombre
     */
    private function findLocationId(?string $city = null, string $state): ?string
    {
        try {
            // Si tenemos ciudad, probamos primero con "Ciudad, Estado"
            if ($city) {
                $query1 = "$city, $state";
                $results = $this->findGeoTargetConstants([$query1], 'es', 'US');

                if (!empty($results)) {
                    return $results[0]['resource_name'];
                }

                // Si no funciona, probamos solo con la ciudad
                $results = $this->findGeoTargetConstants([$city], 'es', 'US');
                if (!empty($results)) {
                    return $results[0]['resource_name'];
                }
            }

            // Finalmente probamos con el estado (en este caso Utah)
            $results = $this->findGeoTargetConstants([$state], 'es', 'US');
            if (!empty($results)) {
                return $results[0]['resource_name'];
            }

            return null;
        } catch (Exception $e) {
            Log::error("Error buscando ubicación para $city, $state: " . $e->getMessage());
            return null;
        }
    }

    public function addLocationTargeting(string $campaignResourceName, ?string $geoTargetConstant = null): ?string
    {
        if (empty($geoTargetConstant)) {
            Log::error('No se proporcionó geoTargetConstant');
            return null;
        }

        try {
            $campaignCriterion = new CampaignCriterion([
                'campaign' => $campaignResourceName,
                'location' => new LocationInfo([
                    'geo_target_constant' => $geoTargetConstant
                ]),
                'negative' => false
            ]);

            $operation = new CampaignCriterionOperation();
            $operation->setCreate($campaignCriterion);

            $response = $this->googleAdsClient->getCampaignCriterionServiceClient()->mutateCampaignCriteria(
                MutateCampaignCriteriaRequest::build($this->customerId, [$operation])
            );

            Log::info('Targeting de ubicación añadido correctamente: ' . $geoTargetConstant);
            return $response->getResults()[0]->getResourceName();
        } catch (\Exception $e) {
            Log::error('Error al añadir targeting de ubicación: ' . $e->getMessage());
            Log::error('geoTargetConstant fallido: ' . $geoTargetConstant);
            return null;
        }
    }

    /**
     * Crea un presupuesto para la campaña
     */
    public function createBudget(string $campaignName, float $dailyBudget, string $nameCampaign): string
    {

        $budget = new CampaignBudget([
            'name' => $nameCampaign,
            'delivery_method' => BudgetDeliveryMethod::STANDARD,
            'amount_micros' => $dailyBudget * 1000000,
            'explicitly_shared' => false
        ]);

        $operation = new CampaignBudgetOperation();
        $operation->setCreate($budget);

        $response = $this->googleAdsClient->getCampaignBudgetServiceClient()->mutateCampaignBudgets(
            MutateCampaignBudgetsRequest::build($this->customerId, [$operation])
        );

        return $response->getResults()[0]->getResourceName();
    }
    public function createCampaignResource(
        string $campaignTemplate,
        string $location,
        string $budgetResourceName,
        ?string $startDate = null,
        ?string $endDate = null,
        ?string $campaignName = null
    ): string {
        $campaignName = $campaignName;

        $startDate = $startDate ?? date('Ymd', strtotime('+1 day'));
        $endDate = $endDate ?? date('Ymd', strtotime('+1 year'));

        $campaign = new Campaign([
            'name' => $campaignName,
            'advertising_channel_type' => AdvertisingChannelType::SEARCH,
            'status' => CampaignStatus::ENABLED,
            'manual_cpc' => new ManualCpc(),
            'campaign_budget' => $budgetResourceName,
            'network_settings' => new NetworkSettings([
                'target_google_search' => true,
                'target_search_network' => true,
                'target_partner_search_network' => false,
                'target_content_network' => false
            ]),
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        $operation = new CampaignOperation();
        $operation->setCreate($campaign);

        $response = $this->googleAdsClient->getCampaignServiceClient()->mutateCampaigns(
            MutateCampaignsRequest::build($this->customerId, [$operation])
        );

        return $response->getResults()[0]->getResourceName();
    }


    /**
     * Añade el horario de anuncios a la campaña
     */
    private function addAdSchedule(string $campaignResourceName, array $adSchedule = null)
    {
        // Validación inicial del horario
        if (empty($adSchedule) || !isset($adSchedule['days'], $adSchedule['start_time'], $adSchedule['end_time'])) {
            Log::warning('Estructura de horario incompleta. Se usará horario predeterminado');
            $adSchedule = [
                'days' => ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY'],
                'start_time' => '08:00',
                'end_time' => '20:00'
            ];
        }

        // Validar días permitidos
        $validDays = ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY'];
        $invalidDays = array_diff($adSchedule['days'], $validDays);

        if (!empty($invalidDays)) {
            Log::error('Días no válidos en el horario', ['días_inválidos' => $invalidDays]);
            throw new \InvalidArgumentException('Días no válidos: ' . implode(', ', $invalidDays));
        }

        // Validar formato de tiempo
        $timePattern = '/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/'; // HH:MM 24h

        if (!preg_match($timePattern, $adSchedule['start_time']) || !preg_match($timePattern, $adSchedule['end_time'])) {
            Log::error('Formato de tiempo inválido', [
                'start_time' => $adSchedule['start_time'],
                'end_time' => $adSchedule['end_time']
            ]);
            throw new \InvalidArgumentException('El formato del tiempo debe ser HH:MM (24h)');
        }

        // Convertir tiempos
        [$startHour, $startMinute] = explode(':', $adSchedule['start_time']);
        [$endHour, $endMinute] = explode(':', $adSchedule['end_time']);

        // Validar rango de tiempo válido
        if ($startHour > $endHour || ($startHour == $endHour && $startMinute >= $endMinute)) {
            Log::error('Rango de tiempo inválido', [
                'start' => $adSchedule['start_time'],
                'end' => $adSchedule['end_time']
            ]);
            throw new \InvalidArgumentException('El tiempo de fin debe ser mayor al tiempo de inicio');
        }

        // Mapeo a valores de Google Ads
        $dayOfWeekMap = [
            'MONDAY' => DayOfWeek::MONDAY,
            'TUESDAY' => DayOfWeek::TUESDAY,
            'WEDNESDAY' => DayOfWeek::WEDNESDAY,
            'THURSDAY' => DayOfWeek::THURSDAY,
            'FRIDAY' => DayOfWeek::FRIDAY,
            'SATURDAY' => DayOfWeek::SATURDAY,
            'SUNDAY' => DayOfWeek::SUNDAY
        ];

        $operations = [];
        foreach ($adSchedule['days'] as $day) {
            try {
                $operations[] = new CampaignCriterionOperation([
                    'create' => new CampaignCriterion([
                        'campaign' => $campaignResourceName,
                        'ad_schedule' => new AdScheduleInfo([
                            'day_of_week' => $dayOfWeekMap[$day],
                            'start_hour' => (int)$startHour,
                            'start_minute' => MinuteOfHour::ZERO,
                            'end_hour' => (int)$endHour,
                            'end_minute' => MinuteOfHour::ZERO
                        ])
                    ])
                ]);
            } catch (\Exception $e) {
                Log::error("Error al crear horario para $day", ['error' => $e->getMessage()]);
                continue;
            }
        }

        if (empty($operations)) {
            Log::error('No se pudo crear ningún horario');
            return;
        }

        try {
            $response = $this->googleAdsClient->getCampaignCriterionServiceClient()->mutateCampaignCriteria(
                new MutateCampaignCriteriaRequest([
                    'customer_id' => $this->customerId,
                    'operations' => $operations
                ])
            );
            $resourceName = $response->getResults()[0]->getResourceName();

            Log::info('Horario configurado exitosamente', [
                'días' => $adSchedule['days'],
                'horario' => "{$adSchedule['start_time']} a {$adSchedule['end_time']}",
                'resultados' => $response->getResults()
            ]);
            return $resourceName;
        } catch (\Google\ApiCore\ApiException $e) {
            Log::error('Error de API al configurar horario', [
                'error' => $e->getMessage(),
                'details' => $e->getMetadata()
            ]);
            throw new \RuntimeException('Error al configurar el horario: ' . $e->getMessage());
        }
    }

    /**
     * Parsea y valida el formato de tiempo HH:MM
     */
    private function parseAndValidateTime(string $time): array
    {
        if (!preg_match('/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/', $time, $matches)) {
            throw new \InvalidArgumentException("Formato de tiempo inválido: {$time}. Use HH:MM");
        }

        return [
            'hour' => (int)$matches[1],
            'minute' => (int)$matches[2]
        ];
    }

    /**
     * Compara dos tiempos (array con hour y minute)
     * @return int -1 si time1 < time2, 0 si iguales, 1 si time1 > time2
     */
    private function compareTimes(array $time1, array $time2): int
    {
        if ($time1['hour'] === $time2['hour']) {
            return $time1['minute'] <=> $time2['minute'];
        }
        return $time1['hour'] <=> $time2['hour'];
    }


    public function createAdGroupResource(string $campaignResourceName, ?string $adGroupName = null, float $cpcBid = 1): string
    {
        $adGroupName = $adGroupName ?? 'Default ad group - ' . date('YmdHis');

        $adGroup = new AdGroup([
            'name' => $adGroupName,
            'campaign' => $campaignResourceName,
            'cpc_bid_micros' => $cpcBid * 3000000,
            'status' => AdGroupStatus::ENABLED
        ]);

        $operation = new AdGroupOperation();
        $operation->setCreate($adGroup);

        $response = $this->googleAdsClient->getAdGroupServiceClient()->mutateAdGroups(
            MutateAdGroupsRequest::build($this->customerId, [$operation])
        );


        return $response->getResults()[0]->getResourceName();
    }

    private function processKeywordsInput($keywordsInput): array
    {
        if (is_array($keywordsInput)) {
            return $this->cleanKeywordsArray($keywordsInput);
        }

        $keywords = json_decode($keywordsInput, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $cleanedInput = stripslashes($keywordsInput);
            $keywords = json_decode($cleanedInput, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $cleanedInput = str_replace('\"', '"', $keywordsInput);
                $cleanedInput = str_replace('\\"', '"', $cleanedInput);
                $keywords = json_decode($cleanedInput, true);
            }
        }

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($keywords)) {
            throw new \RuntimeException('Formato de keywords inválido: ' . json_last_error_msg());
        }

        return $this->cleanKeywordsArray($keywords);
    }

    private function cleanKeywordsArray(array $keywords): array
    {
        $cleanedKeywords = [];

        foreach ($keywords as $keywordData) {
            if (!isset($keywordData['text'], $keywordData['type'])) {
                continue;
            }

            $cleanedText = $this->cleanKeywordText($keywordData['text']);

            if (!empty($cleanedText)) {
                $cleanedKeywords[] = [
                    'text' => $cleanedText,
                    'type' => $keywordData['type']
                ];
            }
        }

        return $cleanedKeywords;
    }

    private function cleanKeywordText(string $text): string
    {
        $text = preg_replace('/[\\[\\]\\{\\}\\|\\^\\~\\*\\?\\<\\>\\=\\!\\&\\$\\#\\%\\+\\_\\`\\;\\:\\"\\\'\\,\\\\\\/]/', ' ', $text);
        $text = preg_replace('/\\s+/', ' ', $text);
        $text = trim($text);
        return strtolower($text);
    }

    /**
     * Añade palabras clave al grupo de anuncios
     */
    private function addKeywordsToAdGroup(string $adGroupResourceName, array $keywords): void
    {
        $keywordOperations = [];

        foreach ($keywords as $keywordData) {
            if (!isset($keywordData['text'], $keywordData['type'])) {
                throw new \RuntimeException('Formato de keyword inválido: falta "text" o "type".');
            }

            $cleanText = $this->cleanKeywordText($keywordData['text']);

            if (empty($cleanText)) {
                continue;
            }

            $matchType = $this->determineMatchType($keywordData['type']);

            $adGroupCriterion = new AdGroupCriterion([
                'ad_group' => $adGroupResourceName,
                'status' => AdGroupCriterionStatus::ENABLED,
                'keyword' => new KeywordInfo([
                    'text' => $cleanText,
                    'match_type' => $matchType
                ])
            ]);

            $operation = new AdGroupCriterionOperation();
            $operation->setCreate($adGroupCriterion);
            $keywordOperations[] = $operation;
        }

        if (!empty($keywordOperations)) {
            $adGroupCriterionService = $this->googleAdsClient->getAdGroupCriterionServiceClient();
            $chunks = array_chunk($keywordOperations, 1000);

            foreach ($chunks as $chunk) {
                $response = $adGroupCriterionService->mutateAdGroupCriteria(
                    MutateAdGroupCriteriaRequest::build($this->customerId, $chunk)
                );
                Log::info('Added ' . $response->getResults()->count() . ' keywords to ad group');
            }
        }
    }

    private function determineMatchType(string $matchType): int
    {
        switch (strtoupper($matchType)) {
            case 'EXACT':
                return KeywordMatchType::EXACT;
            case 'PHRASE':
                return KeywordMatchType::PHRASE;
            case 'BROAD':
                return KeywordMatchType::BROAD;
            default:
                return KeywordMatchType::BROAD;
        }
    }

    /**
     * Crea anuncios en el grupo de anuncios
     */
    public function createAds(string $adGroupResourceName, array $adsData): array
    {
        $operations = [];
        $adResults = [];

        foreach ($adsData as $index => $adData) {
            try {
                Log::debug("Processing ad #$index", ['ad_data' => $adData]);

                // Validar estructura básica antes de intentar crear
                if (!isset($adData['type'])) {
                    throw new \InvalidArgumentException('Missing ad type');
                }

                $ad = $this->createResponsiveSearchAd($adData, $adGroupResourceName);

                $operation = new AdGroupAdOperation();
                $operation->setCreate($ad);
                $operations[] = $operation;

                Log::info("Successfully created operation for RSA ad #$index");
            } catch (\Exception $e) {
                Log::error("Failed to create ad #$index: " . $e->getMessage(), [
                    'exception' => $e,
                    'ad_data' => $adData
                ]);
                continue;
            }
        }

        if (empty($operations)) {
            $errorMsg = 'No se pudo crear ningún anuncio. Razones posibles: ';
            $errorMsg .= '1) Textos muy largos, 2) Faltan headlines/descriptions, 3) URLs inválidas';

            Log::error($errorMsg, [
                'ads_data' => $adsData,
                'ad_group' => $adGroupResourceName
            ]);

            throw new \RuntimeException($errorMsg);
        }

        try {
            $response = $this->googleAdsClient->getAdGroupAdServiceClient()->mutateAdGroupAds(
                MutateAdGroupAdsRequest::build($this->customerId, $operations)
            );

            foreach ($response->getResults() as $result) {
                $adResults[] = $result->getResourceName();
            }

            return $adResults;
        } catch (\Exception $e) {
            Log::error("Google Ads API error: " . $e->getMessage());
            throw new \RuntimeException('Error al comunicarse con Google Ads API');
        }
    }

    private function createResponsiveSearchAd(array $adData, string $adGroupResourceName): AdGroupAd
    {
        // Validación de campos requeridos (se mantiene igual)
        if (empty($adData['headlines']) || count($adData['headlines']) < 3) {
            throw new \InvalidArgumentException('Se requieren al menos 3 headlines');
        }

        if (empty($adData['descriptions']) || count($adData['descriptions']) < 2) {
            throw new \InvalidArgumentException('Se requieren al menos 2 descriptions');
        }

        if (empty($adData['final_url']) || !filter_var($adData['final_url'], FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('URL final inválida');
        }

        // Procesar headlines (se mantiene igual)
        $headlineAssets = [];
        foreach ($adData['headlines'] as $headline) {
            if (!isset($headline['text'])) {
                continue;
            }

            $text = substr(trim($headline['text']), 0, 30);
            if (!empty($text)) {
                $headlineAssets[] = new \Google\Ads\GoogleAds\V19\Common\AdTextAsset([
                    'text' => $text
                ]);
            }
        }

        // Procesar descriptions con soporte para customizers
        $descriptionAssets = [];
        foreach ($adData['descriptions'] as $description) {
            if (!isset($description['text'])) {
                continue;
            }

            $text = substr(trim($description['text']), 0, 90);
            if (!empty($text)) {
                // Verificar si hay placeholders de customizer
                if (str_contains($text, '{CUSTOMIZER.')) {
                    // Validar que tenemos los atributos necesarios
                    if (empty($adData['customizer_attributes'])) {
                        throw new \InvalidArgumentException(
                            'Se encontró un placeholder de customizer pero no se proporcionaron atributos'
                        );
                    }

                    // Aquí deberías verificar que el atributo referenciado existe en customizer_attributes
                    // y que tiene el formato correcto
                }

                $descriptionAssets[] = new \Google\Ads\GoogleAds\V19\Common\AdTextAsset([
                    'text' => $text
                ]);
            }
        }

        // Verificación final de assets (se mantiene igual)
        if (count($headlineAssets) < 3) {
            throw new \InvalidArgumentException('Se requieren al menos 3 headlines válidos');
        }

        if (count($descriptionAssets) < 2) {
            throw new \InvalidArgumentException('Se requieren al menos 2 descriptions válidas');
        }

        // Crear el RSA
        $responsiveSearchAd = new \Google\Ads\GoogleAds\V19\Common\ResponsiveSearchAdInfo([
            'headlines' => $headlineAssets,
            'descriptions' => $descriptionAssets,
            'path1' => $adData['path1'] ?? null,
            'path2' => $adData['path2'] ?? null
        ]);

        // Crear el objeto Ad principal
        $ad = new \Google\Ads\GoogleAds\V19\Resources\Ad([
            'responsive_search_ad' => $responsiveSearchAd,
            'final_urls' => [$adData['final_url']]
        ]);

        // Crear y retornar el AdGroupAd
        return new \Google\Ads\GoogleAds\V19\Resources\AdGroupAd([
            'ad_group' => $adGroupResourceName,
            'status' => \Google\Ads\GoogleAds\V19\Enums\AdGroupAdStatusEnum\AdGroupAdStatus::PAUSED,
            'ad' => $ad
        ]);
    }


    public function listManagedAccounts(): array
    {
        try {
            // Validar el token antes de hacer la consulta
            if (!$this->validateAndRefreshToken()) {
                throw new \RuntimeException('El token de acceso ha expirado y no se pudo renovar. Por favor, vuelve a iniciar sesión.');
            }

            // Usar GoogleAdsServiceClient en lugar de CustomerServiceClient
            $googleAdsService = $this->googleAdsClient->getGoogleAdsServiceClient();

            $query = "SELECT customer_client.client_customer, customer_client.descriptive_name 
                   FROM customer_client 
                   WHERE customer_client.level = 1";

            // Crear la solicitud de búsqueda correctamente
            $request = new SearchGoogleAdsRequest([
                'customer_id' => $this->customerId,
                'query' => $query
            ]);

            $response = $googleAdsService->search($request);

            $accounts = [];
            foreach ($response->iterateAllElements() as $row) {
                $customerClient = $row->getCustomerClient();
                $accounts[] = [
                    'customer_id' => $customerClient->getClientCustomer(),
                    'name' => $customerClient->getDescriptiveName(),
                ];
            }

            return $accounts;
        } catch (\Exception $e) {
            Log::error('Error al listar cuentas administradas', [
                'error' => $e->getMessage(),
                'customer_id' => $this->customerId
            ]);
            throw new \RuntimeException('Error al listar cuentas administradas: ' . $e->getMessage());
        }
    }
    public function processGoogleAdsException(GoogleAdsException $googleAdsException): array
    {
        $errors = [];
        foreach ($googleAdsException->getGoogleAdsFailure()->getErrors() as $error) {
            $errors[] = [
                'error_code' => $error->getErrorCode()->getErrorCode(),
                'message' => $error->getMessage(),
                'trigger' => $error->getTrigger(),
                'location' => $error->getLocation()
            ];
        }
        return $errors;
    }

    private function loadNegativeKeywords(): array
    {
        $negativeKeywordsPath = base_path('app/Data/negative_keywords.json');
        if (!file_exists($negativeKeywordsPath)) {
            Log::error('Archivo de palabras clave negativas no encontrado');
            return [];
        }

        $negativeKeywords = json_decode(file_get_contents($negativeKeywordsPath), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Error al decodificar el archivo de palabras clave negativas');
            return [];
        }

        $allNegativeKeywords = [];
        
        // Combinar todas las palabras clave negativas en un solo array
        foreach ($negativeKeywords as $category) {
            if (is_array($category)) {
                foreach ($category as $subcategory) {
                    if (is_array($subcategory)) {
                        $allNegativeKeywords = array_merge($allNegativeKeywords, $subcategory);
                    }
                }
            }
        }

        // Eliminar duplicados y ordenar
        $allNegativeKeywords = array_unique($allNegativeKeywords);
        sort($allNegativeKeywords);

        return $allNegativeKeywords;
    }

    private function addNegativeKeywords(string $campaignResourceName): void
    {
        try {
            $negativeKeywords = $this->loadNegativeKeywords();
            if (empty($negativeKeywords)) {
                Log::warning('No se encontraron palabras clave negativas para añadir');
                return;
            }

            $operations = [];
            foreach ($negativeKeywords as $keyword) {
                $campaignCriterion = new CampaignCriterion([
                    'campaign' => $campaignResourceName,
                    'negative' => true,
                    'keyword' => new KeywordInfo([
                        'text' => $keyword,
                        'match_type' => KeywordMatchType::BROAD
                    ])
                ]);

                $operation = new CampaignCriterionOperation();
                $operation->setCreate($campaignCriterion);
                $operations[] = $operation;
            }

            if (!empty($operations)) {
                $response = $this->googleAdsClient->getCampaignCriterionServiceClient()->mutateCampaignCriteria(
                    MutateCampaignCriteriaRequest::build($this->customerId, $operations)
                );
                Log::info('Palabras clave negativas añadidas exitosamente', [
                    'count' => count($operations)
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error al añadir palabras clave negativas: ' . $e->getMessage());
        }
    }
}
