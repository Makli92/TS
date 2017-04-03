<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    public function testMe()
    {   
        $response = $this->call('GET', '/me');
        // $this->assertResponseOk();
        $this->assertEquals(400, $response->status());
    }

    public function testMe200Response()
    {
        $this->json('GET', '/me?access_token=cKO90FzuFY0YS9qKU77n7ul9xRFqxwTT2fUaGiio')
             ->seeJsonEquals([
                'data' => [
                	"id" => 1,
				    "first_name" => "Παύλος",
				    "last_name" => "Ιωάννου",
				    "email" => "Pavlos@tssolutions.gr"
                ]
             ]);
    }
}