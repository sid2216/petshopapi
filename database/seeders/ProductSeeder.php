<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
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
    $metadata=['branduuid'=>'wqeewqpoi','imguuid'=>'ioihihi'];
    $metadata=json_encode($metadata);
        $data=[['category_id'=>'1','uuid'=>'tregrege','title'=>'testproduct','description'=>'testpromotion','metadata'=>$metadata,'price'=>'55','created_at'=>$created_at,'updated_at'=>$updated_at]
    	         ,['category_id'=>'2','uuid'=>'gyguybub','title'=>'testproduct2','description'=>'testproduct-2','price'=>'55','metadata'=>$metadata,'created_at'=>$created_at,'updated_at'=>$updated_at],
    	         ['category_id'=>'3','uuid'=>'sdsadaw','title'=>'testproduct3','description'=>'testproduct-3','price'=>'55','metadata'=>$metadata,'created_at'=>$created_at,'updated_at'=>$updated_at],
    	         ['category_id'=>'4','uuid'=>'wqewrfwef','title'=>'testproduct4','description'=>'testproduct-4','price'=>'55','metadata'=>$metadata,'created_at'=>$created_at,'updated_at'=>$updated_at],
    	         ['category_id'=>'5','uuid'=>'nvbvnvj','title'=>'testproduct5','description'=>'testproduct-5','price'=>'55','metadata'=>$metadata,'created_at'=>$created_at,'updated_at'=>$updated_at]
    	     ];
    	Product::insert($data);
    
    }
}
