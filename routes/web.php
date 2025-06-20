<?php



use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;


require "sub_route/home_routes.php";

require "sub_route/animals_subroute.php";


require "sub_route/rdv_subroute.php";


require "sub_route/doctopet-pro_subroute.php";

require "sub_route/pro_subroute.php";


require "sub_route/assistant_subroute.php";

require "sub_route/conversation_subroute.php";

require "sub_route/task_subroute.php";

require "sub_route/docs_subroute.php";

require "sub_route/urgence_routes.php";

require "sub_route/email_subroute.php";

require "sub_route/compta_subroute.php";

require "sub_route/stock_subroute.php";

require "sub_route/legal_subroute.php";


//require "sub_route/password_preprod_route.php";

Route::get("/profil/{id}",[\App\Http\Controllers\ProfilController::class,'index'])
    ->middleware(['auth', 'verified'])
    ->name("profil");


Route::get('/presentation', [\App\Http\Controllers\PresentationController::class, 'index'])
    ->name('presentation');


Route::middleware(['auth'])->group(function () {
    Route::get('/mes-documents', [\App\Http\Controllers\DocumentController::class,'ClientView'])->name('client.documents');
});






Route::get("/gestions/patients/",[\App\Http\Controllers\GestionDesPatientsController::class,'overview'])
    ->middleware("auth")
    ->name("gestion.patients");

Route::get("/cooperation/",[\App\Http\Controllers\CooperationController::class,'Overview'])
    ->middleware("auth")
    ->name("cooperation");


Route::get("/sortie/prochainement/",function (){
    return view("waiting_release");
})
->name("waiting");


Route::get("/search/pro",[\App\Http\Controllers\RechercheProController::class,'index'])
    ->name("search.pro.name");




Route::get('/pet-sitter-appointment/{animalId}/{specialiteId}/{serviceTypeId}/{serviceTemplateId}', [\App\Http\Controllers\PetSitterAppointmentController::class,'index'])
    ->name('pet.sitter.appointment');


Route::post('/ambassador/verify', [\App\Http\Controllers\AmbassadeurController::class, 'verifyAccessCode'])
    ->name('ambassador.verify');


require "sub_route/eleveur_subroute.php";

require "sub_route/admin_subroute.php";


Route::get("/doctopet/simulation",[\App\Http\Controllers\DoctopetSimulatorController::class,'index'])
    ->name("doctopet.simulateur");


use App\Http\Controllers\PlanController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\SubscriptionController;

Route::middleware("auth")->group(function () {
    Route::get('/plans', [PlanController::class, 'index'])->name("plans");
    Route::get('/plans/{plan}', [PlanController::class, 'show'])->name("plans.show");
    Route::post('/subscription', [PlanController::class, 'subscription'])->name("subscription.create");
    Route::post('/subscription/cancel', [PlanController::class, 'cancelSubscription'])->name('subscription.cancel');

    //Route::get("/subscription")
    Route::post('/check-referral', [SubscriptionController::class, 'checkReferral'])->name('check.referral');

    // ✅ Ajout de la route subscription.index manquante
    Route::get('/settings', [SubscriptionController::class, 'index'])->name('subscription.index');
});

// ✅ Routes de Paiement
Route::get("/paiement/", [PaiementController::class, 'showPaymentForm'])->middleware("auth")->name("paiement");
Route::post('/paiement/intent', [PaiementController::class, 'createSubscriptionIntent'])->name('payment.intent');
Route::get('/paiement/success', [PaiementController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/paiement/cancel', [PaiementController::class, 'paymentCancel'])->name('payment.cancel');


Route::get("/gérer/mes-fichiers",[\App\Http\Controllers\FilesManagerProController::class,'index'])
    ->middleware("auth")
    ->name("manage_files_pro");


Route::get("/information/abonnement-doctopet",[\App\Http\Controllers\AboutController::class,'InformationServicesSubscription'])
    ->name("about.subscription");



Route::get("/clinique/{id}",[\App\Http\Controllers\CliniqueController::class,'index'])
    ->middleware("auth")
    ->name("clinics.manage");

Route::get("/clinique/params/{id}",[\App\Http\Controllers\CliniqueController::class,'params'])
    ->middleware("auth")
    ->name("clinique.params");





Route::get("/activation/{token}",[\App\Http\Controllers\ActivationController::class,'index'])
    ->name("activation");



