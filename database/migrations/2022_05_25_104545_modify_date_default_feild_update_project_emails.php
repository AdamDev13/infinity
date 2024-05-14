<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyDateDefaultFeildUpdateProjectEmails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('update_project_emails',function (Blueprint $table){
            $table->date("due_date")->default(now())->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('update_project_emails',function (Blueprint $table){
            $table->date("due_date")->default('2021-12-01')->change();
        });
    }
}
