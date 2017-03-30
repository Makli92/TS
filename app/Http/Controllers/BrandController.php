<?php 

namespace App\Http\Controllers;

use App\Models\Brand;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BrandController extends Controller{

	public function __construct()
	{
		$this->middleware('oauth');
		$this->middleware('authorize_role:' . __CLASS__ . ',' . config()['roleconfig']['roles']['SUPERUSER'], ['except' => ['getBrands', 'getBrand']]);
	}

	/**
     * @SWG\Get(
     *     path="/brands",
     *     description="Returns all brands",
     *     operationId="getBrands",
     *     produces={"application/json"},
     *     tags={"Brands"},
     * 	   @SWG\Parameter(
     *         name="access_token",
     *         in="query",
     *         description="User's token",
     *         required=true,
     *         type="string"
     *     ),
     * 	   @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="Pagination",
     *         required=false,
     *         type="integer",
     * 		   format="int64"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="A paged array of brands",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Brands")
     *         )
     *     )
     * )
     */
	public function getBrands()
	{
		$brands = Brand::paginate(5);
		return $this->success($brands, 200);
	}

	/**
	 * @SWG\Post(
	 *     path="/brands",
	 *     description="Creates new brand",
     *     operationId="createBrand",
     * 	   consumes={"application/json"},
     *     produces={"application/json"},
     *     tags={"Brands"},
     * 	   @SWG\Parameter(
     *         name="access_token",
     *         in="query",
     *         description="User's token",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="brand",
     *         in="body",
     *         description="Brand to add",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Brand"),
     *     ),
	 *	   @SWG\Response(
     *         response=201,
     *         description="The newly created brand",
     *         @SWG\Schema(ref="#/definitions/Brand")
     *     )
	 * )
	 */
	public function createBrand(Request $request)
	{
		$this->validateRequest($request);
		$brand = Brand::create($request->all());
		return $this->success($brand, 201);
	}

	/**
     * @SWG\Get(
     *     path="/brands/{id}",
     *     description="Returns specific brand",
     *     operationId="getBrand",
     *     produces={"application/json"},
     *     tags={"Brands"},
     * 	   @SWG\Parameter(
     *         name="access_token",
     *         in="query",
     *         description="User's token",
     *         required=true,
     *         type="string"
     *     ),
     * 	   @SWG\Parameter(
     *         description="Brand Id to fetch",
     *         format="int64",
     *         in="path",
     *         name="id",
     *         required=true,
     *         type="integer"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="The specific brand",
     *         @SWG\Schema(ref="#/definitions/Brand")
     *     )
     * )
     */
	public function getBrand($id)
	{
		$brand = Brand::find($id);

		if(!$brand){
			return $this->error($brand, 404);
		}

		return $this->success($brand, 200);
	}

	/**
	 * @SWG\Put(
	 *     path="/brands/{id}",
	 *     description="Updates brand",
     *     operationId="updateBrand",
     * 	   consumes={"application/json"},
     *     produces={"application/json"},
     *     tags={"Brands"},
     * 	   @SWG\Parameter(
     *         name="access_token",
     *         in="query",
     *         description="User's token",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="brand",
     *         in="body",
     *         description="Brand to add",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Brand"),
     *     ),
	 *	   @SWG\Response(
     *         response=200,
     *         description="The updated brand",
     *         @SWG\Schema(ref="#/definitions/Brand")
     *     )
	 * )
	 */
	public function updateBrand(Request $request, $id)
	{
		$brand = Brand::find($id);

		if(!$brand){
			return $this->error($brand, 404);
		}

		$this->validateRequest($request);

		$brand->name 		= $request->get('name');
		$brand->save();

		return $this->success($brand, 200);
	}

	/**
	 * @SWG\Delete(
	 *     path="/brands/{id}",
	 * 	   produces={"application/json"},
     *     tags={"Brands"},
     * 	   @SWG\Parameter(
     *         name="access_token",
     *         in="query",
     *         description="User's token",
     *         required=true,
     *         type="string"
     *     ),
     * 	   @SWG\Parameter(
     *         description="Brand Id to delete",
     *         format="int64",
     *         in="path",
     *         name="id",
     *         required=true,
     *         type="integer"
     *     ),
	 *	   @SWG\Response(
     *         response=204,
     *         description="The deleted brand",
     *         @SWG\Schema(ref="#/definitions/Brand")
     *     )
	 * )
	 * 
	 */
	public function deleteBrand($id)
	{
		$brand = Brand::find($id);

		if(!$brand){
			return $this->error($brand, 404);
		}

		$brand->delete();

		return $this->success("", 204);
	}

	public function validateRequest(Request $request)
	{
		$rules = [
			'name' => 'required'
		];

		$this->validate($request, $rules);
	}
}
