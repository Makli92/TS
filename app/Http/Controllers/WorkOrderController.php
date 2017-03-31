<?php 

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WorkOrderController extends Controller{

	public function __construct()
	{
		$this->middleware('oauth');
		$this->middleware('authorize_role:' . __CLASS__ . ',' . config()['roleconfig']['roles']['SELLER']
														. ',' . config()['roleconfig']['roles']['TECH']
														. ',' . config()['roleconfig']['roles']['MANAGER'], ['except' => ['getWorkOrdersByStoreId', 'getWorkOrder', 'deleteWorkOrder']]);
		$this->middleware('authorize_role:' . __CLASS__ . ',' . config()['roleconfig']['roles']['SUPERUSER'], ['except' => ['getWorkOrders', 'getWorkOrder', 'createWorkOrder', 'deleteWorkOrder']]);
	}

	/**
     * @SWG\Get(
     *     path="/workorders",
     *     description="Returns all work orders",
     *     operationId="getWorkOrders",
     *     produces={"application/json"},
     *     tags={"Work Orders"},
     * 	   @SWG\Parameter(
     *         name="access_token",
     *         in="query",
     *         description="User's token",
     *         required=true,
     *         type="string"
     *     ),
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
     *         description="An array of work orders",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/WorkOrders")
     *         )
     *     )
     * )
     */
	public function getWorkOrders()
	{
		$store = User::find($this->getUserId())->store()->get()->first();

		if (!$store) {
			return $this->error("Store not found for user", 404);
		}

		$workOrders = WorkOrder::where('store_id', '=', $store->id)->paginate(3);
		return $this->success($workOrders, 200);
	}

	public function getWorkOrdersByStoreId($storeId)
	{
		$workOrders = WorkOrder::where('store_id', '=', $storeId)->paginate(5);
		return $this->success($workOrders, 200);
	}

	public function getWorkOrder($storeId = null, $workOrderId)
	{
		if ($this->hasRole(config()['roleconfig']['roles']['SELLER']) ||
			$this->hasRole(config()['roleconfig']['roles']['TECH']) ||
			$this->hasRole(config()['roleconfig']['roles']['MANAGER'])) {
			$workOrder = $this->workOrder($workOrderId);

			if (User::find($this->getUserId())->store()->get()->first()->id != $workOrder->store_id) {
				return $this->error('Unauthorized', 403);
			}

			return $this->success($workOrder, 200);
		} else {
			return $this->success($this->workOrder($workOrderId), 200);
		}

		return $this->error('Unauthorized', 403);
	}

	protected function workOrder($workOrderId) {
		return WorkOrder::with('spareParts.mobilePhoneModel.brand')->find($workOrderId);
	}

	public function createWorkOrder(Request $request)
	{
		$this->validateRequest($request);

		$userId = $this->getUserId();

		$workOrder = WorkOrder::create([
					'description' => $request->get('description'),
					'notes' => $request->get('notes'),
					'client_id' => $request->get('client_id'),
					'device_id' => $request->get('device_id'),
					'store_id' => User::find($userId)->store()->get()->first()->id,
					'created_by_user_id' => $userId,
					'assigned_to_user_id' => $userId,
					'status_id' => 1
		]);

		// attach used for one insert only
		// $workOrder->spareParts()->attach(1, ['net_value' => '20.00', 'vat_value' => '4.8'], 2, ['net_value' => '20.00', 'vat_value' => '4.8'], 4, ['net_value' => '100.00', 'vat_value' => '24']);
		$workOrder->spareParts()->sync(array(1 => array('net_value' => '20.00', 'vat_value' => '4.8'), 2 => array('net_value' => '10.00', 'vat_value' => '2.4')));

		return $this->success($workOrder, 201);
	}

	// public function getWorkOrder($id)
	// {
	// 	$workOrder = WorkOrder::find($id);

	// 	if(!$workOrder){
	// 		return $this->error("The workOrder with {$id} doesn't exist", 404);
	// 	}

	// 	return $this->success($workOrder, 200);
	// }

	// public function updateWorkOrder(Request $request, $id)
	// {
	// 	$workOrder = WorkOrder::find($id);

	// 	if(!$workOrder){
	// 		return $this->error("The workOrder with {$id} doesn't exist", 404);
	// 	}

	// 	$this->validateRequest($request);

	// 	$workOrder->name 		= $request->get('name');
	// 	$workOrder->save();

	// 	return $this->success("The workOrder with with id {$workOrder->id} has been updated", 200);
	// }

	public function deleteWorkOrder($id)
	{
		$workOrder = WorkOrder::find($id);

		if(!$workOrder){
			return $this->error($worOrder, 404);
		}

		// $workOrder->delete();
		$workOrder->spareParts()->detach();

		return $this->success($workOrder, 204);
	}

	public function validateRequest(Request $request)
	{
		$rules = [
			'description' => 'required',
			'notes' => 'required',
			'client_id' => 'required',
			'device_id' => 'required'
			// ,
			// 'spare_parts' => 'array|each|exists:id'
		];

		$this->validate($request, $rules);
	}
}