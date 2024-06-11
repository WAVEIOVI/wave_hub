<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Orion\Facades\Orion;

use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\Contact\ClientsController;
use App\Http\Controllers\Api\Contact\MetaClientsController;
use App\Http\Controllers\Api\Contact\ClAddressesController;
use App\Http\Controllers\Api\Contact\ClContactsController;
use App\Http\Controllers\Api\Contact\SuppliersController;
use App\Http\Controllers\Api\Contact\MetaSuppliersController;
use App\Http\Controllers\Api\Contact\SuAddressesController;
use App\Http\Controllers\Api\Contact\SuContactsController;
use App\Http\Controllers\Api\WaveFire\Inventory\EquipmentController;
use App\Http\Controllers\Api\WaveFire\Inventory\EqAccessoriesController;
use App\Http\Controllers\Api\WaveFire\Inventory\PaAreasController;
use App\Http\Controllers\Api\WaveFire\Inventory\PaEquipmentController;
use App\Http\Controllers\Api\WaveFire\Inventory\ParksController;
use App\Http\Controllers\Api\WaveFire\Inventory\ClParksController;
use App\Http\Controllers\Api\WaveFire\Inventory\MetaEquipmentController;
use App\Http\Controllers\Api\WaveFire\Inventory\MetaPaEquipmentController;
use App\Http\Controllers\Api\WaveFire\Technician\TechniciansController;
use App\Http\Controllers\Api\WaveFire\Mission\MissionFoldersController;
use App\Http\Controllers\Api\WaveFire\Mission\MetaMissionFoldersController;
use App\Http\Controllers\Api\WaveFire\Mission\MissionEventsController;
use App\Http\Controllers\Api\WaveFire\Mission\InterventionsController;
use App\Http\Controllers\Api\WaveFire\Mission\MetaInterventionsController;
use App\Http\Controllers\Api\WaveFire\Mission\InCheckListsController;
use App\Http\Controllers\Api\WaveFire\Mission\InterventionsEquipmentController;
use App\Http\Controllers\Api\WaveFire\Mission\WorkshopsController;
use App\Http\Controllers\Api\WaveFire\Mission\MetaWorkshopsController;
use App\Http\Controllers\Api\WaveFire\Mission\WorkshopsEquipmentController;
use App\Http\Controllers\Api\WaveFire\Mission\MissionInterventionsController;
use App\Http\Controllers\Api\WaveFire\Mission\MissionWorkshopsController;
use App\Http\Controllers\Api\WaveFire\Mission\MetaInterventionsEquipmentController;
use App\Http\Controllers\Api\WaveFire\Mission\MetaWorkshopsEquipmentController;

use App\Http\Controllers\Api\WaveFire\Mission\EquipmentInterventionMaintenancesController;
use App\Http\Controllers\Api\WaveFire\Mission\EquipmentInterventionAddMaintenancesController;
use App\Http\Controllers\Api\WaveFire\Mission\EquipmentInterventionAccessoriesController;
use App\Http\Controllers\Api\WaveFire\Mission\EquipmentInterventionSuppliesController;

// Wave Fire CONFIG
use App\Http\Controllers\Api\Config\Inventory\EquipmentCategoriesController;
use App\Http\Controllers\Api\Config\Inventory\EquipmentModelsController;
use App\Http\Controllers\Api\Config\Inventory\CategoryModelsController;
use App\Http\Controllers\Api\Config\Inventory\AccessoriesController;
use App\Http\Controllers\Api\Config\Inventory\PressuresController;
use App\Http\Controllers\Api\Config\Inventory\ProtectionsController;
use App\Http\Controllers\Api\Config\Inventory\MaintenancesController;
use App\Http\Controllers\Api\Config\Inventory\AdditionalMaintenancesController;
use App\Http\Controllers\Api\Config\Inventory\SuppliesController;
use App\Http\Controllers\Api\Config\Inventory\WeightsController;
use App\Http\Controllers\Api\Config\Inventory\ModelsAccessoriesController;
use App\Http\Controllers\Api\Config\Inventory\ModelsPressuresController;
use App\Http\Controllers\Api\Config\Inventory\ModelsProtectionsController;
use App\Http\Controllers\Api\Config\Inventory\ModelsWeightsController;
use App\Http\Controllers\Api\Config\Inventory\ModelsMaintenancesController;
use App\Http\Controllers\Api\Config\Inventory\ModelsAdditionalMaintenancesController;
use App\Http\Controllers\Api\Config\Inventory\ModelsSuppliesController;

