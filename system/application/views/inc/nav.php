<nav>
	<div class="container_12">
		<div class="grid_12">
			<ul class="nav">
				<li class="left first <?php if($current=="dashboard") echo "current"; ?>"><a href="<?=base_url()?>dashboard">Dashboard</a></li>
				<li class="left <?php if($current=="dreams") echo "current"; ?>"><a href="<?=base_url()?>dreams">Dreams</a></li>
				<li class="left <?php if($current=="people") echo "current"; ?>"><a href="<?=base_url()?>people">People</a></li>
				<li class="left <?php if($current=="explore") echo "current"; ?>"><a href="<?=base_url()?>explore">Explore</a></li>
				<?php if($username):?>
				<li class="right user first <?php if($current=="account") echo "current"; ?>"><a href="<?=base_url()?>users"><?=$username?></a>
					<ul class="sub">
						<li><a href="<?=base_url()?>settings">Settings</a></li>
						<li><a href="<?=base_url()?>auth/logout">Logout</a></li>
					</ul>
				</li>
				<?php else:?>
				<li class="right user first <?php if($current=="account") echo "current"; ?>"><a href="<?=base_url()?>auth/login">Login</a></li>
				<?php endif;?>
				<div class="clear"></div>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
</nav>