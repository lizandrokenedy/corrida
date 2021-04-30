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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
