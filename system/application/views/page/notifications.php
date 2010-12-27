<ul>
<?php foreach($notifications as $notification):?>
	<li><a href="<?=$notification->link?>"><?=$notification->text?></a></li>
<?php endforeach;?>
</ul>