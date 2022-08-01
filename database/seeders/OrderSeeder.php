<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Order;
use Illuminate\Support\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$data = [];
    	for ($i=1; $i <=50 ; $i++) { 
    	
    	
    	$user_id = rand(21,30);
        $order_status_id = rand(1,5);
        $payment_id= rand(1,3);
        $uuid = Str::random(20);
        $amount = rand(1, 99999);
        $prod_uuid=Str::random(20);
        $quantity=rand(1,100);

         $product=['product'=>$prod_uuid,'quantity'=>$quantity];
         $product=json_encode($product);
        
         $address = ['billing'=>'Goregaon west','shipping'=>'Goregaonwest'];
         $address=json_encode($address);
          $created_at =Carbon::now()->format('Y-m-d H:i:s');
          $updated_at = Carbon::now()->format('Y-m-d H:i:s');

        $data[]=['user_id'=>$user_id,'order_status_id'=>$order_status_id,'payment_id'=>$payment_id,'uuid'=>$uuid,'products'=>$product,'address'=>$address,'amount'=>$amount,'created_at'=>$created_at,'updated_at'=>$updated_at];
    }
    //dd($data);
    Order::insert($data);

    }
}
