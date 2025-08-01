<?php

use App\Http\Controllers\AirlabsController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientLocationController;
use App\Http\Controllers\DataForSeoController;
use App\Http\Controllers\GenerateContentController;
use App\Http\Controllers\GenerateController;
use App\Http\Controllers\GoogleAdsCampaignController;
use App\Http\Controllers\IdentityVerificationController;
use App\Http\Controllers\ImageGeneratorController;
use App\Http\Controllers\ImageGeneratorUserController;
use App\Http\Controllers\KeywordsController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ValueSerpBatchController;
use App\Http\Controllers\WebhookController;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/valid-user', function (Request $request) {
    $client = Client::where('highlevel_id', $request->id)->first();

    if (!$client) {
        return response()->json(['message' => 'User is not authenticated'], 401);
    }

    return response()->json(['message' => 'User is authenticated'], 200);
});
Route::post('/client/update-select-page/{id}', [ClientController::class, 'updaupdateSelectPage'])->name('client.updateSelectPage');


Route::get('/airports', [AirlabsController::class, 'getSelectAiports'])->name('api.airports');
Route::get('/api/airlines', [AirlabsController::class, 'getSelectAirlines'])->name('api.airlines');
Route::get('/api/airlines', [AirlabsController::class, 'getSelectAirlines'])->name('api.airlines');

// api para select 2 ciudades
Route::get('/city', [CityController::class, 'getSelectCities'])->name('api.cities');
Route::get('/pruebas', [CityController::class, 'getCity'])->name('api.citi');



Route::post('/process-leads', [LeadController::class, 'processLeads']);
Route::post('/webhook/reserva', [WebhookController::class, 'recibirReserva'])->name('webhook.reserva');
Route::post('/register_subcription', [WebhookController::class, 'storeSubscription'])->name('webhook.subripcion');

Route::prefix('identity-verification')->group(function () {
    Route::get('/{id}', [IdentityVerificationController::class, 'index'])->name('identity.index');
    Route::post('/{id}', [IdentityVerificationController::class, 'store'])->name('identity.store');
});

Route::prefix('/keyword')->group(function () {
    Route::post('/', [KeywordsController::class, 'analizeKeywords'])->name('keyword.analize');
});
Route::prefix('/batch')->group(function () {
    Route::post('/create/{id}', [ValueSerpBatchController::class, 'createBatch'])->name('batch.create');
    Route::get('/status/{batchId}', [ValueSerpBatchController::class, 'getBatchStatus'])->name('batch.status');
    Route::get('/run/{batchId}', [ValueSerpBatchController::class, 'runBatch'])->name('batch.run');
});



Route::prefix('/keywords')->group(function () {

    Route::post('/position/{id}', [KeywordsController::class, 'processKeyword'])->name('keyword.position');
    Route::post('/save/{id}', [KeywordsController::class, 'saveResults'])->name('keyword.save');
    Route::get('/history/{id}', [KeywordsController::class, 'getHistory'])->name('keyword.history');
    Route::post('/search-volume/{id}', [DataForSeoController::class, 'searchVolume'])->name('dataforseo.search_volume');
});

Route::prefix('/image')->group(function () {
    Route::post('/generate/{id}', [ImageGeneratorController::class, 'generate'])->name('image.generate');
    Route::delete('/delete/{id}', [ImageGeneratorController::class, 'delete'])->name('image.delete');
    Route::post('/rename/{id}', [ImageGeneratorController::class, 'rename'])->name('image.rename');

    Route::middleware('web')->group(function () {
        Route::post('/generateUser', [ImageGeneratorUserController::class, 'generate'])->name('imageUser.generate');
        Route::delete('/deleteUser/{id}', [ImageGeneratorUserController::class, 'delete'])->name('imageUser.delete');
        Route::post('/renameUser/{id}', [ImageGeneratorUserController::class, 'rename'])->name('imageUser.rename');
    });
});


Route::prefix('/generate-content')->group(function () {
    Route::post('/gpt', [GenerateContentController::class, 'generateContentGPT'])->name('generate-content.gpt');
    Route::post('/perplexity', [GenerateContentController::class, 'generateContentPerplexity'])->name('generate-content.perplexity');

    Route::post('/meta-title', [GenerateContentController::class, 'generateMetaTitle'])->name('generate-meta-title');
    Route::post('/meta-description', [GenerateContentController::class, 'generateMetaDescription'])->name('generate-meta-description');
    Route::post('/extra-blog', [GenerateContentController::class, 'generateExtraBlog'])->name('generate-extra-blog');
    Route::post('/Nearby-CitiesAndAirports/{id}', [GenerateContentController::class, 'generateNearbyCitiesAndAirports'])->name('generate-nearby-cities-and-airports');

    Route::post('/long', [GenerateContentController::class, 'generateContentLong'])->name('generate.content.long');
    Route::post('/short', [GenerateContentController::class, 'generateContentShort'])->name('generate.content.short');
    Route::post('/spun', [GenerateContentController::class, 'generateContentSpun'])->name('generate.content.spun');
    Route::post('/keywords', [GenerateContentController::class, 'generateContentKeywords'])->name('generate.content.keywords');

    Route::post('/generate-ads', [GenerateContentController::class, 'generateAds'])->name('generate.ads');


    
    Route::post('/chat', [GenerateController::class, 'chat'])->name('generate.chat');
});


Route::post('/blog/submitUrls/{id}', [SitemapController::class, 'submitUrls'])->name('blog.submitUrls');

Route::post(
    '/normalizeLocation',
    [GoogleAdsCampaignController::class, 'normalizeLocation']
)->name('api.normalizeLocation');

Route::get('/campaings/list/{id}', [GoogleAdsCampaignController::class, 'listCampaigns'])->name('campaings.list');



Route::prefix('/area')->group(function () {
    Route::post('/store/{id}', [AreaController::class, 'storeArea'])->name('area.store');
    Route::post('/storefleet/{id}', [AreaController::class, 'storeFleet'])->name('fleet.store');
    Route::post('/client-locations', [ClientLocationController::class, 'store'])->name('area.store.client-locations');
});

// Ruta para refrescar el token de Google Ads
Route::post('/google-ads/refresh-token', [GoogleAdsCampaignController::class, 'refreshToken'])
    ->name('api.google-ads.refresh-token');
