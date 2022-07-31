<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Payment;
use Illuminate\Support\Carbon;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
    	$credit_card = json_encode(["holder_name"=> "","number"=> "",
    		"ccv"=> "","expire_date"=> ""]);
    	$cash_on_delivary = json_encode(["first_name"=> "","last_name"=> "","address"=> ""]);
    	$bank_transfer = json_encode(["swift"=> "","iban"=> "","name"=> ""]);

    	$created_at =Carbon::now()->format('Y-m-d H:i:s');
    $updated_at = Carbon::now()->format('Y-m-d H:i:s');
        $data = [['uuid'=>'fwreffsd','type'=>'credit_card','details'=>$credit_card,'created_at'=>$created_at,'updated_at'=>$updated_at],['uuid'=>'uihuiui','type'=>'cash_on_delivary','details'=>$cash_on_delivary,'created_at'=>$created_at,'updated_at'=>$updated_at],['uuid'=>'bnmbjhy','type'=>'bank_transfer','details'=>$bank_transfer,'created_at'=>$created_at,'updated_at'=>$updated_at]];
      Payment::insert($data);
            
    }
}
