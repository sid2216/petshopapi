<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $created_at =Carbon::now()->format('Y-m-d H:i:s');
    $updated_at = Carbon::now()->format('Y-m-d H:i:s');
        $data=[['uuid'=>'tregrege','title'=>'testbrand','slug'=>'testbrand','created_at'=>$created_at,'updated_at'=>$updated_at]
    	         ,['uuid'=>'gyguybub','title'=>'testbrand2','slug'=>'testbrand-2','created_at'=>$created_at,'updated_at'=>$updated_at],
    	         ['uuid'=>'sdsadaw','title'=>'testbrand3','slug'=>'testbrand-3','created_at'=>$created_at,'updated_at'=>$updated_at],
    	         ['uuid'=>'wqewrfwef','title'=>'testbrand4','slug'=>'testbrand-4','created_at'=>$created_at,'updated_at'=>$updated_at],
    	         ['uuid'=>'nvbvnvj','title'=>'testbrand5','slug'=>'testbrand-5','created_at'=>$created_at,'updated_at'=>$updated_at]
    	     ];
    	Brand::insert($data);   
    }
}
