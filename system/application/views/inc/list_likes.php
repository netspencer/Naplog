<ul class="likes">
	<?php if($num_likes):?><li class="num_likes"></li><?php endif;?>
	<?php 
	$i = 0;
	$numLikes = count($likes);
	foreach($likes as $like):
	?>
	<li class="user<?php if($like->username==$user_data->username):?> current-user<?php endif; ?>">
	<a href="<?=base_url()?>user/<?=$like->username?>"><?=$like->username?></a><?php if(++$i!=$numLikes):?><span>,</span><?php endif;?></li>
	<?php endforeach; ?>
	<div class="clear end-loop"></div>
</ul>