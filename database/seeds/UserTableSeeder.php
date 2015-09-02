<?php

use Illuminate\Database\Seeder;
use qilara\Models\User;

class UserTableSeeder extends Seeder
{

	public function run()
	{
		//DB::table('users')->delete();
		User::create(array(
			'name'     => 'Andri Fachrur Rozie',
			'username' => 'andri',
			'email'    => 'rozie.andri@gmail.com',
			'password' => Hash::make('!w3rty'),
		));
	}

}