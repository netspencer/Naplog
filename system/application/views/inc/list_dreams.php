<div class="dreams">
<?php foreach($dreams as $dream):?>
	<div id="dream_<?=$dream->dream_id?>" class="dream">
		<div class="grid_1 alpha">
			<?php if(!$dream->anonymous):?>
			<a href="<?=base_url()?>user/<?=$dream->username?>"><div class="avatar"><img src="http://img.tweetimag.es/i/<?=$dream->twitter?>_b" /></div></a>
			<?php else:?>
			<div class="avatar"><img src="http://img.tweetimag.es/i/twitter_b" /></div>
			<?php endif;?>
		</div>
		<div class="grid_7 omega">
			<?php if($dream->anonymous):?>
			<h3 class="action"><?=$dream->anon_nickname?> recorded a <?=$dream->sleep_hours?> hour nap for <?=$dream->date_for?></h3>
			<?php else:?>
			<h3 class="action"><a href="<?=base_url()?>user/<?=$dream->username?>"><?=$dream->fullname?></a> recorded a <?=$dream->sleep_hours?> hour nap for <?=$dream->date_for?></h3>
			<?php endif;?>
			<div class="content"><?=$dream->content?></div>
			<ul class="buttons">
				<li><a rel="like" href="#"><?=$dream->num_likes?> likes</a></li>
				<li><a href="#" rel="comment"><?=$dream->num_comments?> comments</a></li>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
<?php endforeach;?>
</div>