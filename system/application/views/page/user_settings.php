<section id="settings" class="container_12">
	<div class="grid_8 suffix_2 prefix_2">
		<div class="middle">
			<h1 class="title"><img src="http://img.tweetimag.es/i/<?=$user->twitter?>_m" alt="<?=$user->twitter?>" class="avatar" /><span><?=$user->username?>'s settings</span></h1>
			<?=form_open("settings");?>
				<div class="errors"><?=validation_errors();?></div>
				<div class="form-row">
					<label for="fullname">Full name</label>
					<input type="text" value="<?=$user->fullname?>" name="fullname" />
				</div>
				<div class="form-row">
					<label for="nickname">Nickname</label>
					<input type="text" value="<?=$user->nickname?>" name="nickname" />
				</div>
				<div class="form-row">
					<label for="username">Username</label>
					<input readonly="readonly" type="text" value="<?=$user->username?>" name="username" />
				</div>
				<div class="form-row">
					<label for="email">Email</label>
					<input type="text" value="<?=$user->email?>" name="email" />
				</div>
				<div class="form-row"><a href="#" id="set_new_password">Set a new password</a></div>
				<div class="form-row hidden" id="new_password">
					<label for="password">New password</label>
					<input type="password" name="password" />
				</div>
				<div class="form-row"><input type="submit" value="Save Settings" /></div>
				<div class="clear"></div>
			<?=form_close();?>
		</div>
	</div>
	<div class="clear"></div>
</section>