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
		Brand::truncate();
		MobilePhoneModel::truncate();
		SparePart::truncate();
		Client::truncate();
		WorkOrder::truncate();

		// Stores table seed
		DB::table('users')->truncate();
		DB::table('users')->insert(['first_name' => "Παύλος", 'last_name' => "Ιωάννου", 'email' => "Pavlos@tssolutions.gr", 'password' => "$2y$10$7etbXqlXw7YkDMUNSmJ6ruhsGOc7d3HVnOLDEptyuJecIlWuOQRXK", 'user_level' => "1", 'is_active' => "1"]);
		DB::table('users')->insert(['first_name' => "Γιώργος", 'last_name' => "Μαυρίδης", 'email' => "giorgos@tssolutions.gr", 'password' => "$2y$10$7etbXqlXw7YkDMUNSmJ6ruhsGOc7d3HVnOLDEptyuJecIlWuOQRXK", 'user_level' => "2", 'is_active' => "1"]);
		DB::table('users')->insert(['first_name' => "Αλέξανδρος", 'last_name' => "Δημητρίου", 'email' => "alexandros@tssolutions.gr", 'password' => "$2y$10$7etbXqlXw7YkDMUNSmJ6ruhsGOc7d3HVnOLDEptyuJecIlWuOQRXK", 'user_level' => "3", 'is_active' => "1"]);
		DB::table('users')->insert(['first_name' => "Γιάννης", 'last_name' => "Αντωνίου", 'email' => "superuser@tssolutions.gr", 'password' => "$2y$10$7etbXqlXw7YkDMUNSmJ6ruhsGOc7d3HVnOLDEptyuJecIlWuOQRXK", 'user_level' => "4", 'is_active' => "1"]);

		DB::table('users_to_stores')->truncate();
		DB::table('users_to_stores')->insert(['user_id' => "1", 'store_id' => "1"]);
		DB::table('users_to_stores')->insert(['user_id' => "2", 'store_id' => "1"]);
		DB::table('users_to_stores')->insert(['user_id' => "3", 'store_id' => "1"]);
		DB::table('users_to_stores')->insert(['user_id' => "4", 'store_id' => "1"]);

		// Custom tokens to use
		DB::table('oauth_sessions')->truncate();
		DB::table('oauth_sessions')->insert(['client_id' => "id0", 'owner_type' => "user", 'owner_id' => "1"]);
		DB::table('oauth_sessions')->insert(['client_id' => "id0", 'owner_type' => "user", 'owner_id' => "2"]);
		DB::table('oauth_sessions')->insert(['client_id' => "id0", 'owner_type' => "user", 'owner_id' => "3"]);
		DB::table('oauth_sessions')->insert(['client_id' => "id0", 'owner_type' => "user", 'owner_id' => "4"]);

		DB::table('oauth_access_tokens')->truncate();
		DB::table('oauth_access_tokens')->insert(['id' => "CihoA0MCVVyiZEvg3vRygf8eLxRzW5g9ktSLJe7V", 'session_id' => "1", 'expire_time' => "2000000000"]);
		DB::table('oauth_access_tokens')->insert(['id' => "4XGguueeBiMSNrtA6wlnMvmhALBsX7ZtojDXarBX", 'session_id' => "2", 'expire_time' => "2000000000"]);
		DB::table('oauth_access_tokens')->insert(['id' => "uHEVT4YlnLeiM1Wq4qQc0MloiGN0MJlhJu7ODGMx", 'session_id' => "3", 'expire_time' => "2000000000"]);
		DB::table('oauth_access_tokens')->insert(['id' => "NFyCSDo3jRgHibAJgYsNbgpsrBrw5w2IFHlcqsCs", 'session_id' => "4", 'expire_time' => "2000000000"]);

		factory(Device::class, 50)->create();
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

		// Stores table seed
		DB::table('stores')->truncate();
		DB::table('stores')->insert(['name' => "TS Shop 1", 'street' => "Καραγιώργη Σερβίας", 'street_number' => "4", 'phone_number' => "6944534448", 'post_code' => "00420", 'city' => "Αθήνα", 'country' => "Ελλάδα", 'latitude' => "37.9764197", 'longitude' => "23.7338158"]);
		DB::table('stores')->insert(['name' => "TS Shop 2", 'street' => "Τσιμισκή", 'street_number' => "148", 'phone_number' => "6944534448", 'post_code' => "00420", 'city' => "Θεσσαλονίκη", 'country' => "Ελλάδα", 'latitude' => "40.6276404", 'longitude' => "22.9510195"]);
		DB::table('stores')->insert(['name' => "TS Shop 3", 'street' => "Εθνικής Αντίστασης", 'street_number' => "131", 'phone_number' => "6944534448", 'post_code' => "00420", 'city' => "Αθήνα", 'country' => "Ελλάδα", 'latitude' => "40.5790684", 'longitude' => "22.9682855"]);
		DB::table('stores')->insert(['name' => "TS Shop 4", 'street' => "Κωστή Παλαμά", 'street_number' => "9", 'phone_number' => "6944534448", 'post_code' => "00420", 'city' => "Θεσσαλονίκη", 'country' => "Ελλάδα", 'latitude' => "38.009727", 'longitude' => "23.7777981"]);
		DB::table('stores')->insert(['name' => "TS Shop 5", 'street' => "Γαρυττού", 'street_number' => "67", 'phone_number' => "6944534448", 'post_code' => "00420", 'city' => "Θεσσαλονίκη", 'country' => "Ελλάδα", 'latitude' => "38.0194594", 'longitude' => "23.818787"]);
		DB::table('stores')->insert(['name' => "TS Shop 6", 'street' => "Βουλής", 'street_number' => "3", 'phone_number' => "6944534448", 'post_code' => "00420", 'city' => "Αθήνα", 'country' => "Ελλάδα", 'latitude' => "37.9771161", 'longitude' => "23.7329023"]);

		// Enable it back
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}

}
