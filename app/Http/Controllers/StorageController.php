<?php 

namespace App\Http\Controllers;

use App\Models\Storage;
use App\Models\Store;
use App\Models\SparePart;

use Illuminate\Http\Request;

class StorageController extends Controller{

	public function __construct()
	{
		$this->middleware('oauth', ['except' => ['show', 'showSparePart']]);
		$this->middleware('authorize:' . __CLASS__, ['except' => ['show', 'showSparePart']]);
	}

	public function show($storeId)
	{
		$storage = Storage::where('store_id', $storeId)->get();

		if(!$storage){
			return $this->error("The store with {$storeId} doesn't exist", 404);
		}

		return $this->success($storage, 200);
	}

	public function showSparePart($storeId, $sparePartId)
	{
		$storage = Storage::where('store_id', $storeId)->where('spare_part_id', $sparePartId)->get();

		if(!$storage){
			return $this->error("The spare part with Id {$sparePartId} was not found in store with {$storeId} doesn't exist", 404);
		}

		return $this->success($storage, 200);
	}

	// public function save(Request $request)
	// {
	// 	$this->validateRequest($request);

	// 	$store = Store::create($request->toArray());

	// 	return $this->success("The store with with id {$store->id} has been created", 201);
	// }

	// public function edit(Request $request, $id)
	// {
	// 	$store = Store::find($id);

	// 	if(!$store){
	// 		return $this->error("The store with {$id} doesn't exist", 404);
	// 	}

	// 	$this->validateRequest($request);

	// 	$store->street 			= $request->get('street');
	// 	$store->street_number 	= $request->get('street_number');
	// 	$store->phone_number 	= $request->get('phone_number');
	// 	$store->zip_code 		= $request->get('zip_code');
	// 	$store->city 			= $request->get('city');
	// 	$store->country 		= $request->get('country');
	// 	$store->latitude 		= $request->get('latitude');
	// 	$store->longitude 		= $request->get('longitude');

	// 	$store->save();

	// 	return $this->success("The store with with id {$store->id} has been updated", 200);
	// }

	// public function destroy($id)
	// {

	// 	$store = Store::find($id);

	// 	if(!$store){
	// 		return $this->error("The store with {$id} doesn't exist", 404);
	// 	}

	// 	$store->delete();

	// 	return $this->success("The store with with id {$id} has been deleted along with it's comments", 200);
	// }

	public function validateRequest(Request $request)
	{
		$rules = [
			'spare_part_id' => 'required', 
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