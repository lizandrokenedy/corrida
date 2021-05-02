<?php

namespace App\Http\Controllers;

use App\Http\Requests\CorredorRequest;
use App\Services\CorredorService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CorredorController extends Controller
{

    private $corredorService;

    public function __construct()
    {
        $this->corredorService = new CorredorService;
    }

    /**
     * @OA\Get(
     *   path="/api/corredor",
     *   tags={"Corredor"},
     *   summary="Lista de corredores",
     *   @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *      @OA\JsonContent(
     *         @OA\Property(property="data", type="object", example={
     *                {
     *                  "id": 1,
     *                  "nome": "Lizandro",
     *                  "cpf": "04397588157",
     *                  "data_nascimento": "1994-07-11T03:00:00.000000Z",
     *                  "created_at": "2021-04-28T21:14:54.000000Z",
     *                  "updated_at": "2021-04-28T21:14:54.000000Z"
     *                },
     *                {
     *                  "id": 2,
     *                  "nome": "Lizandro",
     *                  "cpf": "04397588156",
     *                  "data_nascimento": "1994-07-11T03:00:00.000000Z",
     *                  "created_at": "2021-04-28T21:15:00.000000Z",
     *                  "updated_at": "2021-04-28T21:15:00.000000Z"
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
            return $this->responseDataSuccess($this->corredorService->listar());
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *   path="/api/corredor",
     *   tags={"Corredor"},
     *   summary="Cria corredor",
     *   @OA\RequestBody(
     *    required=true,
     *    description="Exemplo criar um corredor",
     *    @OA\JsonContent(
     *       required={"nome", "cpf", "data_nascimento"},
     *       @OA\Property(property="nome", type="string", format="string", example="Nome do candidato"),
     *       @OA\Property(property="cpf", type="string", format="string", example="00000000000"),
     *       @OA\Property(property="data_nascimento", type="string", format="string", example="1994-11-07")
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
     *          "nome": {
     *              "O campo nome é obrigatório.",
     *              "O campo nome não pode ser superior a 255 caracteres.",
     *              "O campo nome deve ser uma string."
     *              },
     *          "cpf": {
     *              "O campo cpf é obrigatório.",
     *              "O campo cpf já está sendo utilizado.",
     *              "O campo cpf não pode ser superior a 11 caracteres.",
     *              "O campo cpf deve ter pelo menos 11 caracteres."
     *              },
     *          "data_nascimento": {
     *              "O campo data nascimento é obrigatório.",
     *              "Inscrição permitida apenas para maiores de 18 anos.",
     *              "O campo data nascimento não é uma data válida."
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

            $validacao = Validator::make($request->all(), (new CorredorRequest)->rules());

            if ($validacao->fails()) {
                return $this->responseError($validacao->errors());
            }

            $this->corredorService->criar($request->all());

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

            return $this->responseDataSuccess($this->corredorService->obterPorId($id));
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * @OA\Put(
     *   path="/api/corredor/{id}",
     *   tags={"Corredor"},
     *   summary="Atualiza corredor",
     *
     *    * @OA\Parameter(
     *    description="ID corredor",
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
     *    description="Exemplo para atualizar um corredor",
     *    @OA\JsonContent(
     *       required={"nome", "cpf", "data_nascimento"},
     *       @OA\Property(property="nome", type="string", format="string", example="Nome do candidato"),
     *       @OA\Property(property="cpf", type="string", format="string", example="00000000000"),
     *       @OA\Property(property="data_nascimento", type="string", format="string", example="1994-11-07")
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
     *          "nome": {
     *              "O campo nome não pode ser superior a 255 caracteres.",
     *              "O campo nome deve ser uma string."
     *              },
     *          "cpf": {
     *              "O campo cpf já está sendo utilizado.",
     *              "O campo cpf não pode ser superior a 11 caracteres.",
     *              "O campo cpf deve ter pelo menos 11 caracteres."
     *              },
     *          "data_nascimento": {
     *              "Inscrição permitida apenas para maiores de 18 anos.",
     *              "O campo data nascimento não é uma data válida."
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
            $validacao = Validator::make($request->all(), (new CorredorRequest)->rules($id));

            if ($validacao->fails()) {
                return $this->responseError($validacao->errors());
            }

            $this->corredorService->atualizar($request->all(), $id);

            return $this->responseSuccess();
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *   path="/api/corredor/{id}",
     *   tags={"Corredor"},
     *   summary="Deleta corredor",
     *
     *    * @OA\Parameter(
     *    description="ID corredor",
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
     *         @OA\Property(property="mensagem", type="string", example="Não é possível excluir o corredor, pois o mesmo possui cadastro para uma ou mais provas"),
     *         @OA\Property(property="sucesso", type="bool", example="false"),
     *      )
     *    )
     *   ),
     * )
     */
    public function destroy($id)
    {
        try {

            $this->corredorService->deletar($id);

            return $this->responseSuccess();
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }
}
