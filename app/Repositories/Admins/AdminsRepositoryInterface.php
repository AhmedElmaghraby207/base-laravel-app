<?php

namespace App\Repositories\Admins;

interface AdminsRepositoryInterface
{
    public function get($id, $fail = true);

    public function list($with_get = true, array $param = []);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
}
