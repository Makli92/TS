<?php 

namespace App\Http\Controllers;

use App\Models\Store;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StoreController extends Controller{

	public function __construct()
	{
		$this->middleware('oauth', ['except' => ['getStores']]);
		// $this->middleware('authorize_role:' . __CLASS__ . ',' . config()['roleconfig']['roles']['SUPERUSER']
		// 												. ',' . config()['roleconfig']['roles']['MANAGER']
		// 												. ',' . config()['roleconfig']['roles']['TECH']
		// 												. ',' . config()['roleconfig']['roles']['SELLER'], 
		// 												['except' => ['createStore', 'updateStore', 'deleteStore', 'getStaff']]
		// );
		// $this->middleware('authorize_role:' . __CLASS__ . ',' . config()['roleconfig']['roles']['SUPERUSER'], 
		// 												['except' => ['getStores', 'getStore']]
		// );
	}

	/**
     * @SWG\Get(
     *     path="/stores",
     *     description="Returns all stores",
     *     operationId="getStores",
     *     produces={"application/json"},
     *     tags={"Stores"},
     * 	   @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="Pagination",
     *         required=false,
     *         type="integer",
     * 		   format="int64"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="A paged array of stores",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Stores")
     *         )
     *     )
     * )
     */
	public function getStores()
	{
		$stores = Store::paginate(2);
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

		$store->name 		= $request->get('name');
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

	public function getStaff($id)
	{
		$staff = Store::find($id)->staff()->get();
		return $this->success($staff, 200);
	}

	public function validateRequest(Request $request)
	{
		$rules = [
			'name' => 'required',
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