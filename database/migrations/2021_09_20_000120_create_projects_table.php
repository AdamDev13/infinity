<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id()->from(50000);
            $table->unsignedBigInteger("user_id");
            $table->string("project_number")->default(0);
            $table->string("name")->nullable();
            $table->unsignedBigInteger("category_id")->default(0);
            $table->text("description");
            $table->string("timezone")->nullable();
            $table->date("deadline_date");
            $table->time("deadline_time");
            $table->date("public_date");
            $table->integer("deadline_beyond")->default(1000000);
            $table->boolean("walkthrough")->default(1);
            $table->json("rfps")->nullable();
            $table->json("addendums")->nullable();
            $table->string("status")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
