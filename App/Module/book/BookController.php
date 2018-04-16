<?php
namespace App\Module\book;

use Swoolefy\Core\ZModel;
use Swoolefy\Core\Controller\BController;

class BookController extends BController {

	public function test() {
		// $Test = ZModel::getInstance('App\Model\Test');
		$Test = $this->getModel();
		$data = $Test->getBookInfo();
		// $this->returnJson($data);
		$this->assign('name',$data['name']);
		$this->display('test.html');
	}

	// 
	public function hotBook() {
		// 第一种方式获取HotBook实例对象,getModel获取本模块的实例
		$mod_hotBook = $this->getModel('HotBook');
		// 第二种方式获取HotBook实例对象，直接完全命名空间方式获取单例
		// $mod_hotBook = ZModel::getInstance('App\Module\book\Model\HotBook');
	}

	// 测试，跨模块调用model
	public function getUsersBooks() {
		// 调用user模块下的User模型
		$mod_user = $this->getModel('User','user');
		// 当然也可以完全命名空间创建单例调用
		// $mod_user = ZModel::getInstance('App\Module\user\Model\User');
	}
}