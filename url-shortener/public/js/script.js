const inputLong = document.getElementById('input_long');
const inputShort = document.getElementById('input_short');
const btnLong = document.getElementById('btn_long');
const btnHits = document.getElementById('btn_hits');
const btnCopy = document.getElementById('btn_copy');
const host = document.querySelector('label[for="input_short"]').textContent;
const errorContainer = document.querySelector('.error');
const infoContainer = document.querySelector('.info');


/**
 * Copy to clipboard function
 * @param textToCopy
 * @returns {Promise<unknown>|Promise<void>}
 */
function copyToClipboard(textToCopy) {
    // navigator clipboard api needs a secure context (https)
    if (navigator.clipboard && window.isSecureContext) {
        // navigator clipboard api method'
        return navigator.clipboard.writeText(textToCopy);
    } else {
        // text area method
        let textArea = document.createElement("textarea");
        textArea.value = textToCopy;
        // make the textarea out of viewport
        textArea.style.position = "fixed";
        textArea.style.left = "-999999px";
        textArea.style.top = "-999999px";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        return new Promise((res, rej) => {
            // here the magic happens
            document.execCommand('copy') ? res() : rej();
            textArea.remove();
        });
    }
}


/**
 * Show error message
 * @param error
 */
function setError(error) {
    errorContainer.innerHTML = error ? error : '';
}


/**
 * Show info message
 * @param info
 */
function setInfo(info) {
    infoContainer.innerHTML = info ? info : '';
}


/**
 * Toggle button state
 * @param btn
 * @param disabled
 */
function toggleBtnDisabledState(btn, disabled) {
    if (disabled) {
        btn.setAttribute('disabled', 'disabled');
    } else {
        btn.removeAttribute('disabled');
    }
}


/**
 * Add change listeners on "long url input"
 */
'load change keyup'.split(" ").forEach(function (e) {
    inputLong.addEventListener(e, function () {
        toggleBtnDisabledState(btnLong, (this.value === ''));
        setError(null);
        setInfo(null);
        inputShort.value = '';
        let changeEvent = new Event('change');
        inputShort.dispatchEvent(changeEvent);
    }, false);
});


/**
 * Add change listeners on "code input"
 */
'load change keyup'.split(" ").forEach(function (e) {
    inputShort.addEventListener(e, function () {
        toggleBtnDisabledState(btnHits, (this.value === ''));
        setError(null);
        setInfo(null);
    }, false);
});


/**
 * Add click listener on "Copy" button
 */
btnCopy.addEventListener('click', function () {
    copyToClipboard(host + inputShort.value);
    setInfo('Copied')
});


/**
 * Add click listener on "Get shorten" button
 */
btnLong.addEventListener('click', async function (e) {
    setError(null);
    let longURL = inputLong.value;

    if (longURL !== '') {

        let response = await fetch(host, {
            method: 'POST',
            headers: {'Content-type': 'application/json; charset=UTF-8'},
            body: JSON.stringify({
                url: longURL
            })
        });

        if (response.ok) { // if HTTP-status in range 200-299
            let result = await response.json();
            if (result.status === 'ok') {
                inputShort.value = result.code;
                let changeEvent = new Event('change');
                inputShort.dispatchEvent(changeEvent);
                setInfo('Shot is ready!');
            } else {
                setError(result.error);
            }
        } else {
            setError('Error: ' + response.status);
        }

    }
});


/**
 * Add click listener on "Show hits" button
 */
btnHits.addEventListener('click', async function (e) {
    setInfo(null);
    let shortCode = inputShort.value;

    if (shortCode !== '') {

        let response = await fetch(host + shortCode + '?hits');

        if (response.ok) { // if HTTP-status in range 200-299
            let result = await response.json();
            if (result.status === 'ok') {
                setInfo('Hits: ' + result.hits);
            } else {
                setError(result.error);
            }
        } else {
            setError('Error: ' + response.status);
        }

    }
});
