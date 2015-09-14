<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentProofToProcurementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('procurements', function(Blueprint $table)
        {
            $table->string('payment_proof')->after('proc_status');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('procurements', function(Blueprint $table)
        {
            $table->dropColumn('payment_proof');
        });
	}

}
