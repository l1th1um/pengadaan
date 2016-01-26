<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCoordinatorAndCoToMemosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('memos', function(Blueprint $table)
		{
			$table->integer('commitment_official')->unsigned()->after('memo_status');
			$table->integer('coordinator')->unsigned()->after('memo_status');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('memos', function(Blueprint $table)
		{
			$table->dropColumn('commitment_official');
			$table->dropColumn('coordinator');
		});
	}

}
