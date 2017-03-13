<?php 

namespace App\Http\Controllers;

use App\Models\Brand;

use Illuminate\Http\Request;

class BrandController extends Controller{

	public function __construct()
	{
		$this->middleware('oauth', ['except' => ['index', 'show']]);
		$this->middleware('authorize:' . __CLASS__, ['except' => ['index', 'show', 'save', 'edit']]);
	}

	public function index()
	{
		$brands = Brand::all();
		return $this->success($brands, 200);
	}

	public function show($id)
	{
		$brand = Brand::find($id);

		if(!$brand){
			return $this->error("The brand with {$id} doesn't exist", 404);
		}

		return $this->success($brand, 200);
	}

	public function save(Request $request)
	{
		$this->validateRequest($request);

		$brand = Brand::create($request->toArray());

		return $this->success("The brand with with id {$brand->id} has been created", 201);
	}

	public function edit(Request $request, $id)
	{
		$brand = Brand::find($id);

		if(!$brand){
			return $this->error("The brand with {$id} doesn't exist", 404);
		}

		$this->validateRequest($request);

		$brand->name 			= $request->get('name');

		$brand->save();

		return $this->success("The brand with with id {$brand->id} has been updated", 200);
	}

	public function destroy($id)
	{

		$brand = Brand::find($id);

		if(!$brand){
			return $this->error("The brand with {$id} doesn't exist", 404);
		}

		$brand->delete();

		return $this->success("The brand with with id {$id} has been deleted along with it's comments", 200);
	}

	public function validateRequest(Request $request)
	{
		$rules = [
			'name' => 'required'
		];

		$this->validate($request, $rules);
	}
}