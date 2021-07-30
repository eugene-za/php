<?= $this->render('template-parts/header'); ?>

<section class="container">

    <h1>You will be redirected in <?= $this->data['time'] ?> seconds</h1>
    <a href="<?= $this->data['location'] ?>"><?= $this->data['location'] ?></a>

</section>

<?= $this->render('template-parts/footer'); ?>