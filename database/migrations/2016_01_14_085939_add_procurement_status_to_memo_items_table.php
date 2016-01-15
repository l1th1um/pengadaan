<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProcurementStatusToMemoItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('memo_items', function(Blueprint $table)
		{
			$table->char('procurement_status',1)->default(0)->after('status');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('memo_items', function(Blueprint $table)
		{
			$table->dropColumn('procurement_status');
		});
	}

}