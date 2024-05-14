<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategry1FeildInprojectBid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_bids',function (Blueprint $table){
            $table->float("monthly_cost")->nullable();
            $table->float("monthly_tax_cost")->nullable();
            $table->float("non_recurring_cost")->nullable()->comment("Installation, Construction, special construction, other non-recurring costs");
            $table->integer("term_of_contract_month")->nullable();
            $table->float('base_price')->change()->nullable();
            $table->float('contingency_fee')->change()->nullable();
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
            $table->dropColumn("monthly_cost");
            $table->dropColumn("monthly_tax_cost");
            $table->dropColumn("non_recurring_cost");
            $table->dropColumn("term_of_contract_month");
            $table->float('base_price')->change();
            $table->float('contingency_fee')->change();
        });
    }
}
