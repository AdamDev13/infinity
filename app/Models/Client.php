<?php

namespace App\Models;

class Client extends User
{

    protected $table = 'users';

    public function impersonate($user) {
    }

}
