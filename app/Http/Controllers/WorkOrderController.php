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
														. ',' . config()['roleconfig']['roles']['MANAGER'], ['except' => ['getWorkOrdersByStoreId', 'getWorkOrder']]);
		$this->middleware('authorize_role:' . __CLASS__ . ',' . config()['roleconfig']['roles']['SUPERUSER'], ['except' => ['getWorkOrders', 'getWorkOrder', 'createWorkOrder']]);
	}

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

		$workOrder = WorkOrder::create([
					'description' => $request->get('description'),
					'notes' => $request->get('notes'),
					'client_id' => $request->get('client_id'),
					'device_id' => $request->get('device_id'),
					'store_id' => User::find($this->getUserId())->store()->get()->first()->id,
					'assigned_to' => $this->getUserId()
		]);

		return $this->success("The work order with with id {$workOrder->id} has been created", 201);
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

	// public function deleteWorkOrder($id)
	// {
	// 	$workOrder = WorkOrder::find($id);

	// 	if(!$workOrder){
	// 		return $this->error("The workOrder with {$id} doesn't exist", 404);
	// 	}

	// 	$workOrder->delete();

	// 	return $this->success("The workOrder with with id {$id} has been deleted", 200);
	// }

	public function validateRequest(Request $request)
	{
		$rules = [
			'description' => 'required',
			'notes' => 'required',
			'client_id' => 'required',
			'device_id' => 'required',
			'spare_parts' => 'array|each|exists:id'
		];

		$this->validate($request, $rules);
	}
}