<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoProvaRequest;
use App\Services\TipoProvaService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipoProvaController extends Controller
{

    private $tipoProvaService;

    public function __construct()
    {
        $this->tipoProvaService = new TipoProvaService;
    }

    /**
     * @OA\Get(
     *   path="/api/tipo-prova",
     *   tags={"Tipo Prova"},
     *   summary="Lista de tipos de provas",
     *   @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *      @OA\JsonContent(
     *         @OA\Property(property="data", type="object", example={
     *            {
     *              "id": 1,
     *              "descricao": "3 km",
     *              "created_at": "2021-04-30T00:39:22.000000Z",
     *              "updated_at": "2021-04-30T00:39:22.000000Z"
     *            },
     *            {
     *              "id": 2,
     *              "descricao": "5 km",
     *              "created_at": "2021-04-30T00:39:22.000000Z",
     *              "updated_at": "2021-04-30T00:39:22.000000Z"
     *            },
     *            {
     *              "id": 3,
     *              "descricao": "10 km",
     *              "created_at": "2021-04-30T00:39:22.000000Z",
     *              "updated_at": "2021-04-30T00:39:22.000000Z"
     *            },
     *            {
     *              "id": 4,
     *              "descricao": "21 km",
     *              "created_at": "2021-04-30T00:39:22.000000Z",
     *              "updated_at": "2021-04-30T00:39:22.000000Z"
     *            },
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
            return $this->responseDataSuccess($this->tipoProvaService->listar());
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *   path="/api/tipo-prova",
     *   tags={"Tipo Prova"},
     *   summary="Cria tipo prova",
     *   @OA\RequestBody(
     *    required=true,
     *    description="Exemplo criar um tipo de prova",
     *    @OA\JsonContent(
     *       required={"descricao"},
     *       @OA\Property(property="descricao", type="string", format="string", example="42 km")
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
     *          "descricao": {
     *              "O campo descrição é obrigatório.",
     *              "O campo descrição não pode ser superior a 255 caracteres.",
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

            $validacao = Validator::make($request->all(), (new TipoProvaRequest())->rules());

            if ($validacao->fails()) {
                return $this->responseError($validacao->errors());
            }

            $this->tipoProvaService->criar($request->all());

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

            return $this->responseDataSuccess($this->tipoProvaService->obterPorId($id));
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * @OA\Put(
     *   path="/api/tipo-prova/{id}",
     *   tags={"Tipo Prova"},
     *   summary="Atualiza tipo prova",
     *
     *    * @OA\Parameter(
     *    description="ID tipo prova",
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
     *    description="Exemplo para atualizar um tipo prova",
     *    @OA\JsonContent(
     *       required={"descricao"},
     *       @OA\Property(property="descricao", type="string", format="string", example="45 km"),
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
     *          "descricao": {
     *              "O campo descrição é obrigatório.",
     *              "O campo descrição não pode ser superior a 255 caracteres.",
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
            $validacao = Validator::make($request->all(), (new TipoProvaRequest())->rules($id));

            if ($validacao->fails()) {
                return $this->responseError($validacao->errors());
            }

            $this->tipoProvaService->atualizar($request->all(), $id);

            return $this->responseSuccess();
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *   path="/api/tipo-prova/{id}",
     *   tags={"Tipo Prova"},
     *   summary="Deleta tipo prova",
     *
     *    * @OA\Parameter(
     *    description="ID tipo prova",
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
     *         @OA\Property(property="mensagem", type="string", example="Não é possível excluir o tipo de prova, pois existem provas cadastradas para este tipo."),
     *         @OA\Property(property="sucesso", type="bool", example="false"),
     *      )
     *    )
     *   ),
     * )
     */
    public function destroy($id)
    {
        try {

            $this->tipoProvaService->deletar($id);

            return $this->responseSuccess();
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }
}
