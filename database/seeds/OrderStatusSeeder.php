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
      	['name' => 'created'],
        ['name' => 'completed'],
      	['name' => 'voided'],
      ];

      foreach($statuses as $status){
				OrderStatus::create($status);
			}
    }
}
