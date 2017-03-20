<?php 

namespace App\Http\Controllers;

use App\Models\Work_Order_Status;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WorkOrderStatusController extends Controller{

	public function __construct(){

		$this->middleware('oauth', ['except' => ['getWorkOrderStatuses', 'getWorkOrderStatus']]);
		$this->middleware('authorize:' . __CLASS__, ['except' => ['getWorkOrderStatuses', 'getWorkOrderStatus']]);
	}

	public function getWorkOrderStatuses()
	{
		return $this->success(Work_Order_Status::all(), 200);
	}

	public function getWorkOrderStatus($id)
	{
		$workOrderStatus = Work_Order_Status::find($id);

		if (!$workOrderStatus) {
			return $this->error("The work order status with id {$id} doesn't exist", 404);
		}

		return $this->success($workOrderStatus, 200);
	}
}