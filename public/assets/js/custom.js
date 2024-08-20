/* Helpful functions */
function pause_submit_button(element) {
    /* Disable the button */
    element.setAttribute('disabled', 'disabled');

    /* Save the current button text */
    element.setAttribute('data-inner-text', element.innerText);

    /* Show a loading spinner instead of the text */
    element.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"></div>';
}

function enable_submit_button(element) {
    /* Enable the button */
    element.removeAttribute('disabled');

    /* Show the original button text */
    element.innerHTML = element.getAttribute('data-inner-text');
}

