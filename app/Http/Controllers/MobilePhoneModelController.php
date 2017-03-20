<?php 

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Mobile_Phone_Model;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MobilePhoneModelController extends Controller{

	public function __construct()
	{
		$this->middleware('oauth', ['except' => ['getMobilePhoneModels', 'getMobilePhoneModelsByBrandId', 'createMobilePhoneModel', 'getMobilePhoneModel']]);
		$this->middleware('authorize:' . __CLASS__, ['except' => ['getMobilePhoneModels', 'getMobilePhoneModelsByBrandId', 'createMobilePhoneModel', 'getMobilePhoneModel']]);
	}

	public function getMobilePhoneModels()
	{
		$mobilePhoneModels = Mobile_Phone_Model::all();
		return $this->success($mobilePhoneModels, 200);
	}

	public function getMobilePhoneModelsByBrandId($brandId)
	{
		$mobilePhoneModels = Brand::find($brandId)->mobilePhoneModels()->get();
		return $this->success($mobilePhoneModels, 200);
	}

	public function createMobilePhoneModel($brandId, Request $request)
	{
		$brand = Brand::find($brandId);

		if(!$brand){
			return $this->error("The brand with {$brandId} doesn't exist", 404);
		}

		$this->validateRequest($request);

		$mobilePhoneModel = Mobile_Phone_Model::create([
				'name' => $request->get('name'),
				'brand_id'=> $brandId
			]);

		return $this->success("The mobile phone model with id {$mobilePhoneModel->id} has been created and assigned to the brand with id {$brandId}", 201);
	}

	public function getMobilePhoneModel($brandId, $mobilePhoneModelId)
	{
		$brand = Brand::find($brandId);

		if(!$brand){
			return $this->error("The brand with {$brandId} doesn't exist", 404);
		}

		$mobilePhoneModel = $brand->mobilePhoneModels()->get()->find($mobilePhoneModelId);

		if(!$mobilePhoneModel){
			return $this->error("The mobile phone model with id {mobilePhoneModelId} assigned to brand with {$brandId} doesn't exist", 404);
		}

		return $this->success($mobilePhoneModel, 200);
	}

	// public function updateBrand(Request $request, $id)
	// {
	// 	$brand = Brand::find($id);

	// 	if(!$brand){
	// 		return $this->error("The brand with {$id} doesn't exist", 404);
	// 	}

	// 	$this->validateRequest($request);

	// 	$brand->name 		= $request->get('name');
	// 	$brand->save();

	// 	return $this->success("The brand with with id {$brand->id} has been updated", 200);
	// }

	// public function deleteBrand($id)
	// {
	// 	$brand = Brand::find($id);

	// 	if(!$brand){
	// 		return $this->error("The brand with {$id} doesn't exist", 404);
	// 	}

	// 	$brand->delete();

	// 	return $this->success("The brand with with id {$id} has been deleted", 200);
	// }

	public function validateRequest(Request $request)
	{
		$rules = [
			'name' => 'required'
		];

		$this->validate($request, $rules);
	}
}