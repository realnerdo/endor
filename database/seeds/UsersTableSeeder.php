<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Administrador',
            'username' => 'admin',
            'email' => 'cotizador@grupoendor.com',
            'password' => bcrypt('admin'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Asael Jaimes',
            'username' => 'asaelx',
            'email' => 'asael@grupoendor.com',
            'password' => bcrypt('asaelx'),
            'role' => 'employee'
        ]);
    }
}
