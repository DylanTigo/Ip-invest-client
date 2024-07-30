<?php

use App\Http\Controllers\Client\ActualiteController;
use App\Http\Controllers\Client\ArchiveController;
use App\Http\Controllers\Client\UserController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\DashboardController;
use App\Http\Controllers\Client\EvenementController;
use App\Http\Controllers\Client\ExpertController;
use App\Http\Controllers\Client\InvestissementController;
use App\Http\Controllers\Client\SecteurController;
use App\Http\Controllers\Client\MessageController;
use App\Http\Controllers\Client\ProfilInvestisseurController;
use App\Http\Controllers\Client\ProjetController;
use App\Http\Controllers\Client\PrivilegeController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\NewsletterController;
use App\Http\Controllers\Client\ProfilPorteurProjetController;
use App\Http\Controllers\Client\TransactionController;


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

Route::middleware(['auth'])->group(function () {

    // Route::view('/dashboard', 'pages.dashboard.home')->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'countproject'])->name('dashboard');

    Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('home');
        Route::get('/{id}', [MessageController::class, 'index2'])->name('view');
        Route::get('/delete/message/{id}', [MessageController::class, 'deleteMessage'])->name('delete');
        Route::post('/{sender}/send/{receiver}', [MessageController::class, 'newConversation'])->name('new');
        Route::get('/{id}/{receiver}/{conversation}', [MessageController::class, 'index2'])->name('view.conversation');
        Route::get('/{id}/{conversation}', [MessageController::class, 'openConversation'])->name('conversation');
        Route::post('/{sender}/{conversation}/send/{receiver}', [MessageController::class, 'send'])->name('send');
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', function () {
            return redirect()->route('user.administrateur');
        })->name('home');
        Route::get('/add/{id}', [UserController::class, 'add'])->name('add');
        Route::get('/{id}/report', [UserController::class, 'getReport'])->name('report');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [UserController::class, 'delete'])->name('delete');
        Route::get('/sous_administrateur', [UserController::class, 'sous_administrateur'])->name('sous_administrateur');
        Route::get('/administrateur', [UserController::class, 'administrateur'])->name('administrateur');
        Route::get('/conseiller', [UserController::class, 'conseille'])->name('conseiller');
        Route::get('/porteur-projet', [UserController::class, 'porteurProjet'])->name('porteur.projet');
        Route::get('/investisseur', [UserController::class, 'investisseur'])->name('investisseur');
        Route::get('/profile/{id?}', [UserController::class, 'show'])->name('profile');
        Route::get('/profile/{id}/edit', [UserController::class, 'editProfil'])->name('profile.edit');
        Route::post('/profile/{id?}/update', [UserController::class, 'updateProfile'])->name('profile.update');
        Route::post('/profile/{id}/update/password', [UserController::class, 'updatePassword'])->name('profile.update.password');
        // Route::post('/', [UserController::class, 'store'])->name('add');
        // Route::post('/{id?}', [UserController::class, 'store'])->name('update');
    });

    Route::prefix('profil-investisseur')->name('profil.investisseur.')->group(function () {
        Route::get('/', [ProfilInvestisseurController::class, 'index'])->name('home');
        Route::get('/add', [ProfilInvestisseurController::class, 'add'])->name('add');
        Route::post('/store', [ProfilInvestisseurController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ProfilInvestisseurController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ProfilInvestisseurController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [ProfilInvestisseurController::class, 'delete'])->name('delete');
    });

    Route::prefix('profil-porteur-projet')->name('profil.porteur.')->group(function () {
        Route::get('/', [ProfilPorteurProjetController::class, 'index'])->name('home');
        Route::get('/add', [ProfilPorteurProjetController::class, 'add'])->name('add');
        Route::post('/store', [ProfilPorteurProjetController::class, 'store'])->name('store');
        Route::get('/edit/{type}', [ProfilPorteurProjetController::class, 'edit'])->name('edit');
        Route::post('/update/{type}', [ProfilPorteurProjetController::class, 'update'])->name('update');
        Route::get('/delete/{type}', [ProfilPorteurProjetController::class, 'delete'])->name('delete');
    });

    Route::prefix('investissement')->name('investissement.')->group(function () {
        Route::get('/', [InvestissementController::class, 'index'])->name('home');
        Route::get('/add', [InvestissementController::class, 'add'])->name('add');
        Route::post('/store', [InvestissementController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [InvestissementController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [InvestissementController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [InvestissementController::class, 'delete'])->name('delete');
    });

    Route::prefix('category')->name('category.')->group(function () {
        Route::get('/', [SecteurController::class, 'index'])->name('home');
        Route::get('/add', [SecteurController::class, 'add'])->name('add');
        Route::get('/edit/{id}', [SecteurController::class, 'edit'])->name('edit');
        Route::post('/store', [SecteurController::class, 'store'])->name('store');
        Route::post('/update/{id}', [SecteurController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [SecteurController::class, 'delete'])->name('delete');
    });

    Route::prefix('slider')->name('slider.')->group(function () {
        Route::get('/', [HomeController::class, 'HomeSlider'])->name('home');
        Route::get('/add', [HomeController::class, 'AddSlide'])->name('add');
        Route::get('/edit/{id}', [HomeController::class, 'EditSlide'])->name('edit');
        Route::post('/store', [HomeController::class, 'StoreSlide'])->name('store');
        Route::post('/update/{id}', [HomeController::class, 'UpdateSlide'])->name('update');
        Route::get('/delete/{id}', [HomeController::class, 'DeleteSlide'])->name('delete');
    });

    Route::prefix('partenaires')->name('partenaires.')->group(function () {
        Route::get('/', [HomeController::class, 'HomePartenaires'])->name('home');
        Route::post('/store', [HomeController::class, 'StorePartenaires'])->name('store');
        Route::get('/delete/{id}', [HomeController::class, 'DeletePartenaire'])->name('delete');
    });

    Route::prefix('newsletter')->name('newsletter.')->group(function () {
        Route::get('/', [NewsletterController::class, 'index'])->name('home');
        Route::get('/mails', [NewsletterController::class, 'mails'])->name('mails');
        Route::get('/add', [NewsletterController::class, 'add'])->name('add');
        Route::post('/store', [NewsletterController::class, 'store'])->name('store');
        Route::get('/delete/{id}', [NewsletterController::class, 'delete'])->name('delete');
        Route::get('/delete/email/{id}', [NewsletterController::class, 'deleteEmail'])->name('email.delete');
        Route::get('/edit/{id}', [NewsletterController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [NewsletterController::class, 'update'])->name('update');
        Route::get('/send/{id}', [NewsletterController::class, 'send'])->name('send');
        Route::get('/sendme/{id}', [NewsletterController::class, 'sendme'])->name('sendme');
        Route::get('/{id}', [NewsletterController::class, 'show'])->name('show');
    });

    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [EvenementController::class, 'index'])->name('home');
        Route::get('/add', [EvenementController::class, 'add'])->name('add');
        Route::post('/store', [EvenementController::class, 'store'])->name('store');
        Route::get('/delete/participant/{id}', [EvenementController::class, 'deleteParticipant'])->name('delete.participant');
        Route::get('/show/participant/{id}', [EvenementController::class, 'showParticipant'])->name('show.participant');
        Route::get('/delete/{id}', [EvenementController::class, 'delete'])->name('delete');
        Route::get('/edit/{id}', [EvenementController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [EvenementController::class, 'update'])->name('update');
        Route::get('/{id}', [EvenementController::class, 'show'])->name('show');
        Route::get('events/{event}/deleteImage', [EvenementController::class, 'deleteImage'])->name('events.deleteImage');
        Route::get('events/{event}/deleteFile', [EvenementController::class, 'deleteFile'])->name('events.deleteFile');
        Route::get('events/{event}/deletePartenaire/{partenaire}', [EvenementController::class, 'deletePartenaire'])->name('events.deletePartenaire');
   
    });

    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('home');
        Route::get('/delete/{id}', [TransactionController::class, 'delete'])->name('delete');
    });

    Route::prefix('actualites')->name('actualites.')->group(function () {
        Route::get('/{type}/{id}', [ActualiteController::class, 'index'])->name('home');
        Route::get('/add/{type}/{id}', [ActualiteController::class, 'add'])->name('add');
        Route::get('/edit/{type}/{id}/{idPS}', [ActualiteController::class, 'edit'])->name('edit');
        Route::post('/update/{type}/{id}/{idPS}', [ActualiteController::class, 'update'])->name('update');
        Route::get('/details/show/{type}/{id}/{idPS}', [ActualiteController::class, 'showDetails'])->name('details');
        Route::post('/store/{type}/{id}', [ActualiteController::class, 'store'])->name('store');
        Route::get('/delete/{type}/{id}/{idPS}', [ActualiteController::class, 'delete'])->name('delete');
    });

    Route::prefix('experts')->name('experts.')->group(function () {
        Route::get('/', [ExpertController::class, 'index'])->name('home');
        Route::get('/add', [ExpertController::class, 'add'])->name('add');
        Route::get('/edit/{id}', [ExpertController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ExpertController::class, 'update'])->name('update');
        Route::post('/store', [ExpertController::class, 'store'])->name('store');
        Route::get('/delete/{id}', [ExpertController::class, 'delete'])->name('delete');
    });

    Route::prefix('archive')->name('archive.')->group(function () {
        Route::get('/delete/projet/{id}', [ArchiveController::class, 'deleteProjectDocument'])->name('delete.projet');
    });

    Route::prefix('projet')->name('projet.')->group(function () {
        Route::get('/', [ProjetController::class, 'index'])->name('home');
        Route::get('/ip', [ProjetController::class, 'index_ip'])->name('home_ip');
        Route::get('/secteur/{secteur}', [ProjetController::class, 'index_secteur'])->name('home_secteur');
        Route::get('/place/{ville}', [ProjetController::class, 'index_ville'])->name('home_ville');
        Route::get('/etat/{etat}', [ProjetController::class, 'index_etat'])->name('home_etat');
        Route::get('/add', [ProjetController::class, 'add'])->name('add');
        Route::get('/archives', [ProjetController::class, 'archives'])->name('archives');
        Route::get('/edit/{id}', [ProjetController::class, 'edit'])->name('edit');
        Route::post('/store', [ProjetController::class, 'store'])->name('store');
        Route::get('/delete/{id}', [ProjetController::class, 'delete'])->name('delete');
        Route::post('/update/{id}', [ProjetController::class, 'update'])->name('update');
        Route::get('/publish/{id}', [ProjetController::class, 'publish'])->name('publish');
        Route::get('/cloture/{id}', [ProjetController::class, 'cloture'])->name('cloture');
        Route::get('/ask/infosupp/{id}', [ProjetController::class, 'typemessage'])->name('askinfosupp');
        Route::get('/admin/validate/{id}', [ProjetController::class, 'AdminValidate'])->name('admin.validate');
        Route::post('/admin/infosupp/{id}', [ProjetController::class, 'AdminInfoSupp'])->name('admin.infosupp');
        Route::post('/infosupp/{id}', [ProjetController::class, 'CIInfoSupp'])->name('ci.infosupp');
        Route::get('/validate/{id}', [ProjetController::class, 'CIValidate'])->name('civalidate');
        Route::get('/rejet/{id}', [ProjetController::class, 'Rejeter'])->name('rejet');
        Route::get('/{id}', [ProjetController::class, 'showp'])->name('details');
    });


    Route::get('/add/writer', [PrivilegeController::class, 'InsertWriter'])->name('add.writer');
    Route::get('/all/writer', [PrivilegeController::class, 'AllWriter'])->name('all.writer');
    Route::post('/store/writer', [PrivilegeController::class, 'StoreWriter'])->name('store.writer');
    Route::get('/edit/writer/{privilege}', [PrivilegeController::class, 'EditWriter'])->name('edit.writer');
    Route::post('/update/{privilege}', [PrivilegeController::class, 'UpdateWriter'])->name('update.writer');
    Route::get('/delete/writer/{privilege}', [PrivilegeController::class, 'DeleteWriter'])->name('delete.writer');

    Route::get('/get/user/{user_id}', [SecteurController::class, 'GetUserEdit']);
});

