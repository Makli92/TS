<?php 

namespace App\Http\Controllers;

use App\Models\VAT;

use Illuminate\Http\Request;

class VATController extends Controller
{

	public function __construct() 
	{
		$this->middleware('oauth', ['except' => ['getVATs', 'getVAT']]);
		$this->middleware('authorize_role:' . __CLASS__ . ',' . config()['roleconfig']['roles']['USER_ADMIN'], ['except' => ['getVATs', 'getVAT']]);
	}

	public function getVATs()
	{
		$vats = VAT::all();
		return $this->success($vats, 200);
	}

	public function createVAT(Request $request)
	{
		$this->validateRequest($request);
		$vat = VAT::create($request->all());
		return $this->success("The VAT with with id {$vat->id} has been created", 201);
	}

	public function getVAT($id)
	{
		$vat = VAT::find($id);

		if (!$vat) {
			return $this->error("The vat with {$id} doesn't exist", 404);
		}

		return $this->success($vat, 200);
	}

	public function updateVAT(Request $request, $id)
	{
		$vat = VAT::find($id);

		if (!$vat) {
			return $this->error("The vat with {$id} doesn't exist", 404);
		}

		$this->validateRequest($request);

		$vat->description 		= $request->get('description');
		$vat->value 		= $request->get('value');
		$vat->save();

		return $this->success("The vat with with id {$vat->id} has been updated", 200);
	}

	public function deleteVAT($id)
	{
		$vat = VAT::find($id);

		if (!$vat) {
			return $this->error("The vat with {$id} doesn't exist", 404);
		}

		$vat->delete();

		return $this->success("The vat with with id {$id} has been deleted", 200);
	}

	public function validateRequest(Request $request)
	{
		$rules = [
			'description' => 'required',
			'value' => 'required'
		];

		$this->validate($request, $rules);
	}
}