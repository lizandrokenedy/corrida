<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassificacaoRequest;
use App\Services\ClassificacaoGeralService;
use App\Services\ClassificacaoPorIdadeService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClassificacaoController extends Controller
{

    private $classificacaoGeralService;
    private $classificacaoPorIdadeService;

    public function __construct()
    {
        $this->classificacaoGeralService = new ClassificacaoGeralService;
        $this->classificacaoPorIdadeService = new ClassificacaoPorIdadeService;
    }

    /**
     * @OA\Post(
     *   path="/api/classificacao/gerar",
     *   tags={"Classificação"},
     *   summary="Gera classificações gerais e por idade",
     * @OA\RequestBody(
     *    required=true,
     *    description="Exemplo para gerar classificações",
     *    @OA\JsonContent(
     *       required={"prova_id"},
     *       @OA\Property(property="prova_id", type="string", format="integer", example="1")
     *    ),
     * ),
     *
     * @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *    @OA\JsonContent(
     *         @OA\Property(property="mensagem", type="string", example="Operação realizada com sucesso."),
     *         @OA\Property(property="sucesso", type="bool", example="true")
     *    )
     *  ),
     *
     * @OA\Response(
     *    response=400,
     *    description="Erro",
     *    @OA\JsonContent(
     *         @OA\Property(property="mensagem", type="object", example={
     *          "prova_id": {
     *              "Prova não encontrada.",
     *              "É necessário informar uma prova para gerar as classificações."}
     *           }
     *         ),
     *         @OA\Property(property="sucesso", type="bool", example="false"),
     *      )
     *    )
     * ),
     *
     */
    public function gerarClassificacao(Request $request)
    {
        try {

            $validacao = Validator::make(
                $request->all(),
                (new ClassificacaoRequest())->rules(),
                (new ClassificacaoRequest())->messages()
            );

            if ($validacao->fails()) {
                return $this->responseError($validacao->errors());
            }

            DB::transaction(function () use ($request) {
                $this->classificacaoGeralService->gerarClassificacao($request->prova_id);
                $this->classificacaoPorIdadeService->gerarClassificacao($request->prova_id);
            });

            return $this->responseSuccess();
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *   path="/api/classificacao/geral",
     *   tags={"Classificação"},
     *   summary="Lista de classificados geral",
     *   @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *      @OA\JsonContent(
     *         @OA\Property(property="data", type="object", example={
     *            "3 km": {
     *                "corredores":{
     *                    {
     *                       "posicao": 1,
     *                       "nome": "Candidato 1",
     *                       "cpf": "00000000000",
     *                    },
     *                    {
     *                       "posicao": 2,
     *                       "nome": "Candidato 2",
     *                       "cpf": "00000000000",
     *                    },
     *                    {
     *                       "posicao": 3,
     *                       "nome": "Candidato 3",
     *                       "cpf": "00000000000",
     *                    }
     *               }
     *           }
     *      }),
     *         @OA\Property(property="mensagem", type="string", example="Operação realizada com sucesso."),
     *         @OA\Property(property="sucesso", type="bool", example="true")
     *      )
     *   ),
     *   @OA\Response(
     *    response=400,
     *    description="Erro",
     *      @OA\JsonContent(
     *         @OA\Property(property="mensagem", type="string", example="Erro ao realizar operação."),
     *         @OA\Property(property="sucesso", type="bool", example="false")
     *      )
     *   ),
     * )
     */
    public function consultaClassificacaoGeral()
    {
        try {
            return $this->responseDataSuccess([$this->classificacaoGeralService->listar()]);
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }


    /**
     * @OA\Get(
     *   path="/api/classificacao/por-idade",
     *   tags={"Classificação"},
     *   summary="Lista de classificados por faixa de idade",
     *   @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *      @OA\JsonContent(
     *          @OA\Property(property="data", type="object", example={
     *            "3 km": {
     *                "corredores":{
     *                   "18 – 25 anos": {
     *                       {
     *                          "posicao": 1,
     *                          "idade": 24,
     *                          "nome": "Candidato 1",
     *                          "cpf": "00000000000",
     *                       },
     *                       {
     *                          "posicao": 2,
     *                          "idade": 20,
     *                          "nome": "Candidato 2",
     *                          "cpf": "00000000000",
     *                       },
     *                       {
     *                          "posicao": 3,
     *                          "idade": 25,
     *                          "nome": "Candidato 3",
     *                          "cpf": "00000000000",
     *                       }
     *                    },
     *                   "26 – 35 anos": {
     *                       {
     *                          "posicao": 1,
     *                          "idade": 26,
     *                          "nome": "Candidato 1",
     *                          "cpf": "00000000000",
     *                       },
     *                       {
     *                          "posicao": 2,
     *                          "idade": 30,
     *                          "nome": "Candidato 2",
     *                          "cpf": "00000000000",
     *                       }
     *                    },
     *                   "Acima dos 56 anos": {
     *                       {
     *                          "posicao": 1,
     *                          "idade": 60,
     *                          "nome": "Candidato 1",
     *                          "cpf": "00000000000",
     *                       },
     *                    }
     *                 }
     *             }
     *         }),
     *         @OA\Property(property="mensagem", type="string", example="Operação realizada com sucesso."),
     *         @OA\Property(property="sucesso", type="bool", example="true")
     *      )
     *   ),
     *   @OA\Response(
     *    response=400,
     *    description="Erro",
     *      @OA\JsonContent(
     *         @OA\Property(property="mensagem", type="string", example="Erro ao realizar operação."),
     *         @OA\Property(property="sucesso", type="bool", example="false")
     *      )
     *   ),
     * )
     */
    public function consultaClassificacaoPorIdade()
    {
        try {
            return $this->responseDataSuccess($this->classificacaoPorIdadeService->listar());
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }
}
