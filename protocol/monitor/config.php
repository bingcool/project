<?php 

return [
	// 监听到文件变动后，几秒后重启，默认3s,不宜设置过短，也不宜设置过长
	'afterNSeconds' => 3,
	// 如果线上服务，请设置true,那么当检测到swoole服务停止时，他会自动触发右键通知开发运维人员
	'isOnline' => false,
	// 监听服务的端口，根据实际情况设置
	'monitorPort' => 9502,
	// 监听的代码目录，根据实际情况设置
	'monitorPath' => '/home/www/swoolefy',
	// 监听对那种那种文件类型有效
	'reloadFileTypes' => ['.php','.html','.js'],
	// 邮件服务器
	'smtpTransport' => [
		"server_host"=>"smtp.163.com",
		"port"      =>25,
		"security"  =>null,
		"user_name" =>"xxxxxxxx@163.com",
		"pass_word" =>"XXXXXX"
	],
	// 邮件主题
	'message' => [
		//邮箱主题
		"subject"=>"test",
		//发送者邮箱与定义的名称，邮箱与上面定义的user_name这里必须一致
		"from"   =>["xxxxxxxxxx@163.com"=>"bingcool"],
		//定义多个收件人和对应的名称
		"to"     =>['2437667702@qq.com'=>"bingcool"],
		//定义邮件的内容，格式可以包含html
		"body"   =>"<p>this is a mail</p>",
		// body文档类型
		"mime"   =>"text/html",
		//定义要上传的附件，可以多个，附件的大小，由代理的邮件服务器定义提供,key值代表是文件路径，name值代表是发送后的文件显示的别名，如果没设置name值，则以原文件名作为别名
		// 	"attach" =>["/home/wwwroot/default/swoolefy/score/Test/test.docx"=>"my.docx","/home/wwwroot/default/swoolefy/score/Test/test.log","/home/wwwroot/default/swoolefy/score/Test/test.log"=>"my.log"],
		// ];
	]

];