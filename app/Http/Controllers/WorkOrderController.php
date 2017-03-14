<?php 

namespace App\Http\Controllers;

use App\Models\WorkOrder;

use Illuminate\Http\Request;

class WorkOrderController extends Controller{

	public function __construct()
	{
		$this->middleware('oauth', ['except' => ['index', 'show']]);
		$this->middleware('authorize:' . __CLASS__, ['except' => ['index', 'show']]);
	}

	public function index()
	{
		return $this->success(WorkOrder::all(), 200);
	}

	public function show($id)
	{
		$workOrder = WorkOrder::find($id);

		if(!$workOrder){
			return $this->error("The work order with {$id} doesn't exist", 404);
		}

		$spareParts = $workOrder->spareParts();

		return $this->success($spareParts, 200);
	}
} 