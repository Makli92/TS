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

	/*public function testForgotPasswordEmailExists()
	{
		$this->post('/password/forgot', ['email' => 'giorgos@tssolutions.gr'])
			 ->seeJsonContains(['sent' => true])
			 ->seeStatusCode(200);
	}*/

	public function testForgotPasswordEmailNoExists()
	{
		$this->post('/password/forgot', ['email' => 'kostahiri@gmail.com'])
			 ->seeJsonContains(['sent' => false, 'error' => 'email'])
        	 ->seeStatusCode(400);
	}

	public function testForgotPasswordResetTokenExists()
	{
		$this->post('/password/forgot', ['email' => 'giorgos@tssolutions.gr'])
			 ->seeJsonContains(['sent' => false, 'error' => 'reset_token'])
        	 ->seeStatusCode(400);
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