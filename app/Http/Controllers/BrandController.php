<?php 

namespace App\Http\Controllers;

use App\Models\Brand;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


/**
 * @SWG\Info(title="TS", version="0.1")
 */
class BrandController extends Controller{

	public function __construct()
	{
		$this->middleware('oauth', ['except' => ['getBrands']]);
		$this->middleware('authorize:' . __CLASS__, ['except' => ['getBrands', 'getBrand']]);
		$this->middleware('authorize_role:' . __CLASS__ . ',' . config()['roleconfig']['roles']['USER_TECHNICIAN'], ['except' => ['getBrands']]);
	}

	/**
	 * @SWG\Get(
	 *     path="/brands",
	 *     @SWG\Response(response="200", description="Get all brands")
	 * )
	 */
	public function getBrands()
	{
		// $brands = Brand::all();
		$brands = Brand::paginate(5);
		return $this->success($brands, 200);
	}

	/**
	 * @SWG\Post(
	 *     path="/brands",
	 *     @SWG\Response(response="200", description="Create all brands")
	 * )
	 */
	public function createBrand(Request $request)
	{
		$this->validateRequest($request);
		$brand = Brand::create($request->all());
		return $this->success("The brand with with id {$brand->id} has been created", 201);
	}

	/**
	 * @SWG\Get(
	 *     path="/brands/{id}",
	 *     @SWG\Response(response="200", description="Get brand")
	 * )
	 */
	public function getBrand($id)
	{
		$brand = Brand::find($id);

		if(!$brand){
			return $this->error("The brand with {$id} doesn't exist", 404);
		}

		return $this->success($brand, 200);
	}

	/**
	 * @SWG\Put(
	 *     path="/brands/{id}",
	 *     @SWG\Response(response="200", description="Update brand")
	 * )
	 */
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

	/**
	 * @SWG\Delete(
	 *     path="/brands/{id}",
	 *     @SWG\Response(response="200", description="Delete brand")
	 * )
	 */
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
