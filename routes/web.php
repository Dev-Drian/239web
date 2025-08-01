<?php


use App\Http\Controllers\ClientController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AirlabsController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CitationController;
use App\Http\Controllers\GoogleAdsCampaignController;
use App\Http\Controllers\ImageGeneratorController;
use App\Http\Controllers\ImageGeneratorUserController;
use App\Http\Controllers\IndexerController;
use App\Http\Controllers\KeywordsController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GenerateController;
use App\Http\Controllers\GoogleAuth2Controller;
use App\Models\Blog;
use App\Models\Client;
use App\Models\Task;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/login/{id}', function ($id) {


    $client = Client::where('highlevel_id', $id)->first();

    if (!$client) {
        return view('clients.client_404');
    }


    // Buscar el usuario asociado
    $user = User::where('client_id', $client->id)->first();

    // Si el usuario no existe, crearlo
    $user = User::updateOrCreate(
        ['email' => $client->email], // Condición para encontrar el usuario
        [
            'name' => $client->name,
            'password' => bcrypt('password'), // Asegúrate de cambiar esto a una contraseña segura
            'client_id' => $client->id,
        ]
    );


    // Iniciar sesión con el usuario
    Auth::login($user);

    // Redirigir al dashboard
    return redirect()->route('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $clients = Client::all();
        $blogs = Blog::all();
        $tasks = Task::all();

        return view('dashboard', compact('clients', 'blogs', 'tasks'));
    })->name('dashboard');
});

Route::get('/mail', function () {
    return view('mail.index');
})->name('mail.index');

Route::get('/auth/google/callback', [GoogleAuth2Controller::class, 'callback'])->name('google.callback');
Route::get('/google/login/{id}', [GoogleAuth2Controller::class, 'redirectToGoogle'])->name('google.login');

Route::prefix('239web')->group(function () {

    Route::middleware(['auth:sanctum', config('jetstream.auth_session')])->group(function () {
        Route::prefix('/client')->group(function () {
            Route::get('/', [ClientController::class, 'index'])->name('client.index');
            Route::get('/seo-table', [ClientController::class, 'seoTable'])->name('seo.table');
            Route::post('/create', [ClientController::class, 'create'])->name('client.create');
            Route::post('/update-status', [ClientController::class, 'updateStatus'])->name('client.updateStatus');
            Route::post('/update-remote-page-id', [ClientController::class, 'updateRemotePageId'])->name('client.updateRemotePageId');
            Route::post('/delete', [ClientController::class, 'delete'])->name('client.delete');
            Route::get('/sync_client', [ClientController::class, 'sync_client'])->name('client.sync');
            Route::post('/', [ClientController::class, 'store'])->name('client.store');

            Route::get('/{client}', [ClientController::class, 'show'])->name('client.show');
            Route::put('/{client}', [ClientController::class, 'update'])->name('client.update');

            Route::put('/client/{id}/press-release', [ClientController::class, 'pressRelease'])->name('client.pressRelease');
        });

        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('users.index');
            Route::post('/', [UserController::class, 'store'])->name('users.store');
            Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        });

        Route::get('/management-client', [ClientController::class, 'load_client'])->name('load-client');

        Route::get('/api/sincronizar-datos', [AirlabsController::class, 'sincronizarDatos'])->name('sincronizar-datos');
        Route::get('/airport', [AirlabsController::class, 'index'])->name('airlabs.index');
        Route::get('/sincronizar-paises', [AirlabsController::class, 'sincronizarPaises'])->name('sincronizar-paises');
        Route::get('/sincronizar-ciudades', [AirlabsController::class, 'sincronizarCiudades'])->name('sincronizar-ciudades');

        Route::get('/keywords', [KeywordsController::class, 'index'])->name('keyword.index');
        Route::get('/analysis', [AnalysisController::class, 'index'])->name('analysis.index');

        Route::get('/google', [GoogleAdsCampaignController::class, 'index'])->name('google.index');

        Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
        Route::get('/citations', [CitationController::class, 'index'])->name('citations.index');
        Route::get('/citation', [CitationController::class, 'show'])->name('citations.show');
        Route::post('/process-citation-order', [CitationController::class, 'processCitationOrder'])->name('process.citation');


        Route::prefix('/board')->group(function () {
            Route::get('/', [BoardController::class, 'index'])->name('board.index');
            Route::get('/{id}', [BoardController::class, 'show'])->name('board.show');
            // Route::post('/{id}', [BoardController::class, 'update'])->name('board.update');
        });
        Route::get('/alltask', [BoardController::class, 'allTaskBoard'])->name('board.all');

        Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
        Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');

        Route::prefix('/indexer')->group(function () {
            Route::get('/', [IndexerController::class, 'index'])->name('indexer.index');
            Route::post('/', [IndexerController::class, 'processSitemap'])->name('indexer.extract');
            Route::get('/data', [IndexerController::class, 'show'])->name('indexer.show');
            Route::post('/sumbit_campaña', [IndexerController::class, 'submitCampaña'])->name('indexer.submit');
        });

        // routes/web.php
        //ruta para la generacion de imagenes desde una cuenta admin
        Route::get('/images', [ImageGeneratorUserController::class, 'index'])->name('imagesUser.index');


        Route::get('/generate-content', [GenerateController::class, 'index'])->name('generate.index');
    });


    Route::prefix('campaigns')->group(function () {
        Route::get('/create/{id}', [GoogleAdsCampaignController::class, 'create'])->name('campaigns.create');
        Route::get('/login/{id}', [GoogleAdsCampaignController::class, 'login'])->name('campaigns.login');
        Route::post('/{id}', [GoogleAdsCampaignController::class, 'store'])->name('campaigns.store');
    });

    Route::get('/keyword-position', [KeywordsController::class, 'index'])->name('keyword-position.index');
    Route::post('/keyword-position/process', [KeywordsController::class, 'process'])->name('keyword-position.process');



    //rutas guest flig
    Route::get('/request', [AirlabsController::class, 'request'])->name('show.request');
    Route::get('/request/{id}', [AirlabsController::class, 'request_guest'])->name('guest.request');
    Route::get('/request/{id}/info', [AirlabsController::class, 'showFlight'])->name('guest.request.info');


    Route::get('/flights', [AirlabsController::class, 'getFlights'])->name('get-flights');
    /// procees lead
    Route::get('/leads/{id} ', [LeadController::class, 'show'])->name('lead.show');

    Route::get('/keywords/{id}', [KeywordsController::class, 'index_guest'])->name('keyword.index_guest');
    Route::get('/keywords/show/{id}', [KeywordsController::class, 'show'])->name('keyword.show');

    Route::get('/images/{id}', [ImageGeneratorController::class, 'index'])->name('images.index');



    Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('/blog/create/{id}', [BlogController::class, 'create'])->name('blog.create');
    Route::post('/blog/{id}', [BlogController::class, 'store'])->name('blog.store');

    Route::get('/area/{id}', [AreaController::class, 'index'])->name('area.index');

    // Ruta para refrescar el token de Google Ads
    Route::post('/api/refresh-google-ads-token', [GoogleAdsCampaignController::class, 'refreshToken'])
        ->name('google-ads.refresh-token');
});

Route::view('/privacy-policy', 'privacy-policy')->name('privacy.policy');
Route::view('/terms-of-service', 'terms-of-service')->name('terms.service');
