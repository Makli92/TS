<?php 

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\MobilePhoneModel;

use Illuminate\Http\Request;

class MobilePhoneModelController extends Controller{

	public function __construct(){
		
		$this->middleware('oauth', ['except' => ['index', 'show']]);
		$this->middleware('authorize:' . __CLASS__, ['except' => ['index', 'show', 'save', 'edit', 'destroy']]);
	}

	public function index($brandId)
	{

		$brand = Brand::find($brandId);

		if(!$brand){
			return $this->error("The brand with {$brandId} doesn't exist", 404);
		}

		$mobilePhoneModels = $brand->mobilePhoneModels;
		return $this->success($mobilePhoneModels, 200);
	}

	public function show($brandId, $mobilePhoneModelId)
	{
		$mobilePhoneModel = MobilePhoneModel::where('brand_id', $brandId)->where('id', $mobilePhoneModelId)->get();

		if($mobilePhoneModel->isEmpty()){
			return $this->error("The mobile phone model with brand {$brandId} and mobile phone model {$mobilePhoneModelId} doesn't exist", 404);
		}

		return $this->success($mobilePhoneModel, 200);
	}

	public function save(Request $request, $brandId)
	{
		
		$brand = Brand::find($brandId);

		if(!$brand){
			return $this->error("The brand with {$brandId} doesn't exist", 404);
		}

		$this->validateRequest($request);

		$mobilePhoneModel = MobilePhoneModel::create([
				'name' => $request->get('name'),
				'brand_id'=> $brandId
			]);

		return $this->success("The mobile phone model with id {$mobilePhoneModel->id} has been created and assigned to the brand with id {$brandId}", 201);
	}

	public function edit(Request $request, $brandId, $mobilePhoneModelId)
	{

		$mobilePhoneModel = MobilePhoneModel::where('brand_id', $brandId)->where('id', $mobilePhoneModelId)->get()->first();

		if(!$mobilePhoneModel){
			return $this->error("The mobile phone model with {$mobilePhoneModelId} and brand with id {$brandId} doesn't exist", 404);
		}

		$additionalFields = [
			'brand_id' => 'required'
		];

		$this->validate($request, $additionalFields);

		$brand = Brand::find($request->get('brand_id'));

		if(!$brand){
			return $this->error("The brand with {$request->get('brand_id')} doesn't exist", 404);
		}

		$mobilePhoneModel->name 		= $request->get('name');
		$mobilePhoneModel->brand_id		= $request->get('brand_id');

		$mobilePhoneModel->save();

		return $this->success("The mobile phone model with with id {$mobilePhoneModelId} has been updated", 200);
	}

	public function destroy($brandId, $mobilePhoneModelId)
	{
		$brand = Brand::find($brandId);

		if(!$brand){
			return $this->error("The brand with id {$brandId} doesn't exist", 404);
		}

		$mobilePhoneModel = $brand->mobilePhoneModels()->find($mobilePhoneModelId);

		if(!$brand->mobilePhoneModels()->find($mobilePhoneModelId)){
			return $this->error("The mobile phone model with id {$mobilePhoneModelId} isn't assigned to the brand with id {$brandId}", 409);
		}

		$mobilePhoneModel->delete();

		return $this->success("The mobile phone model with id {$mobilePhoneModelId} has been removed of the brand {$brandId}", 200);
	}

	public function validateRequest(Request $request, $additionalFields = null)
	{
		$rules = [
			'name' => 'required'
		];

		if (!empty($additionalFields)) {
			$rules = array_merge($rules, $additionalFields);
		}

		$this->validate($request, $rules);
	}
}