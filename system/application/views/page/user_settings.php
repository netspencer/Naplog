<section id="settings">
	<?=form_open("settings");?>
		<?=validation_errors();?>
		<input name="username" type="text" value="<?=$username?>"/>
		<input name="password" type="password" value="<?=$password?>"/>
		<input type="submit"/>
	<?=form_close();?>
</section>