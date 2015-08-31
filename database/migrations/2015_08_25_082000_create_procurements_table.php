<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcurementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('procurements', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('company_name');
            $table->string('address');
            $table->string('phone', 30);
            $table->string('fax', 30);
            $table->string('contact_person', 30);
            $table->string('offering_letter_no', 50);
            $table->date('offering_letter_date');
            $table->string('offering_letter');
            $table->char('proc_status',1)->default(1);
            $table->integer('created_by');
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
        Schema::drop('procurements');
	}

}
