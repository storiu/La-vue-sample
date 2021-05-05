<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

abstract class Repository {

    protected function getCount($sql, $args = [])
    {
        $data = DB::selectOne($sql, $args);
        return $data->count;
    }
}
