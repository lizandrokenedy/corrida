<?php

namespace App\Http\Controllers;

use App\Http\Requests\CorredorEmProvaRequest;
use App\Services\CorredorEmProvaService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CorredorEmProvaController extends Controller
{
    public function __construct()
    {
        $this->corredorEmProvaService = new CorredorEmProvaService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            return $this->responseDataSuccess($this->corredorEmProvaService->obterPorId($id));
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validacao = Validator::make($request->all(), (new CorredorEmProvaRequest())->rules($id));

            if ($validacao->fails()) {
                return $this->responseError($validacao->errors());
            }

            $this->corredorEmProvaService->atualizar($request->all(), $id);

            return $this->responseSuccess();
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
