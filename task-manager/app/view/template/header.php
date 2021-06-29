<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $page_title ?></title>
	<link rel="stylesheet" href="/public/css/bootstrap.min.css">
	<link rel="stylesheet" href="/public/css/app.css">
</head>
<body>
<header class="container-fluid">
	<nav class="navbar navbar-expand-lg navbar-light bg-light row">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03"
				aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<a class="navbar-brand" href="<?= HOST ?>">Tasks</a>

		<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
			<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
				<li class="nav-item">
					<a class="nav-link" href="<?= HOST ?>/task/create">Create</a>
				</li>
			</ul>
			<ul class="navbar-nav  my-2 my-lg-0">
				<li class="nav-item">
					<a class="nav-link" href="<?= HOST ?>/auth<?=$is_admin ? '/logout' : ''?>">
						<?=$is_admin ? 'Logout' : 'Login'?>
					</a>
				</li>
			</ul>
		</div>
	</nav>
	<div class="container my-3">
		<div class="row">
			<h1 class="col-12"><?= $page_header ?></h1>
		</div>
	</div>
</header>
<div class="container">
	<?php foreach ($page_alerts as $type => $alert): ?>
		<?php if(is_array($page_alerts[$type])): foreach($page_alerts[$type] as $msg):?>
			<div class="alert alert-<?= $type ?>" role="alert"><?= $msg ?></div>
		<?php endforeach; else: ?>
			<div class="alert alert-<?= $type ?>" role="alert"><?= $alert ?></div>
		<?php endif ?>
	<?php endforeach ?>
