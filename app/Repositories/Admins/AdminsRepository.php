<?php

namespace App\Repositories\Admins;

use App\Admin;
use App\Repositories\BaseRepository;

class AdminsRepository extends BaseRepository implements AdminsRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(Admin::Query());
    }

    public function list($with_get = true, array $param = [])
    {
        $name = $param["name"] ?? null;
        $email = $param["email"] ?? null;
        $adminId = $param["adminId"] ?? null;

        $admins = $this->query();

        if ($adminId) {
            $admins = $admins->where('id', '!=', $adminId);
        }
        if ($name) {
            $admins = $admins->where('name', 'like', '%' . $name . '%');
        }
        if ($email) {
            $admins = $admins->where('email', 'like', '%' . $email . '%');
        }

        if ($with_get) {
            $admins = $admins->get();
        }
        return $admins;
    }

}
