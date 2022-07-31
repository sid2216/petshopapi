<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Post;
use Illuminate\Support\Str;
class PostSeeder extends Seeder
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
    $metadata=['author'=>'testauthor','imguuid'=>'2'];
    $metadata=json_encode($metadata);
        $data=[['uuid'=>'tregrege','title'=>'testpost','slug'=>'testpost','metadata'=>$metadata,'content'=>'sadad','created_at'=>$created_at,'updated_at'=>$updated_at]
    	         ,['uuid'=>'gyguybub','title'=>'testpost2','slug'=>'testpost-2','metadata'=>$metadata,'content'=>'sadad','created_at'=>$created_at,'updated_at'=>$updated_at],
    	         ['uuid'=>'sdsadaw','title'=>'testpost3','slug'=>'testpost-3','metadata'=>$metadata,'content'=>'sadad','created_at'=>$created_at,'updated_at'=>$updated_at],
    	         ['uuid'=>'wqewrfwef','title'=>'testpost4','slug'=>'testpost-4','metadata'=>$metadata,'content'=>'sadad','created_at'=>$created_at,'updated_at'=>$updated_at],
    	         ['uuid'=>'nvbvnvj','title'=>'testpost5','slug'=>'testpost-5','metadata'=>$metadata,'content'=>'sadad','created_at'=>$created_at,'updated_at'=>$updated_at]
    	     ];
    	Post::insert($data);
    }
}
