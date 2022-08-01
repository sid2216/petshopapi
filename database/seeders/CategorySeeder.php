<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Carbon;

class CategorySeeder extends Seeder
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
        $data=[['uuid'=>'tregrege','title'=>'testcategory','slug'=>'testcategory','created_at'=>$created_at,'updated_at'=>$updated_at]
    	         ,['uuid'=>'gyguybub','title'=>'testcategory2','slug'=>'testcategory-2','created_at'=>$created_at,'updated_at'=>$updated_at],
    	         ['uuid'=>'sdsadaw','title'=>'testcategory3','slug'=>'testcategory-3','created_at'=>$created_at,'updated_at'=>$updated_at],
    	         ['uuid'=>'wqewrfwef','title'=>'testcategory4','slug'=>'testproduct-4','created_at'=>$created_at,'updated_at'=>$updated_at],
    	         ['uuid'=>'nvbvnvj','title'=>'testcategory5','slug'=>'testcategory-5','created_at'=>$created_at,'updated_at'=>$updated_at]
    	     ];
    	Category::insert($data);     
    }
}
