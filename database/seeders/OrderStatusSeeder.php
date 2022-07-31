<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order_status;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {     
    	 $data=[['uuid'=>'tregrege','title'=>'open']
    	         ,['uuid'=>'gyguybub','title'=>'pending_payment'],
    	         ['uuid'=>'sdsadaw','title'=>'paid'],
    	         ['uuid'=>'wqewrfwef','title'=>'shipped'],
    	         ['uuid'=>'nvbvnvj','title'=>'cancelled']
    	     ];

       Order_status::insert($data);  

    }
}
