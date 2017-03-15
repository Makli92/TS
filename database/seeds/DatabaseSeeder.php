<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\WorkOrderStatus;
use App\Models\Store;
use App\Models\Brand;
use App\Models\MobilePhoneModel;
use App\Models\SparePart;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(){

		// Disable foreign key checking because truncate() will fail
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');

		WorkOrderStatus::truncate();
		Store::truncate();
		User::truncate();
		Brand::truncate();
		MobilePhoneModel::truncate();
		SparePart::truncate();


		factory(WorkOrderStatus::class, 5)->create();
		factory(Store::class, 10)->create();
		factory(User::class, 10)->create();
		factory(Brand::class, 10)->create();
		factory(MobilePhoneModel::class, 20)->create();
		factory(SparePart::class, 100)->create();

		$this->call('OAuthClientSeeder');

		// Enable it back
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}

}
