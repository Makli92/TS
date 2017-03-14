<?php 

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\MobilePhoneModel;
use App\Models\SparePart;

use Illuminate\Http\Request;

class SparePartController extends Controller{

	public function __construct()
	{	
		$this->middleware('oauth', ['except' => ['index', 'show']]);
		$this->middleware('authorize:' . __CLASS__, ['except' => ['index', 'show', 'save', 'edit', 'destroy']]);
	}

	public function index($brandId, $mobilePhoneModelId)
	{
		$brand = Brand::find($brandId);

		if(!$brand){
			return $this->error("The brand with Id {$brandId} doesn't exist", 404);
		}

		$mobilePhoneModel = $brand->mobilePhoneModels()->find($mobilePhoneModelId);

		if(!$mobilePhoneModel){
			return $this->error("The mobile phone model with Id {$mobilePhoneModelId} doesn't exist", 404);
		}

		$spareParts = SparePart::where('mobile_phone_model_id', $mobilePhoneModelId)->get();

		return $this->success($spareParts, 200);
	}

	public function show($brandId, $mobilePhoneModelId, $sparePartId)
	{
		$brand = Brand::find($brandId);

		if(!$brand){
			return $this->error("The brand with Id {$brandId} doesn't exist", 404);
		}

		$mobilePhoneModel = $brand->mobilePhoneModels()->find($mobilePhoneModelId);

		if(!$mobilePhoneModel){
			return $this->error("The mobile phone model with Id {$mobilePhoneModelId} doesn't exist", 404);
		}

		$sparePart = SparePart::find($sparePartId);

		if(!$sparePart){
			return $this->error("The spare part with Id {$sparePartId} doesn't exist", 404);
		}

		return $this->success($sparePart, 200);
	}

	public function save(Request $request, $brandId, $mobilePhoneModelId)
	{
		$brand = Brand::find($brandId);

		if(!$brand){
			return $this->error("The brand with {$brandId} doesn't exist", 404);
		}

		$mobilePhoneModel = $brand->mobilePhoneModels()->find($mobilePhoneModelId);

		if(!$mobilePhoneModel){
			return $this->error("The mobile phone model with {$mobilePhoneModelId} doesn't exist", 404);
		}

		$this->validateRequest($request);

		$sparePart = SparePart::create([
				'intrastat_code' => $request->get('intrastat_code'),
				'price' => $request->get('price'),
				'min_vol' => $request->get('min_vol'),
				'description' => $request->get('descr'),
				'mobile_phone_model_id'=> $mobilePhoneModelId
			]);

		return $this->success("The spare part with id {$sparePart->id} has been created and assigned to the mobile phone model with id {$mobilePhoneModelId}", 201);
	}

	public function edit(Request $request, $brandId, $mobilePhoneModelId, $sparePartId)
	{
		$brand = Brand::find($brandId);

		if(!$brand){
			return $this->error("The brand with {$brandId} doesn't exist", 404);
		}

		$mobilePhoneModel = $brand->mobilePhoneModels()->find($mobilePhoneModelId);

		if(!$mobilePhoneModel){
			return $this->error("The mobile phone model with {$mobilePhoneModelId} doesn't exist", 404);
		}

		$additionalFields = [
			'mobile_phone_model_id' => 'required'
		];

		$this->validateRequest($request, $additionalFields);

		$sparePart = SparePart::find($sparePartId);
		$sparePart->intrastat_code	= $request->get('intrastat_code');
		$sparePart->price	= $request->get('price');
		$sparePart->min_vol	= $request->get('min_vol');
		$sparePart->description	= $request->get('description');
		$sparePart->mobile_phone_model_id	= $mobilePhoneModelId;

		$sparePart->save();

		return $this->success("The spare part with with id {$sparePartId} has been updated", 200);
	}

	public function destroy($brandId, $mobilePhoneModelId, $sparePartId)
	{
		$brand = Brand::find($brandId);

		if(!$brand){
			return $this->error("The brand with id {$brandId} doesn't exist", 404);
		}

		$mobilePhoneModel = $brand->mobilePhoneModels()->find($mobilePhoneModelId);

		if(!$mobilePhoneModel){
			return $this->error("The mobile phone model with id {$mobilePhoneModelId} isn't assigned to the brand with id {$brandId}", 409);
		}

		$sparePart = SparePart::find($sparePartId);
		$sparePart->delete();

		return $this->success("The spare part with id {$sparePartId} has been removed of the mobile phone model {$mobilePhoneModelId}", 200);
	}

	public function validateRequest(Request $request, $additionalFields = null)
	{
		$rules = [
			'intrastat_code' => 'required',
			'price' => 'required',
			'min_vol' => 'required',
			'description' => 'required'
		];

		if (!empty($additionalFields)) {
			$rules = array_merge($rules, $additionalFields);
		}

		$this->validate($request, $rules);
	}
}