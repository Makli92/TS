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
		$this->middleware('oauth', ['except' => ['createUser', 'forgotPassword', 'resetPassword']]);
		// $this->middleware('authorize_role:' . __CLASS__ . ',' . config()['roleconfig']['roles']['SUPERUSER']);
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

	// PasswordResetter methods' implementation	
	public function forgotPassword(Request $request)
	{
		$userExists = $this->checkEmail($request->get('email'));
		
		if ($userExists['response']['error']) {
			return $this->success($userExists['response'], 400);
		}

		$user = $userExists['users']->first();
		$resetTokenResponse = $this->checkResetTokenExists($user->id);

		$this->sendResetLink($user->first_name . ' ' . $user->last_name, $resetTokenResponse['reset_token']);

		return $this->success($resetTokenResponse, 200);
	}

	public function checkEmail($email) 
	{
		$users = User::where('email', '=', $email)->get();
		$response = null;

		if ($users->isEmpty()) {
			$response = array('error' => 'Email does not exist.');
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
			$response = array('error' => 'reset_token_active', 'reset_token' => $resetTokens->first()->id, 'expire_time' => $resetTokens->first()->expire_time);
		} else {
			$response = $this->generateResetToken($userId);
		}

		$response['valid_reset_token'] = true;

		return $response;
    }
    
    public function deleteResetTokenInactive($userId)
    {
    	// Delete expired tokens
    	DB::table('reset_tokens')->where('expire_time', '<', strtotime(date('Y/m/d H:i:s')))->where('owner_id', $userId)->delete();
    }

	public function generateResetToken($userId)
	{
		$resetToken = md5(uniqid(strtotime(date('Y/m/d H:i:s')), true));
		$resetTokenExpirationTime = strtotime(date('Y/m/d H:i:s')) + self::DAY_SECONDS;

		DB::table('reset_tokens')->insert(
		    ['id' => $resetToken, 'owner_id' => $userId, 'expire_time' => $resetTokenExpirationTime]
		);

		return array('reset_token' => $resetToken, 'expire_time' => $resetTokenExpirationTime);
	}

    public function sendResetLink($userFullName, $resetToken)
    {
    	$mailer = app()['mailer'];

		$mailer->raw('To reset your code please click on the following link : ' . $resetToken, function ($mail) use($userFullName) {
            $mail->from('ts@ts.com', 'TS Biz Suite');
            $mail->to('ap@anaxoft.com', $userFullName)->subject('Password Reset Link');
        });
    }

    public function resetPassword(Request $request)
    {
    	$resetToken = DB::table('reset_tokens')
    					->where('id', $request->get('reset_token'))
    					->get()
    					->first();

    	if (!$resetToken) {
    		return $this->error(['error' => 'Invalid token.'], 498);
    	}

    	if (strtotime(date('Y/m/d H:i:s')) > $resetToken->expire_time) {
    		return $this->error(['error' => 'Token expired.'], 498);
    	}

    	if (!str_is($request->get('password_field'), $request->get('password_field_verification'))) {
    		return $this->error(['error' => 'Passwords provided do not match.'], 412);
    	}

    	$user = User::find($resetToken->owner_id);
    	$hasher = app()->make('hash');
    	$user->password = $hasher->make($request->get('password_field'));
    	$user->save();

    	$this->deleteResetToken($resetToken);

    	return $this->success('', 200);
    }

    public function deleteResetToken($resetToken) 
    {
    	DB::table('reset_tokens')->where('id', $resetToken->id)->delete();
    }

}