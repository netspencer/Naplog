<section id="user">
	<div class="container_12">
		<div class="clear"></div>
		
		<div id="profile_page_banner" class="grid_8">
				<div class="profile_page_picture">
					<img class="profile_page_picture" src="http://img.tweetimag.es/i/<?=$user->twitter?>_b" />
				</div>
				<div class="profile_page_header">
					<p class="profile_page_header_fullname"><?=$user->fullname?></p>
					<p class="profile_page_header_username">@<?=$user->username?></p>
				</div>
				<div id="user_stats">
					<div class="user_stats user_dreams">
						<p class="user_stats stat_num">value</p>
						<p class="user_stars stat_name">Dreams</p>
					</div>
					<div class="user_stats user_followers">
						<a class="user_stats" href="<?=base_url()?>user/<?=$user->username?>/followers">
							<p class="user_stats stat_num"><?=$followers_num?></p>
							<p class-"user_stats stat_name">Followers</p>
						</a>
					</div>
					<div class="user_stats user_followings">
						<a class="user_stats" href="<?=base_url()?>user/<?=$user->username?>/following">
							<p class="user_stats stat_num"><?=$following_num?></p>
							<p class="user_stats stat_name">Following</p>
						</a>
					</div>	
				</div>
		</div>
		
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
		</div>
		<div class="clear"></div>
	</div>
</section>