use App\Http\Controllers\Api\RolesController;

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

// Route::middleware('auth:sanctum')->

Route::group(['as' => 'api.', 'middleware' => 'auth:sanctum'], function () {
    Route::post('/register-user', [UserController::class, 'register']);
    Orion::resource('clients', ClientsController::class);
    Orion::resource('meta-clients', MetaClientsController::class);
    Orion::hasManyResource('client', 'addresses', ClAddressesController::class);
    Orion::hasManyResource('client', 'contacts', ClContactsController::class);
    Orion::resource('suppliers', SuppliersController::class);
    Orion::resource('meta-suppliers', MetaSuppliersController::class);
    Orion::hasManyResource('supplier', 'addresses', SuAddressesController::class);
    Orion::hasManyResource('supplier', 'contacts', SuContactsController::class);
    Orion::resource('parks', ParksController::class);
    Orion::hasManyResource('client', 'parks', ClParksController::class);
    Orion::resource('meta-equipment', MetaEquipmentController::class);
    Orion::hasManyResource('park', 'areas', PaAreasController::class);
    Orion::hasManyResource('park', 'equipment', PaEquipmentController::class);
    Orion::hasManyResource('park', 'meta-equipment', MetaPaEquipmentController::class);
    Orion::resource('technicians', TechniciansController::class);
    Orion::resource('missions', MissionFoldersController::class);
    Orion::resource('meta-missions', MetaMissionFoldersController::class);
    Orion::resource('mission-events', MissionEventsController::class);
    Orion::resource('interventions', InterventionsController::class);
    Orion::resource('meta-interventions', MetaInterventionsController::class);
    Orion::hasOneResource('intervention', 'check-list', InCheckListsController::class);
    Orion::resource('equipment', EquipmentController::class);
    Orion::hasManyResource('equipment', 'accessories', EqAccessoriesController::class);
    Orion::belongsToManyResource('interventions', 'equipment', InterventionsEquipmentController::class);

    Orion::hasManyResource('equipment-intervention', 'maintenances', EquipmentInterventionMaintenancesController::class);
    Orion::hasManyResource('equipment-intervention', 'add-maintenances', EquipmentInterventionAddMaintenancesController::class);
    Orion::hasManyResource('equipment-intervention', 'supplies', EquipmentInterventionSuppliesController::class);
    Orion::hasManyResource('equipment-intervention', 'accessories', EquipmentInterventionAccessoriesController::class);

    Orion::resource('workshops', WorkshopsController::class);
    Orion::resource('meta-workshops', MetaWorkshopsController::class);
    Orion::belongsToManyResource('workshops', 'equipment', WorkshopsEquipmentController::class);
    Orion::hasOneResource('mission', 'intervention', MissionInterventionsController::class);
    Orion::hasOneResource('mission', 'workshop', MissionWorkshopsController::class);
    Orion::belongsToManyResource('interventions', 'meta-equipment', MetaInterventionsEquipmentController::class);
    Orion::belongsToManyResource('workshops', 'meta-equipment', MetaWorkshopsEquipmentController::class);

    // Config
    Orion::resource('categories', EquipmentCategoriesController::class);
    Orion::resource('models', EquipmentModelsController::class);
    Orion::resource('accessories', AccessoriesController::class);
    Orion::resource('protections', ProtectionsController::class);
    Orion::resource('pressures', PressuresController::class);
    Orion::resource('weights', WeightsController::class);
    Orion::resource('supplies', SuppliesController::class);
    Orion::resource('maintenances', MaintenancesController::class);
    Orion::resource('additional-maintenances', AdditionalMaintenancesController::class);
    Orion::hasManyResource('category', 'models', CategoryModelsController::class);
    Orion::belongsToManyResource('models', 'accessories', ModelsAccessoriesController::class);
    Orion::belongsToManyResource('models', 'protections', ModelsProtectionsController::class);
    Orion::belongsToManyResource('models', 'pressures', ModelsPressuresController::class);
    Orion::belongsToManyResource('models', 'weights', ModelsWeightsController::class);
    Orion::belongsToManyResource('models', 'maintenances', ModelsMaintenancesController::class);
    Orion::belongsToManyResource('models', 'additional-maintenances', ModelsAdditionalMaintenancesController::class);
    Orion::belongsToManyResource('models', 'supplies', ModelsSuppliesController::class);

    Orion::resource('roles', RolesController::class);
});
