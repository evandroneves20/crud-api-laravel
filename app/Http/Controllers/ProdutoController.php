<?php

namespace App\Http\Controllers;

use App\Models\Loja;
use App\Models\Produto;
use App\Notifications\CreateOrUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProdutoController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Loja $loja)
    {
        $produtos = $loja->produtos;
        return response()->json($produtos);
    }

    private function enviaEmail(string $texto, string $email)
    {
        Notification::route('mail', $email
            ->notify(new CreateOrUpdate($texto)));
    }

    /**
     * @param Request $request
     * @param Loja $loja
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Loja $loja)
    {
        $validator = Validator::make(
            $request->all(),
            Produto::rules(),
            Produto::message()
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        try {
            $produto = $loja->produtos()->create([
                'nome' => $request->nome,
                'valor' => (int)$request->valor,
                'ativo' => $request->ativo,
            ]);

            $this->enviaEmail("Produto {$produto->nome} Cadastrado com Sucesso", $loja->email);

            return response()->json([
                'message' => "Produto {$request->nome} cadastrada com Sucesso!"
            ], Response::HTTP_CREATED);
        } catch (\Exception $ex) {
            return response()->json("Erro ao cadastrar o produto {$request->nome}! <br>Código do Erro: {$ex->getMessage()}", Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Mostra um produto
     *
     * @param Produto $produto
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Loja $loja, Produto $produto)
    {
        try {
            return response()->json($produto, Response::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode(), [], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * @param Request $request
     * @param Loja $loja
     * @param Produto $produto
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Loja $loja, Produto $produto)
    {
        $validator = Validator::make(
            $request->all(),
            Produto::rules(),
            Produto::message()
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        try {
            $loja->produtos()->update([
                'nome' => $request->nome,
                'valor' => (int)$request->valor,
                'ativo' => $request->ativo,
            ]);

            $this->enviaEmail("Produto {$produto->nome} Alterado com Sucesso", $loja->email);

            return response()->json([
                'message' => "Produto {$request->nome} alterado com Sucesso!",

            ], Response::HTTP_CREATED);
        } catch (\Exception $ex) {
            return response()->json("Erro ao alterar a produto {$request->nome}! <br>Código do Erro: {$ex->getMessage()}", Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param Loja $loja
     * @param Produto $produto
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Loja $loja, Produto $produto)
    {
        try {
            $produtoName = $produto->nome;
            $produto->delete();

            return response()->json([
                'message' => "Produto {$produtoName} Excluído com Sucesso!",
            ], Response::HTTP_OK);

        } catch (\Exception $ex) {
            return response()->json($ex->getMessage(), Response::HTTP_BAD_REQUEST, [], JSON_UNESCAPED_UNICODE);
        }
    }
}
