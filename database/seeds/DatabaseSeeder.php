<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\WorkOrderStatus;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(){

		// Disable foreign key checking because truncate() will fail
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');

		User::truncate();
		Post::truncate();
		Comment::truncate();

		factory(User::class, 10)->create();
		factory(Post::class, 50)->create();
		factory(Comment::class, 100)->create();
		factory(WorkOrderStatus::class, 5)->create();

		$this->call('OAuthClientSeeder');

		// Enable it back
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}

}
