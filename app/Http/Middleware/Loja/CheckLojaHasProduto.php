<?php

namespace App\Http\Middleware\Loja;

use Closure;
use Illuminate\Http\Request;

class CheckLojaHasProduto
{
    /**
     * Verifica se O produto pertence a loja selecionada.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->produto){
            $produto = $request->loja->produtos()->find($request->produto->id);

            if (!$produto) {
                abort(400, 'Produto não pertence a loja selecionada');
            }
        }
        return $next($request);
    }
}
