<?php
/**
 * Created by PhpStorm.
 * User: ilyazakruta
 * Date: 10.02.2019
 * Time: 15:24
 */

namespace App\Http\Repositories;

interface RepositoryInterface
{
    public function all();

    public function last($limit);

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function show($id);
}