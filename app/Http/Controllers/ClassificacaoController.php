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


    public function gerarClassificacao($idProva)
    {
        try {

            $validacao = Validator::make(['prova_id' => $idProva], (new ClassificacaoRequest())->rules());

            if ($validacao->fails()) {
                return $this->responseError($validacao->errors());
            }

            DB::transaction(function () use ($idProva) {
                $this->classificacaoGeralService->gerarClassificacao($idProva);
                $this->classificacaoPorIdadeService->gerarClassificacao($idProva);
            });

            return $this->responseSuccess();
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * Consulta classificação geral
     *
     * @param [type] $idProva
     * @return Response
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
     * Consulta classificação por idade
     *
     * @param [type] $idProva
     * @return Response
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
