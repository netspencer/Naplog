<section id="login">
	<h2>Login</h2>
	<?=form_open("auth/login")?>
		<?=validation_errors()?>
		<p><span>Username</span><input name="username" type="text" /></p>
		<p><span>Password</span><input name="password" type="password" /></p>
		<p><input type="submit"></p>
	<?=form_close()?>
</section>