<?php 

namespace App\Http\Controllers;

use App\Models\Store;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StoreController extends Controller{

	public function __construct()
	{
		$this->middleware('oauth');
		$this->middleware('authorize_role:' . __CLASS__ . ',' . config()['roleconfig']['roles']['USER_ADMIN']
														. ',' . config()['roleconfig']['roles']['USER_TECHNICIAN']
														. ',' . config()['roleconfig']['roles']['USER_SELLER'], 
														['except' => ['createStore', 'updateStore', 'deleteStore']]
		);
		$this->middleware('authorize_role:' . __CLASS__ . ',' . config()['roleconfig']['roles']['USER_ADMIN'], 
														['except' => ['getStores', 'getStore']]
		);
	}

	public function getStores()
	{
		$stores = Store::paginate(5);
		return $this->success($stores, 200);
	}

	public function createStore(Request $request)
	{
		$this->validateRequest($request);
		$store = Store::create($request->all());
		return $this->success("The store with with id {$store->id} has been created", 201);
	}

	public function getStore($id)
	{
		$store = Store::find($id);

		if (!$store) {
			return $this->error("The store with {$id} doesn't exist", 404);
		}

		return $this->success($store, 200);
	}

	public function updateStore(Request $request, $id)
	{
		$store = Store::find($id);

		if(!$store){
			return $this->error("The store with {$id} doesn't exist", 404);
		}

		$this->validateRequest($request);

		$store->street 		= $request->get('street');
		$store->street_number 		= $request->get('street_number');
		$store->phone_number 		= $request->get('phone_number');
		$store->post_code 		= $request->get('post_code');
		$store->city 		= $request->get('city');
		$store->country 		= $request->get('country');
		$store->latitude 		= $request->get('latitude');
		$store->longitude 		= $request->get('latitude');

		$store->save();

		return $this->success("The store with with id {$store->id} has been updated", 200);
	}

	public function deleteStore($id)
	{
		$store = Store::find($id);

		if(!$store){
			return $this->error("The store with {$id} doesn't exist", 404);
		}

		$store->delete();

		return $this->success("The store with with id {$id} has been deleted", 200);
	}

	public function validateRequest(Request $request)
	{
		$rules = [
			'street' => 'required',
			'street_number' => 'required',
			'phone_number' => 'required',
			'post_code' => 'required',
			'city' => 'required',
			'country' => 'required',
			'latitude' => 'required',
			'longitude' => 'required'
		];

		$this->validate($request, $rules);
	}
}