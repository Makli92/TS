<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
	public function testOauth() 
	{
		$this->post('/oauth/access_token', 
					[
						'username' => 'Pavlos@tssolutions.gr',
						'password' => 'secret',
						'client_id' => 'id0',
						'client_secret' => 'secret0',
						'grant_type' => 'password'
					])
             ->seeJson([
                'token_type' => 'Bearer',
             ]);
	}

	public function testForgotPassword()
	{
		$this->post('/password/forgot', ['email' => 'giorgos@tssolutions.gr'])
			 ->seeJsonContains(['valid_reset_token' => true])
			 ->seeStatusCode(200);
	}

	public function testForgotPasswordEmailNoExists()
	{
		$this->post('/password/forgot', ['email' => 'kostahiri@gmail.com'])
			 ->seeJsonContains(['error' => 'Email does not exist.'])
        	 ->seeStatusCode(400);
	}

	public function testForgotPasswordResetTokenExists()
	{
		$this->post('/password/forgot', ['email' => 'giorgos@tssolutions.gr'])
			 ->seeJsonContains(['error' => 'reset_token_active'])
        	 ->seeStatusCode(200);
	}

	public function testResetPasswordExpiredToken() {
		$this->post('/password/reset', ['reset_token' => '720f20056e5fc2b18f193abe54403aeI', 'password_field' => '123', 'password_field_verification' => '123'])
			 ->seeJsonContains(['error' => 'Token expired.'])
        	 ->seeStatusCode(498);
	}

	public function testResetPasswordMismatch() {
		$this->post('/password/reset', ['reset_token' => '720f20056e5fc2b18f193abe54403aea', 'password_field' => '123', 'password_field_verification' => '1234'])
			 ->seeJsonContains(['error' => 'Passwords provided do not match.'])
        	 ->seeStatusCode(412);
	}

	public function testResetPasswordInvalidToken() {
		$this->post('/password/reset', ['reset_token' => '720f20056e5fc2b18f193abe54403aeaNONEXISTENT', 'password_field' => '123', 'password_field_verification' => '123'])
			 ->seeJsonContains(['error' => 'Invalid token.'])
        	 ->seeStatusCode(498);
	}

	public function testResetPassword() {
		$this->post('/password/reset', ['reset_token' => '720f20056e5fc2b18f193abe54403aea', 'password_field' => '123', 'password_field_verification' => '123'])
			 ->seeJsonContains(['data' => ''])
 			 ->seeStatusCode(200);
	}

	

	

    public function testMeUnauthenticated()
    {   
        $this->get('/me')
        	 ->seeStatusCode(400);
    }

    public function testMeAuthenticated()
    {
        $this->get('/me?access_token=CihoA0MCVVyiZEvg3vRygf8eLxRzW5g9ktSLJe7V')
             ->seeJsonContains([
                	"id" => 1,
				    "first_name" => "Παύλος",
				    "last_name" => "Ιωάννου",
				    "email" => "Pavlos@tssolutions.gr"
             ]);
    }
}