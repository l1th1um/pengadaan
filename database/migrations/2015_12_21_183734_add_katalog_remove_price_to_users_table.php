<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKatalogRemovePriceToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('memo_items', function(Blueprint $table)
		{
			$table->string('catalog', 50)->after('item_name');
			$table->dropColumn('unit_price');
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
			$table->dropColumn('catalog');
			$table->integer('unit_price')->after('unit');

		});
	}

}
