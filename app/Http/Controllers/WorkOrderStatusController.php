<?php 

namespace App\Http\Controllers;

use App\Models\WorkOrderStatus;

use Illuminate\Http\Request;

class WorkOrderStatusController extends Controller{

	public function __construct()
	{
		$this->middleware('oauth', ['except' => ['index', 'show']]);
		$this->middleware('authorize:' . __CLASS__, ['except' => ['index', 'show']]);
	}

	public function index()
	{
		return $this->success(WorkOrderStatus::all(), 200);
	}

	public function show($id)
	{
		$workOrderStatus = WorkOrderStatus::where('id', $id)->get();

		if(!$workOrderStatus){
			return $this->error("The work order status with {$id} doesn't exist", 404);
		}

		return $this->success($workOrderStatus, 200);
	}
} 