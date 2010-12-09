<section id="people">
	<div class="container_12">
		<div class="grid_12">
			<ul class="list-people">
				<?php foreach($people as $person):?>
				<li>
					<div class="grid_1 alpha">
						<a href="<?=base_url()?>user/<?=$person->username?>"><div class="avatar"><img src="http://img.tweetimag.es/i/<?=$person->twitter?>_b" /></div></a>
						</div>
					<div class="grid_4">
						<h2 class="name"><a href="<?=base_url()?>user/<?=$person->username?>"><?=$person->fullname?></a></h2>
					</div>
					<div class="grid_2 omega suffix_5">
						<?php if (!$person->is_self):?>
						<div rel="<?=$person->user_id?>" class="follow_button">
							<?php if ($person->does_follow):?>
							<a class="unfollow" href="#" rel="">Unfollow</a>
							<?php else:?>
							<a class="follow" href="#" rel="">Follow</a>
							<?php endif;?>
						</div>
						<?php endif;?>
					</div>
					<div class="clear"></div>
				</li>
				<?php endforeach;?>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
</section>