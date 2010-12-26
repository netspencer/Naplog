<section id="user">
	<div class="container_12">
		<div class="clear"></div>
		<div class="grid_8">
			<?php $this->load->view("inc/list_dreams", array("dreams"=>$dreams));?>
			<a href="#" id="load_more">Load More Dream</a>
		</div>
		<div class="grid_4">
			<?php if (!$is_self):?>
			<div rel="<?=$user_id?>" class="follow_button">
				<?php if ($does_follow):?>
				<a class="unfollow" href="#" rel="">Unfollow</a>
				<?php else:?>
				<a class="follow" href="#" rel="">Follow</a>
				<?php endif;?>
			</div>
			<?php endif;?>
			<p><a href="<?=base_url()?>user/<?=$user->username?>/followers">Followers</a>: <?=$followers_num?></p>
			<p><a href="<?=base_url()?>user/<?=$user->username?>/following">Following</a>: <?=$following_num?></p>
		</div>
		<div class="clear"></div>
	</div>
</section>