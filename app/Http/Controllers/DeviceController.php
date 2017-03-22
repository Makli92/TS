<?php 

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Mobile_Phone_Model;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DeviceController extends Controller{

	public function __construct()
	{
		$this->middleware('oauth');
		$this->middleware('authorize_role:' . __CLASS__ . ',' . config()['roleconfig']['roles']['USER_ADMIN']
														. ',' . config()['roleconfig']['roles']['USER_TECHNICIAN']
														. ',' . config()['roleconfig']['roles']['USER_SELLER']
		);
	}

	public function getDevices()
	{
		$devices = Device::with('mobilePhoneModel.brand')->paginate(5);
		return $this->success($devices, 200);
	}

	public function createDevice(Request $request)
	{
		$this->validateRequest($request);
		$device = Device::create($request->all());
		return $this->success("The device with with id {$device->id} has been created", 201);
	}

	public function getDevice($id)
	{
		$device = Device::with('mobilePhoneModel.brand')->find($id);

		if(!$device){
			return $this->error("The device with {$id} doesn't exist", 404);
		}

		return $this->success($device, 200);
	}

	public function updateDevice(Request $request, $id)
	{
		$device = Device::find($id);

		if(!$device){
			return $this->error("The device with {$id} doesn't exist", 404);
		}

		$this->validateRequest($request);

		$device->name 		= $request->get('name');
		$device->save();

		return $this->success("The device with with id {$device->id} has been updated", 200);
	}

	public function deleteDevice($id)
	{
		$device = Device::find($id);

		if(!$device){
			return $this->error("The device with {$id} doesn't exist", 404);
		}

		$device->delete();

		return $this->success("The device with with id {$id} has been deleted", 200);
	}

	public function validateRequest(Request $request)
	{
		$rules = [
			'imei' => 'required',
			'mobile_phone_model_id' => 'required'
		];

		$this->validate($request, $rules);
	}
}