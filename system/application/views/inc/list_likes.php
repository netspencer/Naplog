<ul class="likes">
	<?php foreach($likes as $like):?>
	<li title="<?=$like->username?>"><a href="<?=base_url()?>user/<?=$like->username?>"><img src="http://img.tweetimag.es/i/<?=$like->twitter?>_m" alt="<?=$like->username?>" /></a></li>
	<?php endforeach; ?>
	<div class="clear"></div>
</ul>