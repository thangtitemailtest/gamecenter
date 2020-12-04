<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\logevent;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function getSavelogevent(Request $request){
		$param = $request->all();
		$content_get = $request->getContent();
		$content_get = urldecode($content_get);

		$logevent = new logevent();
		$logevent->insertLogevent($param, $content_get);

		$status = 1;
		$result['status'] = $status;
		$result = json_encode($result);
		return $result;
    }
}
