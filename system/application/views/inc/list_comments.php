<ul class="comments">
	<?php foreach($comments as $comment):?>
	<li id="comment_<?=$comment->comment_id?>">
		<div class="top">
			<a href="<?=base_url()?>user/<?=$comment->username?>"><img src="http://img.tweetimag.es/i/<?=$comment->twitter?>_m" alt="<?=$comment->username?>" /><span class="username"><?=$comment->username?></span></a> said&hellip;
		</div>
		<div class="top">
			<?=$comment->content?>
		</div>
	</li>
	<?php endforeach;?>
</ul>