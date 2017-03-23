<?php 

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{

	public function __construct() 
	{
		$this->middleware('oauth');
		$this->middleware('authorize_role:' . __CLASS__ . ',' . config()['roleconfig']['roles']['USER_ADMIN'], ['except' => ['getClients', 'getClient']]);
		$this->middleware('authorize_role:' . __CLASS__ . ',' . config()['roleconfig']['roles']['USER_STORE_MANAGER']
													 	. ',' . config()['roleconfig']['roles']['USER_TECHNICIAN']
													 	. ',' . config()['roleconfig']['roles']['USER_SELLER']
													 	, ['except' => ['getClientsAdmin', 'getClientsAdminByStore']]
	 	);
	}

	public function getClientsAdmin()
	{
		$clients = Client::with('store')->paginate(10);
		return $this->success($clients, 200);
	}

	public function getClientsAdminByStore($storeId)
	{
		$clients = Client::where('store_id', '=', $storeId)->select('id', 'first_name', 'last_name', 'mobile_number', 'phone_number', 'email')->get();
		return $this->success($clients, 200);
	}

	public function getClients()
	{
		$storeId = User::find($this->getUserId())->store->first()->id;
		$clients = Client::where('store_id', '=', $storeId)->select('id', 'first_name', 'last_name', 'mobile_number', 'phone_number', 'email')->get();
		return $this->success($clients, 200);
	}

	public function getClient($id)
	{
		return $this->success(Client::with('devices.mobilePhoneModel.brand', 'store')->find($id), 200);
	}

	public function createClient()
	{
	}

	public function updateClient()
	{
	}

	public function deleteClient()
	{
	}

	public function validateRequest(Request $request)
	{
		$rules = [
			'email' => 'required|email|unique:users', 
			'password' => 'required|min:6'
		];

		$this->validate($request, $rules);
	}
}