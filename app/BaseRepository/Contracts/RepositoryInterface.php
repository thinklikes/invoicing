<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2018/11/19
 * Time: 上午 12:05
 */

namespace App\BaseRepository\Contracts;

interface RepositoryInterface {

    public function all($columns = array('*'));

    public function paginate($perPage = 15, $columns = array('*'));

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function find($id, $columns = array('*'));

    public function findBy($field, $value, $columns = array('*'));
}