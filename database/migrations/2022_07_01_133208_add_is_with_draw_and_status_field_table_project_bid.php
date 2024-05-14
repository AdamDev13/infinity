<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsWithDrawAndStatusFieldTableProjectBid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_bids',function (Blueprint $table){
            $table->boolean("is_withdraw")->default(false);
            $table->enum("status",["A","L","R","RE"])->default("A");
            $table->text("note")->nullable();
            $table->boolean("is_approved")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_bids',function (Blueprint $table){
            $table->dropColumn("is_withdraw");
            $table->dropColumn("status",["A","L","R","RE"]);
            $table->dropColumn("note");
            $table->dropColumn("is_approved");
        });
    }
}
