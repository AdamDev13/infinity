<?php

use App\Http\Controllers\TestController;
use App\Models\Location;
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
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
*/
//
//Route::get('/', function () {
//  return redirect()->path('das');
//});

//Route::redirect('/','/users/dashboards/main');




Route::get('/token', function () {
    return csrf_token();
});

Route::post('/testpost', [TestController::class, 'testpost']);

Route::get('/test', [TestController::class, 'test']);

//\Illuminate\Support\Facades\Auth::routes();

require __DIR__.'/auth.php';



Route::get('/{view}', function () {
    return view("vendor_index");
})->where('view', '^(?!users|nova-api|nova-vendor).*$');
