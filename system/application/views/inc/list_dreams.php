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
			<h3 class="action"><a href="<?=base_url()?>user/<?=$dream->username?>"><?=$dream->fullname?></a> &mdash; <span class="timespan" rel="<?=$dream->created_at?>" title="<?=$dream->full_timestamp?>"><?=$dream->smart_timestamp?></span></h3>
			<ul class="buttons">
				<li><a rel="like" href="#"><?=$dream->num_likes?> likes</a></li>
				<li><a href="#" rel="comment"><?=$dream->num_comments?> comments</a></li>
			</ul>
			<div class="clear"></div>
			<?php $this->load->view("inc/list_likes", array("likes"=>$dream->likes->list))?>
		</div>
	</div>
<?php endforeach;?>
</div>