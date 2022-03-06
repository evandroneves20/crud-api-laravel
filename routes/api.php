<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\LojaController;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

///poderia criar com resource excluindo os métodos edit() e create()
/// mas assim digita mais, :)

Route::prefix('lojas')->group(function () {
    Route::get('/', [LojaController::class, 'index'])->name('lojas.index');
    Route::get('/{loja}', [LojaController::class, 'show'])->name('lojas.show');
    Route::post('/', [LojaController::class, 'store'])->name('lojas.store');
    Route::put('/{loja}', [LojaController::class, 'update'])->name('lojas.update');
    Route::delete('/{loja}', [LojaController::class, 'destroy'])->name('lojas.delete');

    //pode agrupar as rotas de produtos se achar necessário
    Route::middleware([\App\Http\Middleware\Loja\CheckLojaHasProduto::class])->group(function(){
        Route::get('/{loja}/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
        Route::get('/{loja}/produtos/{produto}', [ProdutoController::class, 'show'])->name('produtos.show');
        Route::post('/{loja}/produtos', [ProdutoController::class, 'store'])->name('produtos.store');
        Route::put('/{loja}/produtos/{produto}', [ProdutoController::class, 'update'])->name('produtos.update');
        Route::delete('/{loja}/produtos/{produto}', [ProdutoController::class, 'destroy'])->name('produtos.delete');
    });
});
