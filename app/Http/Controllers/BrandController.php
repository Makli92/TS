<?php 

namespace App\Http\Controllers;

use App\Models\Brand;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BrandController extends Controller{

	public function __construct()
	{
		$this->middleware('oauth', ['except' => ['getBrands'/*, 'getBrand'*/]]);
		$this->middleware('authorize:' . __CLASS__, ['except' => ['getBrands', 'getBrand']]);
		$this->middleware('authorize_role:' . __CLASS__ . ',' . 2);
	}

	public function getBrands()
	{
		$brands = Brand::all();
		return $this->success($brands, 200);
	}

	public function createBrand(Request $request)
	{
		$this->validateRequest($request);
		$brand = Brand::create($request->all());
		return $this->success("The brand with with id {$brand->id} has been created", 201);
	}

	public function getBrand($id)
	{
		$brand = Brand::find($id);

		if(!$brand){
			return $this->error("The brand with {$id} doesn't exist", 404);
		}

		return $this->success($brand, 200);
	}

	public function updateBrand(Request $request, $id)
	{
		$brand = Brand::find($id);

		if(!$brand){
			return $this->error("The brand with {$id} doesn't exist", 404);
		}

		$this->validateRequest($request);

		$brand->name 		= $request->get('name');
		$brand->save();

		return $this->success("The brand with with id {$brand->id} has been updated", 200);
	}

	public function deleteBrand($id)
	{
		$brand = Brand::find($id);

		if(!$brand){
			return $this->error("The brand with {$id} doesn't exist", 404);
		}

		$brand->delete();

		return $this->success("The brand with with id {$id} has been deleted", 200);
	}

	public function validateRequest(Request $request)
	{
		$rules = [
			'name' => 'required'
		];

		$this->validate($request, $rules);
	}
}