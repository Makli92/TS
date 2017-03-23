<?php 

namespace App\Http\Controllers;

use App\Models\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{

	public function __construct() {
		// $this->middleware('oauth', ['except' => ['getWorkOrderStatuses', 'getWorkOrderStatus']]);
	}
}