<?php

namespace App\Http\Controllers;

use App\Http\Requests\CorredorEmProvaRequest;
use App\Services\CorredorEmProvaService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CorredorEmProvaController extends Controller
{

    private $corredorEmProvaService;

    public function __construct()
    {
        $this->corredorEmProvaService = new CorredorEmProvaService;
    }

    /**
     * @OA\Get(
     *   path="/api/corredor-em-prova",
     *   tags={"Corredor em Prova"},
     *   summary="Lista de corredores cadastrados para provas",
     *   @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *      @OA\JsonContent(
     *         @OA\Property(property="data", type="object", example={
     *                {
     *                  "id": 1,
     *                  "corredor_id": 1,
     *                  "prova_id": 1,
     *                  "created_at": "2021-04-30T00:40:46.000000Z",
     *                  "updated_at": "2021-04-30T00:40:46.000000Z"
     *                },
     *                {
     *                  "id": 2,
     *                  "corredor_id": 2,
     *                  "prova_id": 1,
     *                  "created_at": "2021-04-30T00:40:46.000000Z",
     *                  "updated_at": "2021-04-30T00:40:46.000000Z"
     *                },
     *
     *      }),
     *         @OA\Property(property="mensagem", type="string", example="Operação realizada com sucesso."),
     *         @OA\Property(property="sucesso", type="bool", example="true")
     *      )
     *   ),
     *   @OA\Response(
     *    response=400,
     *    description="Exemplos de possíveis erros",
     *      @OA\JsonContent(
     *         @OA\Property(property="mensagem", type="string", example="Erro ao realizar operação."),
     *         @OA\Property(property="sucesso", type="bool", example="false")
     *      )
     *   ),
     * )
     */
    public function index()
    {
        try {
            return $this->responseDataSuccess($this->corredorEmProvaService->listar());
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *   path="/api/corredor-em-prova",
     *   tags={"Corredor em Prova"},
     *   summary="Cadastra um corredor em uma prova",
     *   @OA\RequestBody(
     *    required=true,
     *    description="Cadastra um corredor em uma prova",
     *    @OA\JsonContent(
     *       required={"nome", "cpf", "data_nascimento"},
     *       @OA\Property(property="prova_id", type="string", format="string", example="1"),
     *       @OA\Property(property="corredor_id", type="string", format="string", example="1"),
     *    ),
     *  ),
     *
     *   @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *      @OA\JsonContent(
     *         @OA\Property(property="mensagem", type="string", example="Operação realizada com sucesso."),
     *         @OA\Property(property="sucesso", type="bool", example="true")
     *      )
     *   ),
     *   @OA\Response(
     *    response=400,
     *    description="Exemplos de possíveis erros",
     *    @OA\JsonContent(
     *         @OA\Property(property="mensagem", type="object", example={
     *          "corredor_id": {
     *              "O campo corredor id é obrigatório.",
     *              "O campo corredor id selecionado é inválido.",
     *              },
     *          "prova_id": {
     *              "O campo prova id é obrigatório.",
     *              "O campo prova id selecionado é inválido.",
     *              },
     *           }
     *         ),
     *         @OA\Property(property="sucesso", type="bool", example="false"),
     *      )
     *    )
     *   ),
     * )
     */
    public function store(Request $request)
    {

        try {

            $validacao = Validator::make($request->all(), (new CorredorEmProvaRequest())->rules());

            if ($validacao->fails()) {
                return $this->responseError($validacao->errors());
            }

            $this->corredorEmProvaService->criar($request->all());

            return $this->responseSuccess();
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *   path="/api/corredor-em-prova/{id}",
     *   tags={"Corredor em Prova"},
     *   summary="Deleta um corredor de uma prova",
     *
     *    * @OA\Parameter(
     *    description="ID corredor em prova",
     *    in="path",
     *    name="id",
     *    required=true,
     *    example="1",
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *     )
     *   ),
     *   @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *      @OA\JsonContent(
     *         @OA\Property(property="mensagem", type="string", example="Operação realizada com sucesso."),
     *         @OA\Property(property="sucesso", type="bool", example="true")
     *      )
     *   ),
     *   @OA\Response(
     *    response=400,
     *    description="Exemplos de possíveis erros",
     *    @OA\JsonContent(
     *         @OA\Property(property="mensagem", type="string", example="Não é possível excluir o corredor desta prova, pois o mesmo já possui resultado gerado."),
     *         @OA\Property(property="sucesso", type="bool", example="false"),
     *      )
     *    )
     *   ),
     * )
     */
    public function destroy($id)
    {
        try {

            $this->corredorEmProvaService->deletar($id);

            return $this->responseSuccess();
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }
}
