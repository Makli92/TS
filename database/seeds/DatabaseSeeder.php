<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Work_Order_Status;
// use App\Models\Store;
use App\Models\Brand;
use App\Models\Mobile_Phone_Model;
use App\Models\Spare_Part;
// use App\Models\Client;
// use App\Models\WorkOrder;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(){

		// Disable foreign key checking because truncate() will fail
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');

		Work_Order_Status::truncate();
		// Store::truncate();
		User::truncate();
		Brand::truncate();
		Mobile_Phone_Model::truncate();
		Spare_Part::truncate();
		// Client::truncate();
		// WorkOrder::truncate();

		factory(Work_Order_Status::class, 5)->create();
		// factory(Store::class, 10)->create();
		factory(User::class, 10)->create();
		factory(Brand::class, 10)->create();
		factory(Mobile_Phone_Model::class, 20)->create();
		factory(Spare_Part::class, 100)->create();
		// factory(Client::class, 100)->create();
		// factory(WorkOrder::class, 5)->create();

		$this->call('OAuthClientSeeder');

		// Enable it back
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}

}
