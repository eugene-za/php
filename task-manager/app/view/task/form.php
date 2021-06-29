<form method="post">
	<div class="form-group">
		<label for="nameInput">Name</label>
		<input name="name" type="text" <?= (isset($is_edit) && $is_edit) ? 'disabled' : '' ?>
			   class="form-control<?= $errors['name'] ? ' is-invalid' : '' ?>"
			   id="nameInput" placeholder="Name"
			   value="<?= $values['name'] ?>">
		<?= $errors['name'] ? '<div class="invalid-feedback">' . $errors['name'] . '</div>' : '' ?>
	</div>
	<div class="form-group">
		<label for="emailInput">Email address</label>
		<input name="email" type="text" <?= (isset($is_edit) && $is_edit) ? 'disabled' : '' ?>
			   class="form-control<?= $errors['email'] ? ' is-invalid' : '' ?>"
			   id="emailInput" placeholder="name@example.com"
			   value="<?= $values['email'] ?>">
		<?= $errors['email'] ? '<div class="invalid-feedback">' . $errors['email'] . '</div>' : '' ?>
	</div>
	<div class="form-group">
		<label for="taskTextarea">Task</label>
		<textarea name="text"
				  class="form-control<?= $errors['text'] ? ' is-invalid' : '' ?>"
				  id="taskTextarea" rows="3"><?= $values['text'] ?></textarea>
		<?= $errors['text'] ? '<div class="invalid-feedback">' . $errors['text'] . '</div>' : '' ?>
	</div>
	<?php if (isset($is_edit) && $is_edit): ?>
		<div class="form-group">
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="status"
					   value="1" <?= $values['status'] ? 'checked' : '' ?> id="status">
				<label class="form-check-label" for="status">
					Completed
				</label>
			</div>
		</div>
	<?php endif ?>
	<button type="submit" class="btn btn-primary">Submit</button>
</form>
