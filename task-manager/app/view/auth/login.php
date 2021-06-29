<form method="post">
	<div class="form-group">
		<label for="loginInput">Login</label>
		<input name="login" type="text"
			   class="form-control<?= $errors['login'] ? ' is-invalid' : '' ?>"
			   id="loginInput" placeholder="Your Login"
			   value="<?= $values['login'] ?>">
		<?= $errors['login'] ? '<div class="invalid-feedback">' . $errors['login'] . '</div>' : '' ?>
	</div>
	<div class="form-group">
		<label for="passwordInput">Password</label>
		<input name="password" type="password"
			   class="form-control<?= $errors['password'] ? ' is-invalid' : '' ?>"
			   id="passwordInput" placeholder="Your password">
		<?= $errors['password'] ? '<div class="invalid-feedback">' . $errors['password'] . '</div>' : '' ?>
	</div>
	<button type="submit" class="btn btn-primary">Submit</button>
</form>
