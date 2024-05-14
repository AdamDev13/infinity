<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpdateProjectEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('update_project_emails', function (Blueprint $table) {
            $table->id();
            $table->string("email_title");
            $table->text("email_content")->nullable();
            $table->unsignedBigInteger("project_id")->default(0);
            $table->unsignedBigInteger("category_id")->default(0);
            $table->date("due_date")->default('2021-12-01');
            $table->string("client_name")->default('');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('update_project_emails');
    }
}
