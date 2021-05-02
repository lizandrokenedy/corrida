<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResultadoRequest;
use App\Services\CorredorEmProvaService;
use App\Services\ResultadoService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResultadoController extends Controller
{

    private $resultadoService;

    public function __construct()
    {
        $this->resultadoService = new ResultadoService;
    }

    /**
     * @OA\Get(
     *   path="/api/resultado",
     *   tags={"Resultado"},
     *   summary="Lista de resultados",
     *   @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *      @OA\JsonContent(
     *         @OA\Property(property="data", type="object", example={
     *                {
     *                  "id": 1,
     *                  "corredor_id": 1,
     *                  "prova_id": 1,
     *                  "inicio_prova": "2021-04-28 08:10:12",
     *                  "conclusao_prova": "2021-04-28 09:30:13",
     *                  "created_at": "2021-04-30T00:41:13.000000Z",
     *                  "updated_at": "2021-04-30T00:41:13.000000Z"
     *                },
     *                {
     *                  "id": 2,
     *                  "corredor_id": 2,
     *                  "prova_id": 1,
     *                  "inicio_prova": "2021-04-28 08:10:12",
     *                  "conclusao_prova": "2021-04-28 09:25:13",
     *                  "created_at": "2021-04-30T00:41:40.000000Z",
     *                  "updated_at": "2021-04-30T00:41:40.000000Z"
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
            return $this->responseDataSuccess($this->resultadoService->listar());
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *   path="/api/resultado",
     *   tags={"Resultado"},
     *   summary="Cria resultado",
     *   @OA\RequestBody(
     *    required=true,
     *    description="Exemplo criar uma resultado",
     *    @OA\JsonContent(
     *       required={"corredor_id", "prova_id", "inicio_prova", "conclusao_prova"},
     *       @OA\Property(property="corredor_id", type="string", format="string", example="1"),
     *       @OA\Property(property="prova_id", type="string", format="string", example="1"),
     *       @OA\Property(property="inicio_prova", type="string", format="string", example="2021-05-31 08:35"),
     *       @OA\Property(property="conclusao_prova", type="string", format="string", example="2021-05-31 09:32")
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
     *          "inicio_prova": {
     *              "O campo inicio prova é obrigatório.",
     *              "O campo inicio prova não é uma data válida.",
     *              },
     *          "conclusao_prova": {
     *              "O campo conclusao prova é obrigatório.",
     *              "O campo conclusao prova não é uma data válida.",
     *              },
     *          "O corredor não está cadastrado para esta prova.",
     *          "O corredor já possui resultado para esta prova.",
     *          "O inicio resultado não pode ser maior ou igual a conclusão",
     *          "O início resultado não poder ser menor ou igual ao início da prova"
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

            $validacao = Validator::make($request->all(), (new ResultadoRequest())->rules());

            if ($validacao->fails()) {
                return $this->responseError($validacao->errors());
            }

            $this->resultadoService->criar($request->all());

            return $this->responseSuccess();
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }
}
