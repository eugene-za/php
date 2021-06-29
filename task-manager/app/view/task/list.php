<div class="table-responsive">
	<table class="table table-bordered">
		<thead class="thead-dark">
		<tr>
			<th>#</th>
			<th class="orderable <?= getTaskOrderedColClass('name', $order) ?>">
				<a href="?<?= composeUrlParams(['order' => 'name', 'dir' => getTaskOrderedColDirection('name', $order)]) ?>"
				   title="Order by Name">Author Name</a>
			</th>
			<th class="orderable <?= getTaskOrderedColClass('email', $order) ?>">
				<a href="?<?= composeUrlParams(['order' => 'email', 'dir' => getTaskOrderedColDirection('email', $order)]) ?>"
				   title="Order by Name">Author Email</a>
			</th>
			<th>Text</th>
			<th class="orderable <?= getTaskOrderedColClass('status', $order) ?>">
				<a href="?<?= composeUrlParams(['order' => 'status', 'dir' => getTaskOrderedColDirection('status', $order)]) ?>"
				   title="Order by Status">Status</a>
			</th>
			<th>Is Edited</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($tasks_list as $task): ?>
			<tr>
				<th scope="row"><?= $task['id'] ?></th>
				<td><?= $task['name'] ?></td>
				<td><a href="mailto:<?= $task['email'] ?>"><?= $task['email'] ?></a></td>
				<td><?= $task['text'] ?></td>
				<td><?= $task['status'] ? 'Completed' : 'New' ?></td>
				<td><?= $task['edited_by_admin'] ? 'Yes' : 'No' ?></td>
				<?php if ($is_admin): ?>
					<td>
						<a href="<?= HOST . '/task/edit?id=' . $task['id'] ?>" title="Edit Task"></a>
					</td>
				<?php endif ?>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
</div>

<nav class="mt-3">
	<ul class="pagination justify-content-end">
		<li class="page-item <?= $current_page > 1 ? '' : 'disabled' ?>">
			<a class="page-link" href="?<?= composeUrlParams(['page' => $current_page - 1]) ?>">Previous</a>
		</li>
		<?php for ($p = 1; $p <= $pages_count; $p++): ?>
			<li class="page-item <?= $current_page == $p ? 'active' : '' ?>">
				<a class="page-link" href="?<?= composeUrlParams(['page' => $p]) ?>"><?= $p ?></a>
			</li>
		<?php endfor ?>
		<li class="page-item <?= $current_page < $pages_count ? '' : 'disabled' ?>">
			<a class="page-link" href="?<?= composeUrlParams(['page' => $current_page + 1]) ?>">Next</a>
		</li>
	</ul>
</nav>