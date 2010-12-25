<div id="dream_${dream_id}" class="dream">
	<div class="top">
		<div class="left">
			<a href="<?=base_url()?>user/${username}"><div class="avatar"><img src="http://img.tweetimag.es/i/${twitter}_b" /></div></a>
		</div>
		<div class="right">
			<div class="content">${content}</div>				
		</div>
		<div class="clear"></div>
	</div>
	<div class="bottom">
		<h3 class="action"><a href="<?=base_url()?>user/${username}">${fullname}</a> &mdash; <a href="<?=base_url()?>dream/${dream_id}"><span class="timestamp" title="${iso_timestamp}">${full_timestamp}</span></a></h3>
		<ul class="buttons">
			<li><a rel="like" <?php if($user_liked): ?>class="liked"<?php endif;?> href="#">${num_likes} likes</a></li>
			<li><a href="#add-comment" rel="comment">${num_comments} comments</a></li>
		</ul>
		<div class="clear"></div>
	</div>
</div>
