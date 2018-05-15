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
		$this->callRemote();
		
		$data = [
			'code' => '00',
			'msg'  => 'successful',
			'result' => $info
		];
		var_dump($data);
		
		return $this->returnJson($data);
	}

	/**
	 * callRemote 测试调用链跟踪
	 * @return   [type]        [description]
	 */
	public function callRemote() {
		//这里开始创建一个span 
		$zipkin = \zipkin\ZipkinHander::getInstance();
		$begainSpanInfo = $zipkin->begainSpan();
		list($requireStartTime, $spanId) = $begainSpanInfo;

		$url = 'https://jsonplaceholder.typicode.com/posts/1';
			$context = stream_context_create([
			    'http' => [
			        'method' => 'GET',
			        'header' =>
			            'X-B3-TraceId: ' . $zipkin->getTraceId() . "\r\n" .
			            'X-B3-SpanId: ' . ((string) $spanId) . "\r\n" .
			            'X-B3-ParentSpanId: ' . $zipkin->getTraceSpanId() . "\r\n" .
			            'X-B3-Sampled: ' . $zipkin->isSampled() . "\r\n"
			    ]
			]);
		$request = file_get_contents($url, false, $context);

		// 这里结束一个span
		$zipkin->afterSpan($begainSpanInfo, ['swoolefy project jsonplaceholder API', '104.31.87.157', '80'], 'posts/1', ['name'=>'bingcool','url'=>'http://192.168.99.102']);
		return true;
	}

}