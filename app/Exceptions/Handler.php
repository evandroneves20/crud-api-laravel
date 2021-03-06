<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param $request
     * @param Throwable $e
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
        ///Se a loja ou o produto não for encontrado
        if ($e instanceof ModelNotFoundException){
            $model = explode('\\',$e->getModel());
            return response()->json(end($model)." não encontrado(a)", 404, [], JSON_UNESCAPED_UNICODE);
        }

        ///demais erros de requisição
        if ($e instanceof HttpException){
            $message = $e->getMessage() === ''?'Página não encontrada':$e->getMessage();
            return response()->json($message, 404, [], JSON_UNESCAPED_UNICODE);
        }

        return parent::render($request, $e); // TODO: Change the autogenerated stub
    }


}
