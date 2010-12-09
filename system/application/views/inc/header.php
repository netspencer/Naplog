<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title><?=$page_title?></title>
	<?php $this->carabiner->display("css")?>
		
</head>

<body <?php if($body_class): ?>class="<?=$body_class?>"<?php endif;?>>
	
	<header>
		<div class="container_12">
			<div class="grid_2">
				<h1><a href="<?=base_url()?>"><img src="<?=base_url()?>public/img/dolphinlogo.png"></a></h1>
			</div>
			<div class="grid_10">
				<h2>where dreams come to life...</h2>
			</div>
			<div class="clear"></div>
		</div>
	</header>