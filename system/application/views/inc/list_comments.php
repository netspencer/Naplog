<ul class="comments">
	<?php foreach($comments as $comment):?>
	<li id="comment_<?=$comment->comment_id?>">
			<div class="avatar"><a href="<?=base_url()?>user/<?=$comment->username?>"><img src="http://img.tweetimag.es/i/<?=$comment->twitter?>_m" alt="<?=$comment->username?>" /></a></div>
			<div class="content"><?=$comment->content?></div>
			<div class="clear"></div>
	</li>
	<?php endforeach;?>
</ul>