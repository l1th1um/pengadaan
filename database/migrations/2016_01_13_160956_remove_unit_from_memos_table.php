<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUnitFromMemosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('memos', function(Blueprint $table)
		{
			$table->dropColumn('unit');
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
			$table->string('unit')->after('regarding');
		});
	}

}
