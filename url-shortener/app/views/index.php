<?= $this->render('template-parts/header'); ?>

<section class="container">

    <div class="long">
        <div class="input">
            <textarea id="input_long" name="url" rows="3"
                      placeholder="hello://paste.here/the-long-URL/that-you-want-to-get-shorten"></textarea>
            <button id="btn_long" disabled>get<br><span>shorten</span></button>
        </div>
    </div>

    <div class="error"></div>

    <div class="info"></div>

    <div class="short">
        <label for="input_short"><?= siteURL('/') ?></label>
        <input id="input_short" class="empty" placeholder="SHorTeN">
    </div>

    <div class="controls">
        <button id="btn_hits" disabled>show hits</button>
        <button id="btn_copy">copy to clipboard</button>
    </div>

</section>

<?= $this->render('template-parts/footer'); ?>