<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;  
use App\Models\User; 

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[];
        for ($i=1; $i<=10 ; $i++) { 
        	# code...
        
        $first_name=Str::random();
        $last_name=Str::random();
        $email=Str::random().'@gmail.com';
        $password=Hash::make('userpassword');
        $uuid = Str::random(20);
        $address=Str::random();
        $phone_number=rand(1,999999);
        $data[]=['first_name'=>$first_name,'last_name'=>$last_name,'email'=>$email,'password'=>$password,'uuid'=>$uuid,'address'=>$address,'phone_number'=>$phone_number];
    }
    User::insert($data);
    }
}
