<?php 

namespace App\Http\Controllers;

use App\Models\Store;

use Illuminate\Http\Request;

class StoreController extends Controller{

	public function __construct()
	{
		$this->middleware('oauth', ['except' => ['index', 'show']]);
		$this->middleware('authorize:' . __CLASS__, ['except' => ['index', 'show', 'save']]);
	}

	public function index()
	{
		$stores = Store::all();
		return $this->success($stores, 200);
	}

	public function show($id)
	{
		$store = Store::find($id);

		if(!$store){
			return $this->error("The store with {$id} doesn't exist", 404);
		}

		return $this->success($store, 200);
	}

	public function save(Request $request)
	{
		$this->validateRequest($request);

		$store = Store::create($request->toArray());

		return $this->success("The store with with id {$store->id} has been created", 201);
	}

	public function edit(Request $request, $id)
	{
		$store = Store::find($id);

		if(!$store){
			return $this->error("The store with {$id} doesn't exist", 404);
		}

		$this->validateRequest($request);

		$store->street 			= $request->get('street');
		$store->street_number 	= $request->get('street_number');
		$store->phone_number 	= $request->get('phone_number');
		$store->zip_code 		= $request->get('zip_code');
		$store->city 			= $request->get('city');
		$store->country 		= $request->get('country');
		$store->latitude 		= $request->get('latitude');
		$store->longitude 		= $request->get('longitude');

		$store->save();

		return $this->success("The store with with id {$store->id} has been updated", 200);
	}

	public function destroy($id)
	{

		$store = Store::find($id);

		if(!$store){
			return $this->error("The store with {$id} doesn't exist", 404);
		}

		$store->delete();

		return $this->success("The store with with id {$id} has been deleted along with it's comments", 200);
	}

	public function validateRequest(Request $request)
	{
		$rules = [
			'street' => 'required', 
			'street_number' => 'required',
			'phone_number' => 'required', 
			'zip_code' => 'required',
			'city' => 'required', 
			'country' => 'required',
			'latitude' => 'required', 
			'longitude' => 'required'
		];

		$this->validate($request, $rules);
	}
}