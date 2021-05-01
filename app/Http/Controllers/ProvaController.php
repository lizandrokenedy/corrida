<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProvaRequest;
use App\Services\ProvaService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProvaController extends Controller
{

    private $provaService;

    public function __construct()
    {
        $this->provaService = new ProvaService;
    }

    /**
     * @OA\Get(
     *   path="/api/prova",
     *   tags={"Prova"},
     *   summary="Lista de provas",
     *   @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *      @OA\JsonContent(
     *         @OA\Property(property="data", type="object", example={
     *                {
     *                  "id": 1,
     *                  "tipo_prova_id": 2,
     *                  "data": "2021-11-07 08:00:00",
     *                  "created_at": "2021-04-30T00:39:49.000000Z",
     *                  "updated_at": "2021-04-30T00:39:49.000000Z"
     *                },
     *                {
     *                  "id": 2,
     *                  "tipo_prova_id": 3,
     *                  "data": "2021-11-07 08:00:00",
     *                  "created_at": "2021-04-30T00:39:49.000000Z",
     *                  "updated_at": "2021-04-30T00:39:49.000000Z"
     *                },
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
            return $this->responseDataSuccess($this->provaService->listar());
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *   path="/api/prova",
     *   tags={"Prova"},
     *   summary="Cria prova",
     *   @OA\RequestBody(
     *    required=true,
     *    description="Exemplo criar uma prova",
     *    @OA\JsonContent(
     *       required={"tipo_prova_id", "data"},
     *       @OA\Property(property="tipo_prova_id", type="string", format="string", example="1"),
     *       @OA\Property(property="data", type="string", format="string", example="2021-05-31 08:00")
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
     *          "tipo_prova_id": {
     *              "O campo tipo prova id é obrigatório.",
     *              "O campo tipo prova id selecionado é inválido.",
     *              },
     *          "data": {
     *              "O campo data é obrigatório.",
     *              "O campo data não é uma data válida.",
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

            $validacao = Validator::make($request->all(), (new ProvaRequest())->rules());

            if ($validacao->fails()) {
                return $this->responseError($validacao->errors());
            }

            $this->provaService->criar($request->all());

            return $this->responseSuccess();
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            return $this->responseDataSuccess($this->provaService->obterPorId($id));
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * @OA\Put(
     *   path="/api/prova/{id}",
     *   tags={"Prova"},
     *   summary="Atualiza prova",
     *
     *    * @OA\Parameter(
     *    description="ID prova",
     *    in="path",
     *    name="id",
     *    required=true,
     *    example="1",
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *     )
     *   ),
     *   @OA\RequestBody(
     *    required=true,
     *    description="Exemplo para atualizar uma prova",
     *    @OA\JsonContent(
     *       required={"tipo_prova_id", "data"},
     *       @OA\Property(property="tipo_prova_id", type="string", format="string", example="1"),
     *       @OA\Property(property="data", type="string", format="string", example="2021-05-31 10:00")
     *    ),
     *  ),
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
     *          "tipo_prova_id": {
     *              "O campo tipo prova id selecionado é inválido.",
     *              },
     *          "data_nascimento": {
     *              "O campo data não é uma data válida."
     *              },
     *           }
     *         ),
     *         @OA\Property(property="sucesso", type="bool", example="false"),
     *      )
     *    )
     *   ),
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $validacao = Validator::make($request->all(), (new ProvaRequest())->rules($id));

            if ($validacao->fails()) {
                return $this->responseError($validacao->errors());
            }

            $this->provaService->atualizar($request->all(), $id);

            return $this->responseSuccess();
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *   path="/api/prova/{id}",
     *   tags={"Prova"},
     *   summary="Deleta prova",
     *
     *    * @OA\Parameter(
     *    description="ID prova",
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
     *         @OA\Property(property="mensagem", type="string", example="Não é possível excluir a prova pois existem corredores cadastrados para ela."),
     *         @OA\Property(property="sucesso", type="bool", example="false"),
     *      )
     *    )
     *   ),
     * )
     */
    public function destroy($id)
    {
        try {

            $this->provaService->deletar($id);

            return $this->responseSuccess();
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }
}
