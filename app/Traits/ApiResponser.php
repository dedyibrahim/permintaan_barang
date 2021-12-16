<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponser{

    protected function successResponse($data, $message = null, $code = 200)
	{
        $data2  = mb_convert_encoding($data, 'UTF-8', 'auto');
		return response()->json([
			'status'=> TRUE,
			'message' => $message,
			'data' => $data2
		], $code);
	}

	protected function errorResponse($data,$message, $code)
	{
		return response()->json([
			'status'=>FALSE,
			'message' => $message,
			'data' => $data
		], $code);
	}

}
