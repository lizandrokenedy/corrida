<?php

namespace App\Services;

use App\Repositories\Eloquent\ClassificacaoGeralRepository;
use App\Repositories\Eloquent\ProvaRepository;
use App\Repositories\Eloquent\ResultadoRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class ClassificacaoGeralService
{

    private $repository;

    public function __construct()
    {
        $this->repository = new ClassificacaoGeralRepository();
    }


    public function listar()
    {
        return $this->repository->all();
    }


    /**
     * Undocumented function
     *
     * @param array $dados
     * @return boolean
     */
    public function criar(array $dados = []): bool
    {
        return $this->repository->create($dados);
    }

    /**
     * Deleta um registro por id
     *
     * @param integer $id
     * @return boolean
     */
    public function deletar(int $id): bool
    {
        $registro = $this->repository->delete($id);

        if (!$registro) {
            throw new Exception('Registro não encontrado.');
        }

        return $registro;
    }

    /**
     * Gera classificações gerais de uma prova
     *
     * @param integer $idProva
     * @return boolean
     */
    public function gerarClassificacao(int $idProva): bool
    {
        $this->repository->limparClassificacoesPorProva($idProva);

        $listaDeResultadosCorredores = (new ResultadoRepository())->consultaResultadoGeral($idProva);

        return $this->salvarPosicoes($listaDeResultadosCorredores);
    }

    /**
     * Gera e salva as posições dos corredores
     *
     * @param Collection $listaDeResultadosCorredores
     * @return boolean
     */
    private function salvarPosicoes(Collection $listaDeResultadosCorredores): bool
    {
        $posicao = 1;

        foreach ($listaDeResultadosCorredores as $resultado) {
            $this->repository->create([
                'posicao' => $posicao,
                'corredor_id' => $resultado->corredor_id,
                'prova_id' => $resultado->prova_id,
            ]);

            $posicao++;
        }

        return true;
    }
}
