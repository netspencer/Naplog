<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title><?=$subject?></title>
	
	<style type="text/css">
		* {
			margin:0;
			padding:0;
		}
		body {
			border-top:10px #17306a solid;
			background:#FFF;
			font-family:Helvetica, sans-serif;
			line-height:1.5;
		}
		#email {
			margin:20px;
			padding:20px;
			border:1px #EEE solid;
		}
		h1.subject {
			font-size:18px;
			font-weight:normal;
			color:#fff;
			background:#1f62b1;
			padding:10px 20px;
			margin-bottom:10px;
			border-bottom:1px #55abd9 solid;
		}
		img.avatar {
			float:left;
			margin-right:20px;
			width:60px;
		}
		div.content {
			font-size:16px;
			float:left;
			color:#333;
		}
		div.response_to {
			margin-top:10px;
			padding-top:10px;
			border-top:1px #EEE solid;
			color:#CCC;
			font-size:14px;
		}
	</style>
	
</head>

<body>
	<h1 class="subject"><?=$subject?></h1>
	
	<div id="email">
		<img src="<?=$avatar?>" class="avatar" alt="avatar" />
		<div class="content">
			<?=$content?>
		</div>
		<div style="clear:both;"></div>
		<?php if(isset($response_to_content)):?>
		<div class="response_to">
			<?=$response_to_content?>
		</div>
		<?php endif;?>
	</div>


</body>
</html>
