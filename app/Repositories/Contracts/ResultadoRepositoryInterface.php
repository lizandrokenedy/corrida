<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ResultadoRepositoryInterface
{
    public function all(string $column = 'id', string $order = 'ASC'): Collection;
    public function paginate(int $paginate = 10, string $column = 'id', string $order = 'ASC'): LengthAwarePaginator;
    public function findWhereLike(array $columns, string $search, string $column = 'id', string $order = 'ASC'): Collection;
    public function create(array $data): bool;
    public function find(int $id);
    public function update(array $data, int $id): bool;
    public function delete(int $id): bool;
    public function consultaResultadoProvaCorredor(int $idProva, int $idCorredor): Collection;
    public function consultaResultadoGeral(int $idProva): Collection;
    public function consultaResultadoPorFaixaDeIdade(int $idProva, int $faixaInicial, int $faixaFinal): Collection;
}
