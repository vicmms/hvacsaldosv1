<?php

use App\Http\Controllers\api\BrandController;
use App\Http\Controllers\api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\SubcategoryController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CompanyController;
use App\Http\Controllers\api\AppInfoController;

use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/userInfo', [AuthController::class, 'userInfo'])->middleware('auth:sanctum');

// products
Route::post('/app/getProducts', [ProductController::class, 'getProducts']);
Route::post('/app/getStates', [ProductController::class, 'getStates']);
Route::post('/app/getCountries', [ProductController::class, 'getCountries']);
Route::post('/app/getProductById', [ProductController::class, 'getProductById']);
Route::post('/app/setProduct', [ProductController::class, 'setProduct']);
Route::post('/app/updateProduct', [ProductController::class, 'updateProduct']);
Route::post('/app/deleteProduct', [ProductController::class, 'deleteProduct']);
Route::post('/app/deleteProductPhoto', [ProductController::class, 'deleteProductPhoto']);

// companies
Route::post('/app/getCompany', [CompanyController::class, 'getCompany']);
Route::post('/app/setCompany', [CompanyController::class, 'setCompany']);

Route::post('/app/getCategories', [CategoryController::class, 'getCategories']);
Route::post('/app/getSubcategories', [SubcategoryController::class, 'getSubcategories']);
Route::post('/app/getBrands', [BrandController::class, 'getBrands']);

//App info
Route::post('/app/getReleaseCurrent', [AppInfoController::class, 'getReleaseCurrent']);
