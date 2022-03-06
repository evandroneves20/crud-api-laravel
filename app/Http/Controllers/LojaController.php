<?php

namespace App\Http\Controllers;

use App\Models\Loja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class LojaController extends Controller
{
    /**
     * Retorna as lojas cadastradas
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $lojas = Loja::all();
        return response()->json($lojas);
    }

    /**
     * Cria uma loja e salva no DB
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            Loja::rules(),
            Loja::message()
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        try {
            $loja = new Loja();
            $loja->nome = $request->nome;
            $loja->email = $request->email;
            $loja->save();

            return response()->json([
                'message' => "Loja {$loja->nome} cadastrada com Sucesso!",
                'loja' => $loja
            ], Response::HTTP_CREATED);
        } catch (\Exception $ex) {
            return response()->json("Erro ao cadastrar a loja {$loja->nome}! <br>Código do Erro: {$ex->getCode()}", Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Mostra uma Loja
     *
     * @param Loja $loja
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Loja $loja)
    {
        try {
            $collection = Loja::with('produtos')
                ->where('id', $loja->id)
                ->get()
                ->toArray();

            return response()->json($collection, Response::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode(), [], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Alualiza
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Loja $loja)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                Loja::rules($loja->id),
                Loja::message()
            );

            if ($validator->fails()) {
                throw new \Exception($validator->errors(), Response::HTTP_BAD_REQUEST);
            }

            $loja->nome = $request->nome;
            $loja->email = $request->email;
            $loja->update();

            return response()->json([
                'message' => "Loja {$loja->nome} atualizada com Sucesso!",
                'loja' => $loja
            ], Response::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode(), [], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Remove uma Loja
     *
     * @param Loja $loja
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Loja $loja)
    {
        try {
            $lojaName = $loja->nome;
            $loja->produtos()->delete();
            $loja->delete();

            return response()->json([
                'message' => "Loja {$lojaName} Excluída com Sucesso!",
            ], Response::HTTP_OK);

        } catch (\Exception $ex) {
            return response()->json($ex->getMessage(), Response::HTTP_BAD_REQUEST, [], JSON_UNESCAPED_UNICODE);
        }
    }
}
