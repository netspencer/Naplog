<script id="new-comment" type="text/x-jquery-tmpl">
	<li {{if CurrentUser}}class="current-user"{{/if}} id="comment_${comment_id}">
			<div class="top">
				<div class="avatar"><a href="<?=base_url()?>user/${username}"><img src="http://img.tweetimag.es/i/${twitter}_m" alt="${username}" /></a></div>
				<div class="text"><a class="user" href="<?=base_url()?>user/${username}">${username}</a><span class="timestamp" rel="${created_at}" title="${iso_timestamp}">${full_timestamp}</span></div>
				<div class="clear"></div>
			</div>
			<div class="content">${content}</div>
	</li>
</script>
<ul class="comments">
	<?php foreach($comments as $comment):?>
	<li <?php if($comment->username==$username):?>class="current-user"<?php endif; ?> id="comment_<?=$comment->comment_id?>">
			<div class="top">
				<div class="avatar"><a href="<?=base_url()?>user/<?=$comment->username?>"><img src="http://img.tweetimag.es/i/<?=$comment->twitter?>_m" alt="<?=$comment->username?>" /></a></div>
				<div class="text"><a class="user" href="<?=base_url()?>user/<?=$comment->username?>"><?=$comment->username?></a><span class="timestamp" title="<?=$comment->iso_timestamp?>"><?=$comment->full_timestamp?></span></div>
				<div class="clear"></div>
			</div>
			<div class="content"><?=$comment->content?></div>
	</li>
	<?php endforeach;?>
	<div class="end-loop"></div>
</ul>