<?php 

namespace App\Http\Controllers;

use App\Models\User;
use App\Interfaces\PasswordResetter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller implements PasswordResetter
{
	const DAY_SECONDS = 86.400;

	public function __construct()
	{
		$this->middleware('oauth', ['except' => ['createUser', 'forgotPassword']]);
		// $this->middleware('authorize_role:' . __CLASS__ . ',' . config()['roleconfig']['roles']['SUPERUSER']);
	}

	public function forgotPassword(Request $request)
	{
		$userExists = $this->checkEmail($request->get('email'));
		
		if (!$userExists['response']['sent']) {
			return $this->success($userExists['response'], 400);
		}

		$user = $userExists['users']->first();

		$resetTokenResponse = $this->checkResetTokenExists($user->id);

		// $reset_tokens = DB::table('reset_tokens')->where('owner_id', $user->id)->get();
		// if (!$reset_tokens->isEmpty()) {
		// 	return $this->success(['sent' => false, 'error' => 'reset_token'], 400);
		// }

		// return $this->success($users['response'], 200);
		return $this->success($resetTokenResponse, 200);
	}

	public function checkEmail($email) 
	{
		$users = User::where('email', '=', $email)->get();
		$response;

		if ($users->isEmpty()) {
			$response = array('sent' => false, 'error' => 'email');
		} else {
			$response = array('sent' => true);
		}

		return array('users' => $users, 'response' => $response);
	}

    public function checkResetTokenExists($userId) 
    {
    	$this->deleteResetTokenInactive($userId);

    	$resetTokens = DB::table('reset_tokens')
						->where('owner_id', $userId)
						->where('expire_time', '>', strtotime(date('Y/m/d H:i:s')))
						->get();
    	$response;

		if (!$resetTokens->isEmpty()) {
			$response = array('exists' => true, 'error' => 'reset_token', 'reset_token' => $resetTokens->first()->id);
		} else {
			$resetToken = $this->generateResetToken($userId);
			$response = array('exists' => false, 'reset_token' => $resetToken);
		}

		return $response;
    }
    
    public function deleteResetTokenInactive()
    {
    	// Delete expired tokens
    	DB::table('reset_tokens')->where('expire_time', '<', strtotime(date('Y/m/d H:i:s')))->delete();
    }

	public function generateResetToken($userId)
	{
		$resetToken = md5(uniqid(strtotime(date('Y/m/d H:i:s')), true));

		DB::table('reset_tokens')->insert(
		    ['id' => $resetToken, 'owner_id' => $userId, 'expire_time' => strtotime(date('Y/m/d H:i:s')) + self::DAY_SECONDS]
		);

		return $resetToken;
	}

    public function sendResetLink()
    {

    }

    public function resetPassword()
    {

    }

	public function me()
	{
		$me = User::find($this->getUserId());
		return $this->success($me, 200);
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
					'password'=> Hash::make($request->get('password')),
					'user_level' => 1
				]);

		echo "hrema";

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