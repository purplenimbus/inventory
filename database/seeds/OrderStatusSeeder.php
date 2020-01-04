<?php
use App\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $statuses = [
      	['name' => 'completed'],
      	['name' => 'created'],
      	['name' => 'voided'],
      ];

      foreach($statuses as $status){
				OrderStatus::create($status);
			}
    }
}
