<?php
return [
	// 由于不是http应用，不需要设置view,session组件
	'components' => [
		// 
		'log' => [
			'class' => 'Swoolefy\Tool\Log',
		],
	],
];