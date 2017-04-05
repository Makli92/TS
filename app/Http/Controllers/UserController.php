<?php 

namespace App\Http\Controllers;

use App\Models\User;
use App\Interfaces\PasswordResetter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller implements PasswordResetter
{
	const CONST_DAY_SECONDS = 86.400;
	private $currentTimeToMillis;

	public function __construct()
	{
		$this->currentTimeToMillis = strtotime(date('Y/m/d H:i:s'));
		$this->middleware('oauth', ['except' => ['createUser', 'forgotPassword', 'resetPassword']]);
		// $this->middleware('authorize_role:' . __CLASS__ . ',' . config()['roleconfig']['roles']['SUPERUSER']);
	}

	/**
     * @SWG\Get(
     *     path="/me",
     *     description="If logged in, returns basic details of current user.",
     *     operationId="me",
     *     produces={"application/json"},
     *     tags={"User"},
     * 	   @SWG\Parameter(
     *         name="access_token",
     *         in="query",
     *         description="User's token",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="User info retrieved",
     *         @SWG\Schema(ref="#/definitions/User")
     *     ),
     * 	   @SWG\Response(
     *         response=401,
     *         description="Invalid token"
     *     )
     * )
     */
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

	/**
     * @SWG\Post(
     *     path="/password/forgot",
     *     description="Forgot password",
     *     operationId="forgotPassword",
     *     produces={"application/json"},
     *     tags={"User"},
     * 	   @SWG\Parameter(
     *         name="email",
     *         in="body",
     *         description="User's email",
     *         required=true,
     *         type="string",
	 *         @SWG\Schema(
	 *           	required={"email"},
	 *           	@SWG\Property(property="email", type="string")
	 *         )
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Email sent to user"
     *     ),
     * 	   @SWG\Response(
     *         response=400,
     *         description="User not found"
     *     )
     * )
     */
	public function forgotPassword(Request $request)
	{
		$userExists = $this->checkEmail($request->get('email'));
		
		if ($userExists['response']['error']) {
			return $this->success($userExists['response'], 400);
		}

		$user = $userExists['users']->first();
		$resetTokenResponse = $this->checkResetTokenExists($user->id);

		$this->sendResetLink($user->first_name . ' ' . $user->last_name, $user->email, $resetTokenResponse['reset_token']);

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
						->where('expire_time', '>', $this->currentTimeToMillis)
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
    	DB::table('reset_tokens')->where('expire_time', '<', $this->currentTimeToMillis)->where('owner_id', $userId)->delete();
    }

	public function generateResetToken($userId)
	{
		$resetToken = md5(uniqid($this->currentTimeToMillis, true));
		$resetTokenExpirationTime = $this->currentTimeToMillis + self::CONST_DAY_SECONDS;

		DB::table('reset_tokens')->insert(
		    ['id' => $resetToken, 'owner_id' => $userId, 'expire_time' => $resetTokenExpirationTime]
		);

		return array('reset_token' => $resetToken, 'expire_time' => $resetTokenExpirationTime);
	}

    public function sendResetLink($userFullName, $userEmail, $resetToken)
    {
    	$mailer = app()['mailer'];

		$mailer->raw('To reset your code please click on the following link : ' . $resetToken, function ($mail) use ($userFullName, $userEmail) {
            $mail->from('ts@ts.com', 'TS Biz Suite');
            $mail->to($userEmail, $userFullName)->subject('Password Reset Link');
        });
    }

	/**
     * @SWG\Post(
     *     path="/password/reset",
     *     description="Reset password with given reset token",
     *     operationId="resetPassword",
     *     produces={"application/json"},
     *     tags={"User"},
     * 	   @SWG\Parameter(
     *         name="reset_token",
     *         in="body",
     *         description="Reset token",
     *         required=true,
     *         type="string",
	 *         @SWG\Schema(
	 *           	required={"email"},
	 *           	@SWG\Property(property="reset_token", type="string")
	 *         )
     *     ),
     * 	   @SWG\Parameter(
     *         name="password_field",
     *         in="body",
     *         description="Password",
     *         required=true,
     *         type="string",
	 *         @SWG\Schema(
	 *           	required={"email"},
	 *           	@SWG\Property(property="password_field", type="string")
	 *         )
     *     ),
     * 	   @SWG\Parameter(
     *         name="password_field_verification",
     *         in="body",
     *         description="Password Verification",
     *         required=true,
     *         type="string",
	 *         @SWG\Schema(
	 *           	required={"email"},
	 *           	@SWG\Property(property="password_field_verification", type="string")
	 *         )
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Password resetted"
     *     ),
     * 	   @SWG\Response(
     *         response=498,
     *         description="Invalid reset token"
     *     ),
     * 	   @SWG\Response(
     *         response=412,
     *         description="Password mismatch"
     *     )
     * )
     */
    public function resetPassword(Request $request)
    {
    	$resetToken = DB::table('reset_tokens')
    					->where('id', $request->get('reset_token'))
    					->get()
    					->first();

    	if (!$resetToken) {
    		return $this->error(['error' => 'Invalid token.'], 498);
    	}

    	if ($this->currentTimeToMillis > $resetToken->expire_time) {
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
    	// Delete token after use
    	DB::table('reset_tokens')->where('id', $resetToken->id)->delete();
    }

}