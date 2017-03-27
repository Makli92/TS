<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Device;
use App\Models\Store;
use App\Models\Brand;
use App\Models\MobilePhoneModel;
use App\Models\SparePart;
use App\Models\Client;
use App\Models\WorkOrder;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(){

		// Disable foreign key checking because truncate() will fail
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');

		Device::truncate();
		Store::truncate();
		User::truncate();
		Brand::truncate();
		MobilePhoneModel::truncate();
		SparePart::truncate();
		Client::truncate();
		WorkOrder::truncate();

		factory(Device::class, 50)->create();
		factory(Store::class, 10)->create();
		factory(User::class, 10)->create();
		factory(Brand::class, 10)->create();
		factory(MobilePhoneModel::class, 20)->create();
		factory(SparePart::class, 100)->create();
		factory(Client::class, 100)->create();
		factory(WorkOrder::class, 5)->create();

		$this->call('OAuthClientSeeder');

		// VAT table seed
		DB::table('vat_categories')->truncate();
		DB::table('vat_categories')->insert([   
			'id' => "1",
			'description' => "Κανονικός",
			'value' => "24"]);

		DB::table('vat_categories')->insert([   
			'id' => "2",
			'description' => "Μειωμένος",
			'value' => "13"]);

		DB::table('vat_categories')->insert([
		   'id' => "3",
			'description' => "Υπερμειωμένος",
			'value' => "6"]);

		// Work Order status table seed
		DB::table('work_order_statuses')->truncate();
		DB::table('work_order_statuses')->insert(['code' => "100", 'name' => "Unit received"]);
		DB::table('work_order_statuses')->insert(['code' => "200", 'name' => "Technician assigned"]);
		DB::table('work_order_statuses')->insert(['code' => "250", 'name' => "Diagnosis"]);
		DB::table('work_order_statuses')->insert(['code' => "700", 'name' => "Quotation"]);
		DB::table('work_order_statuses')->insert(['code' => "710", 'name' => "Quotation Accepted"]);
		DB::table('work_order_statuses')->insert(['code' => "720", 'name' => "Quotation Rejected"]);
		DB::table('work_order_statuses')->insert(['code' => "810", 'name' => "Shipped to external Serive"]);
		DB::table('work_order_statuses')->insert(['code' => "980", 'name' => "Closed technician"]);
		DB::table('work_order_statuses')->insert(['code' => "990", 'name' => "Repair completed"]);

		// Enable it back
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}

}
