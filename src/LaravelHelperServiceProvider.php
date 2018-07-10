<?php
namespace LaiheLi\LaravelHelper;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class LaravelHelperServiceProvider extends ServiceProvider
{

	public function boot()
	{
		$this->extendResponse();
	}

	public function register()
	{
	}

	/**
	 * 扩展response方法
	 */
	private function extendResponse()
	{
		Response::macro('success', function($data = [], $message = '操作成功'){
			return Response::json([
				'status'  => TRUE,
				'code'    => 200,
				'message' => $message,
				'data'    => $data,
			], 200, [], JSON_UNESCAPED_UNICODE);
		});
		Response::macro('error', function($message = '操作失败', $code = 400, $data = []){
			return Response::json([
				'status'  => FALSE,
				'code'    => $code,
				'message' => $message,
				'data'    => $data,
			], 200, [], JSON_UNESCAPED_UNICODE);
		});
	}
}