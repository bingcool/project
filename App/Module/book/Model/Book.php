<?php
namespace App\Module\book\Model;

use Swoolefy\Core\Model\BModel;

class Book extends BModel {

	public function getBookInfo() {
		$name = $_GET['name'];
		return ['name'=>'swoolefy'.rand(1,100).'-'.$name];
	}
}