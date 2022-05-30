<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AddNewTestUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('users')->insert(
            array(
                'user_level' => 'Administrator',
                'firstname' => 'Rajmund',
                'lastname' => 'Kasztan',
                'email' => 'kasztan@wp.pl',
                'password' => Hash::make('kasztan12345'),
                'remember_token' => 'kasztan123'
            )
        );
        DB::table('users')->insert(
            array(
                'user_level' => 'Student',
                'firstname' => 'Michał',
                'lastname' => 'Deska',
                'email' => 'deska@wp.pl',
                'password' => Hash::make('deska12345'),
                'remember_token' => 'deska123'
            )
        );
        DB::table('users')->insert(
            array(
                'user_level' => 'Moderator',
                'firstname' => 'Janek',
                'lastname' => 'Paker',
                'email' => 'paker@wp.pl',
                'password' => Hash::make('paker12345'),
                'remember_token' => 'paker123'
            )
        );
        DB::table('users')->insert(
            array(
                'user_level' => 'Moderator',
                'firstname' => 'Gienek',
                'lastname' => 'Pompka',
                'email' => 'pompka@wp.pl ',
                'password' => Hash::make('pompka12345'),
                'remember_token' => 'pompka123'
            )
        );
        DB::table('users')->insert(
            array(
                'user_level' => 'Student',
                'firstname' => 'Mietek',
                'lastname' => 'Bomba',
                'email' => 'bomba@wp.pl',
                'password' => Hash::make('bomba12345'),
                'remember_token' => 'bomba123'
            )
        );
        DB::table('users')->insert(
            array(
                'user_level' => 'Student',
                'firstname' => 'Paweł',
                'lastname' => 'Bochenek',
                'email' => 'bochenek@wp.pl',
                'password' => Hash::make('bochenek12345'),
                'remember_token' => 'bochenek123'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}