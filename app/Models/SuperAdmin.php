<?php

namespace App\Models;

class SuperAdmin extends User
{
    
    protected $table = 'users';

    public function impersonate($user) {
    }

}
