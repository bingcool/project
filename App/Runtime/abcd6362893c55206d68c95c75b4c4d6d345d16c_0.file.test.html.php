<?php
/* Smarty version 3.1.30, created on 2018-04-15 17:22:00
  from "/home/www/project/App/View/book_Book/test.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5ad319b86c20d6_60718272',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'abcd6362893c55206d68c95c75b4c4d6d345d16c' => 
    array (
      0 => '/home/www/project/App/View/book_Book/test.html',
      1 => 1517625847,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ad319b86c20d6_60718272 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
	<title>测试swoole的开启</title>
	<?php echo '<script'; ?>
 src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"><?php echo '</script'; ?>
>
</head>
<body>
<div>
	<h2>hello,swoole test vvvvvvvvvvvv!<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</h2>
</div>
<div id="text">
	
</div>
<button id="btn">点击ajax</button>
<div id="showtext"></div>
<!-- <?php echo '<script'; ?>
 type="text/javascript">
	ws = new WebSocket("ws://192.168.44.128:9503");
	ws.onopen = function(){  
	  ws.send('hello!');	
	};

	ws.onmessage = function(evt){
		console.log(evt.data);
		$('#showtext').text(evt.data);
	};

	ws.onclose = function(evt){
	  console.log("WebSocketClosed!");
	};

	ws.onerror = function(evt){
	  console.log("WebSocketError!");
	};

	window.onbeforeunload = function() {
		ws.close();
	};

<?php echo '</script'; ?>
> -->
<?php echo '<script'; ?>
 type="text/javascript">
	$("#btn").click(function() {
		$.ajax({
			url:'/Test/testajax?name=bingcool',
			type:'get',
			success:function(data) {
				console.log(data);
			}
		});
	});
<?php echo '</script'; ?>
>
</body>
</html><?php }
}
