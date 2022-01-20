<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerRateController;
use App\Http\Livewire\ShoppingCart;
use App\Http\Livewire\CreateOrder;

use App\Http\Livewire\PaymentOrder;

use App\Http\Controllers\WebhooksController;
use App\Http\Livewire\Orders;
use App\Http\Livewire\ShowProduct;
use App\Mail\VentaMailable;
use App\Models\Order;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Facades\Auth;

Route::get('home/{country?}', WelcomeController::class);
Route::get('/', WelcomeController::class)->name('home');

Route::get('/mail', function(){
    $user = Auth::user();
    return new VentaMailable(null, $user);
});

Route::get('search', SearchController::class)->name('search');

Route::get('categories/all/{country?}', [CategoryController::class, 'showAll'])->name('categories.showAll');

Route::get('categories/{category}/{country?}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('offers/{country?}', [CategoryController::class, 'offers'])->name('offers');

Route::get('seller products/{seller}', [CategoryController::class, 'getProductsBySeller'])->name('bySeller');

Route::get('products/{product}', ShowProduct::class)->name('products.show');

Route::get('shopping-cart', ShoppingCart::class)->name('shopping-cart');

Route::get('seller-review/{id}', [SellerRateController::class, 'show'])->name('seller-review');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('orders', Orders::class)->name('orders.index');

    Route::get('orders/create', CreateOrder::class)->name('orders.create');

    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('orders/{order}/payment', PaymentOrder::class)->name('orders.payment');

    Route::get('order/success', [OrderController::class, 'success'])->name('order.success');

    Route::get('orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');

    Route::post('webhooks', WebhooksController::class);
});

Route::get('imprimirQR/{product}', [PdfController::class, 'imprimirQr'])->name('imprimirQr');