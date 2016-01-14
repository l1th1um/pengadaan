<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToMemoItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('memo_items', function(Blueprint $table)
		{
			$table->char('status',1)->default(0)->after('unit');
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
			$table->dropColumn('status');
		});
	}

}
