<section id="notifications" class="container_12">
	<div class="grid_8 suffix_4">
		<ul>
		<?php foreach($notifications as $notification):?>
			<li class="<?=($notification->obj->read) ? "read" : "unread"?>"><a href="<?=$notification->link?>">
				<div class="avatar"><img src="http://img.tweetimag.es/i/<?=$notification->user->twitter?>_m" alt="<?=$notification->user->twitter?>" /></div>
			<p class="text">
				<span class="notif"><?=$notification->text?></span>
				<span class="timestamp" title="<?=$notification->iso_timestamp?>"><?=$notification->full_timestamp?></span>
			</p>
			<div class="clear"></div>
			</a></li>
		<?php endforeach;?>
		</ul>
	</div>
	<div class="clear"></div>
</section>