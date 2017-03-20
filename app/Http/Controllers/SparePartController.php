<?php 

namespace App\Http\Controllers;

// use App\Models\Brand;
use App\Models\Mobile_Phone_Model;
use App\Models\Spare_Part;

use Illuminate\Http\Request;

class SparePartController extends Controller{

	public function __construct()
	{	
		$this->middleware('oauth', ['except' => ['getSpareParts', 'getSparePartsByMobilePhoneModelId', 'getSparePart']]);
		$this->middleware('authorize:' . __CLASS__, ['except' => ['getSpareParts', 'getSparePartsByMobilePhoneModelId', 'getSparePart']]);
	}

	public function getSpareParts()
	{
		$spareParts = Spare_Part::all();
		return $this->success($spareParts, 200);
	}

	public function getSparePartsByMobilePhoneModelId($mobilePhoneModelId)
	{
		$mobilePhoneModel = Mobile_Phone_Model::find($mobilePhoneModelId);

		if(!$mobilePhoneModel){
			return $this->error("The mobile phone model with id {$mobilePhoneModelId} doesn't exist", 404);
		}

		return $this->success($mobilePhoneModel->with('spareParts')->get(), 200);
	}

	public function getSparePart($id)
	{
		$sparePart = Spare_Part::find($id);

		if(!$sparePart){
			return $this->error("The spare part with id {$id} doesn't exist", 404);
		}

		return $this->success($sparePart, 200);
	}
}