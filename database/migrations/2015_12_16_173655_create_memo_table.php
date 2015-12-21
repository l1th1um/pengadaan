<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('memos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('memo_no', 50);
			$table->integer('user_id');
			$table->date('memo_date');
			$table->string('regarding');
			$table->string('unit');
			$table->char('memo_status',1)->default(0);
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
		Schema::drop('memos');
	}

}
