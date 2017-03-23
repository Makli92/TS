<?php 

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller{

	public function __construct()
	{
		$this->middleware('oauth');
		$this->middleware('authorize_role:' . __CLASS__ . ',' . config()['roleconfig']['roles']['USER_ADMIN']);
	}

	public function getUsers()
	{
		$users = User::with('store')->paginate(5)->select('firstname', 'lastname');
		return $this->success($users, 200);
	}

	public function createUser(Request $request)
	{

		$this->validateRequest($request);

		$user = User::create([
					'first_name' => $request->get('first_name'),
					'last_name' => $request->get('last_name'),
					'email' => $request->get('email'),
					'password'=> Hash::make($request->get('password'))
				]);

		return $this->success("The user with with id {$user->id} has been created", 201);
	}

	public function getUser($id)
	{

		$user = User::find($id);

		if(!$user){
			return $this->error("The user with {$id} doesn't exist", 404);
		}

		return $this->success($user, 200);
	}

	public function updateUser(Request $request, $id)
	{

		$user = User::find($id);

		if(!$user){
			return $this->error("The user with {$id} doesn't exist", 404);
		}

		$this->validateRequest($request);

		$user->email 		= $request->get('email');
		$user->password 	= Hash::make($request->get('password'));

		$user->save();

		return $this->success("The user with with id {$user->id} has been updated", 200);
	}

	public function deleteUser($id)
	{

		$user = User::find($id);

		if(!$user){
			return $this->error("The user with {$id} doesn't exist", 404);
		}

		$user->delete();

		return $this->success("The user with with id {$id} has been deleted", 200);
	}

	public function validateRequest(Request $request)
	{
		$rules = [
			'email' => 'required|email|unique:users', 
			'password' => 'required|min:6'
		];

		$this->validate($request, $rules);
	}

	public function isAuthorized(Request $request)
	{
		$resource = "users";
		// $user     = User::find($this->getArgs($request)["user_id"]);

		return $this->authorizeUser($request, $resource);
	}
}