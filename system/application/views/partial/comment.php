<li <?php if($comment->username==$username):?>class="current-user"<?php endif; ?> id="comment_<?=$comment_id?>">
		<div class="top">
			<div class="avatar"><a href="<?=base_url()?>user/<?=$username?>"><img src="http://img.tweetimag.es/i/<?=$twitter?>_m" alt="<?=$username?>" /></a></div>
			<div class="text"><a class="user" href="<?=base_url()?>user/<?=$username?>"><?=$username?></a><span class="timestamp" title="<?=$iso_timestamp?>"><?=$full_timestamp?></span><span class="reply">reply</span></div>
			<div class="clear"></div>
		</div>
		<div class="content"><?=$content?></div>
</li>