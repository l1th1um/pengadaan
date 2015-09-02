<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUpdatedByToProcurementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('procurements', function(Blueprint $table)
        {
            $table->integer('updated_by')->after('created_by');
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
            $table->dropColumn('updated_by');
        });
	}

}
