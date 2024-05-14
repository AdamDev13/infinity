<?php
namespace App\Models;
class Admin extends User
{

    protected $table = 'users';

    public function impersonate($user) {
    }

}
