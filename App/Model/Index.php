<?php
namespace App\Model;

use Swoolefy\Core\ZModel;
use Swoolefy\Core\Model\BModel;

class Index extends BModel {
	// 测试
	public function getFrameInfo() {
		return ['frame'=>'swoolefy','version'=>'1.9.23','desc'=>'swoolefy是一个基于swoole扩展实现的高性能服务框架'];
	}
}