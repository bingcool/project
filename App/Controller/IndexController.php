<?php
namespace App\Controller;

use Swoolefy\Core\Application;
use Swoolefy\Core\Controller\BController;

class IndexController extends BController {

	// 渲染模板返回
	public function index() {
		$this->assign('name', 'hello word!');
		$this->display('index.html');
	}

	// 返回json
	public function testJson() {
		$model = $this->getModel();
		$info = $model->getFrameInfo();

		$data = [
			'code' => '00',
			'msg'  => 'successful',
			'result' => $info
		];
		$this->returnJson($data);
	}

}