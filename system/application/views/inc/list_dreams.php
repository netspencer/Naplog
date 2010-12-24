<div class="dreams">
<?php foreach($dreams as $dream):?>
	<div id="dream_<?=$dream->dream_id?>" class="dream">
		<div class="top">
			<div class="left">
				<?php if(!$dream->anonymous):?>
				<a href="<?=base_url()?>user/<?=$dream->username?>"><div class="avatar"><img src="http://img.tweetimag.es/i/<?=$dream->twitter?>_b" /></div></a>
				<?php else:?>
				<div class="avatar"><img src="http://img.tweetimag.es/i/twitter_b" /></div>
				<?php endif;?>
			</div>
			<div class="right">
				<div class="content"><?=$dream->content?></div>				
			</div>
			<div class="clear"></div>
		</div>
		<div class="bottom">
			<h3 class="action"><a href="<?=base_url()?>user/<?=$dream->username?>"><?=$dream->fullname?></a> &mdash; <a href="<?=base_url()?>dream/<?=$dream->dream_id?>"><span class="timestamp" title="<?=$dream->iso_timestamp?>"><?=$dream->full_timestamp?></span></a></h3>
			<ul class="buttons">
				<li><a rel="like" <?php if($dream->user_liked): ?>class="liked"<?php endif;?> href="#"><?=$dream->num_likes?> likes</a></li>
				<li><a href="#" rel="comment"><?=$dream->num_comments?> comments</a></li>
			</ul>
			<div class="clear"></div>
		</div>
	</div>
<?php endforeach;?>
</div>