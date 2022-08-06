<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; 
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	 $password=Hash::make('admin');
        $data[]=['first_name'=>'admin','last_name'=>'admin','email'=>'admin@buckhill.co.uk','password'=>$password,'uuid'=>'593edc92-f998-42aa-ab91-338c0ad25a6e','address'=>'admin address','phone_number'=>'2154848','is_admin'=>1,'is_marketing'=>1];
        User::insert($data);

    }
}
