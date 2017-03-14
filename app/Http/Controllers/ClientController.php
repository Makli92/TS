<?php 

namespace App\Http\Controllers;

use App\Models\Client;

use Illuminate\Http\Request;

class ClientController extends Controller{

	public function __construct()
	{
		$this->middleware('oauth', ['except' => ['index', 'show']]);
		$this->middleware('authorize:' . __CLASS__, ['except' => ['index', 'show']]);
	}

	public function index()
	{
		return $this->success(Client::all(), 200);
	}

	public function show($id)
	{
		$client = Client::where('id', $id)->get();

		if(!$client){
			return $this->error("The client with {$id} doesn't exist", 404);
		}

		return $this->success($client, 200);
	}
} 