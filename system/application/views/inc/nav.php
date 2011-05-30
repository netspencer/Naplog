<header class="container_12">
	<hgroup class="grid_12">
		<div class="left">
			<h1><a href="<?=base_url()?>"><img src="<?=base_url()?>public/img/dolphinlogo.png"></a></h1>
		</div>
		<nav class="right">
			<ul class="nav">
				<li class="left first <?php if($current=="dashboard") echo "current"; ?>"><a href="<?=base_url()?>dashboard">Dashboard</a></li>
				<li class="left <?php if($current=="dreams") echo "current"; ?>"><a href="<?=base_url()?>dreams">Dreams</a></li>
				<li class="left <?php if($current=="people") echo "current"; ?>"><a href="<?=base_url()?>people">People</a></li>
				<?php if($user_data):?>
				<li class="right user first <?php if($current=="account") echo "current"; ?>"><a href="<?=base_url()?>user/<?=$user_data->username?>"><?=$user_data->username?></a>
					<ul class="sub">
						<li><a href="<?=base_url()?>notifications">Notifications</a></li>
						<li><a href="<?=base_url()?>settings">Settings</a></li>
						<li><a href="<?=base_url()?>auth/logout">Logout</a></li>
					</ul>
				</li>
				<?php else:?>
				<li class="right user first <?php if($current=="account") echo "current"; ?>"><a href="<?=base_url()?>auth/login">Login</a></li>
				<?php endif;?>
				<div class="clear"></div>
			</ul>
		</nav>
		<div class="clear"></div>
	</hgroup>
	<div class="clear"></div>
</header>