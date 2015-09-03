<?php

use Illuminate\Database\Seeder;
use qilara\Models\Role;

class RoleTableSeeder extends Seeder
{

	public function run()
	{
		//DB::table('users')->delete();
		Role::create(array(
			'name'     => 'administrator',
			'display_name' => 'Administrator',
			'description'    => 'DemiGod Account'
		));

        Role::create(array(
            'name'     => 'registered',
            'display_name' => 'Registered User',
            'description'    => 'Standard User'
        ));

        DB::table('role_user')->insert(
            ['user_id' => 1, 'role_id' => 1]
        );
	}

}