<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Vendor extends User
{

    protected $table = 'users';

    public function impersonate($user) {
    }
}
