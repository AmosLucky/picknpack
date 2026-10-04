
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QriffController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PendingShipmentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InventoryAnalysisController;

// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Response;




/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
|
| Only authentication pages should be publicly accessible.
| Breeze loads login/logout/password routes from auth.php.
|
*/
Route::middleware('auth')->group(function () {



 Route::get(
        '/analytics/inventory',
        [InventoryAnalysisController::class, 'index']
    )->name('analytics.inventory');

 /*
    |--------------------------------------------------------------------------
    | Orders
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/orders',
        [OrderController::class, 'index']
    )->name('orders.index');

    Route::get(
        '/orders/{order}',
        [OrderController::class, 'show']
    )->name('orders.show');

    Route::post(
        '/orders/{order}/cancel',
        [OrderController::class, 'cancel']
    )->name('orders.cancel');

  /*
    |--------------------------------------------------------------------------
    | Pending Incoming Shipments
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/shipments/pending',
        [PendingShipmentController::class, 'index']
    )->name('shipments.pending');

    Route::get(
        '/shipments/pending/{order}',
        [PendingShipmentController::class, 'show']
    )->name('shipments.pending.show');

    Route::post(
        '/shipments/pending/{order}/confirm',
        [PendingShipmentController::class, 'confirm']
    )->name('shipments.pending.confirm');

    ///inventory

    Route::get('/inventory', [
        InventoryController::class,
        'index'
    ])->name('inventory.index');

});

Route::get('/', function () {
    return redirect()->route('dashboard');
});



// Route::middleware('auth')->group(function () {

//     Route::get(
//         '/shipments/pending',
//         [ShipmentController::class, 'pending']
//     )->name('shipments.pending');

//     Route::get(
//         '/shipments/pending/{order}',
//         [ShipmentController::class, 'pendingShow']
//     )->name('shipments.pending.show');

// });


/*
|--------------------------------------------------------------------------
| Authenticated Application
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

     Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | QRIFF
    |--------------------------------------------------------------------------
    |
    | Old:
    |   /qriff
    |   /qriff/record
    |   /qriff/download
    |   /qriff/upload
    |
    | New:
    |   /qriff
    |   /qriff/record
    |   /qriff/download
    |   /qriff/upload
    |
    */

    Route::prefix('qriff')
        ->name('qriff.')
        ->group(function () {

            Route::get('/', [
                QriffController::class,
                'index'
            ])->name('index');

            Route::get('/record', [
                QriffController::class,
                'record'
            ])->name('record');

            Route::post('/download', [
                QriffController::class,
                'download'
            ])->name('download');

            Route::post('/upload', [
                QriffController::class,
                'upload'
            ])->name('upload');
        });


    /*
    |--------------------------------------------------------------------------
    | Delivery
    |--------------------------------------------------------------------------
    |
    | Keep delivery URLs short.
    |
    | /delivery
    | /delivery/download
    |
    */

    Route::prefix('delivery')
        ->name('delivery.')
        ->group(function () {

            Route::get('/', function () {
                return view('delivery.index');
            })->name('index');

            Route::get('/download', function () {
                return view('delivery.download');
            })->name('download');
        });


    /*
    |--------------------------------------------------------------------------
    | Shipments
    |--------------------------------------------------------------------------
    |
    | Shipment setup identifies the logged-in sender/store.
    |
    | /shipments/setup
    | /shipments/create
    | /shipments/store
    |
    */


Route::middleware('auth')->group(function () {

    // Shipment source selection page
    Route::get('/shipments/setup', [ShipmentController::class, 'setup'])
        ->name('shipments.setup');

    // Process selected sender
    Route::post('/shipments/setup', [ShipmentController::class, 'processSetup'])
        ->name('shipments.setup.store');

    // Actual shipment page
    Route::get('/shipments/create', [ShipmentController::class, 'create'])
        ->name('shipments.create');

    // Save shipment
    Route::post('/shipments/store', [ShipmentController::class, 'store'])
        ->name('shipments.store');

});
    Route::prefix('shipments1111')
    ->name('shipments.')
    ->group(function () {

        // Step 1: Show "Who are you?" page
        Route::get('/setup', [ShipmentController::class, 'setupForm'])
            ->name('setup');

        // Step 2: Process sender selection
      Route::post('/setup', [ShipmentController::class, 'processSetup'])
    ->name('setup.store');

        // Step 3: Create shipment
        Route::get('/create', [ShipmentController::class, 'create'])
            ->name('create');

        // Save shipment
        Route::post('/store', [ShipmentController::class, 'store'])
            ->name('store');
    });

    Route::prefix('shipments101')
        ->name('shipments.')
        ->group(function () {

            Route::get('/setup', [
                ShipmentController::class,
                'setup'
            ])->name('setup');

            Route::get('/create', [
                ShipmentController::class,
                'create'
            ])->name('create');

            Route::post('/store', [
                ShipmentController::class,
                'store'
            ])->name('store');
        });
});


/*
|--------------------------------------------------------------------------
| Breeze Authentication
|--------------------------------------------------------------------------
|
| login
| logout
| forgot password
| reset password
| email verification
|
*/

require __DIR__ . '/auth.php';
