<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimeZoneFieldInProjectBid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_bids', function (Blueprint $table) {
            $table->string('timezone',191);
            $table->dateTime('submission_datetime')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_bids', function (Blueprint $table) {
            $table->dropColumn('timezone');
            $table->dropColumn('submission_datetime');
        });
    }
}
