<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemoItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('memo_items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('memo_id');
			$table->string('item_name');
			$table->integer('amount');
			$table->string('unit', 30);
			$table->integer('unit_price');
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
		Schema::drop('memo_items');
	}

}
