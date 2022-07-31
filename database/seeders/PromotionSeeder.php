<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Promotion;
use Illuminate\Support\Str;

class PromotionSeeder extends Seeder
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
    $validfrom=date('Y-m-d');
    $validto=date('Y-m-d');
    $metadata=['validfrom'=>$validfrom,'validto'=>$validto,'imguuid'=>'ioihihi'];
    $metadata=json_encode($metadata);
        $data=[['uuid'=>'tregrege','title'=>'testpromotion','content'=>'testpromotion','metadata'=>$metadata,'created_at'=>$created_at,'updated_at'=>$updated_at]
    	         ,['uuid'=>'gyguybub','title'=>'testpromotion2','content'=>'testpromotion-2','metadata'=>$metadata,'created_at'=>$created_at,'updated_at'=>$updated_at],
    	         ['uuid'=>'sdsadaw','title'=>'testpromotion3','content'=>'testpromotion-3','metadata'=>$metadata,'created_at'=>$created_at,'updated_at'=>$updated_at],
    	         ['uuid'=>'wqewrfwef','title'=>'testpromotion4','content'=>'testpromotion-4','metadata'=>$metadata,'created_at'=>$created_at,'updated_at'=>$updated_at],
    	         ['uuid'=>'nvbvnvj','title'=>'testpromotion5','content'=>'testpromotion-5','metadata'=>$metadata,'created_at'=>$created_at,'updated_at'=>$updated_at]
    	     ];
    	Promotion::insert($data);
    }
}
