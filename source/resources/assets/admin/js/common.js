jQuery(document).ready(function() {
    /**
     * Bootstrap select
     */
    $(".m-bootstrap-select").selectpicker();
});

/**
 * Confirm form submit action
 */
function confirmSubmit(event, element) {
    event.preventDefault();

    swal({
        text: translator.trans('admin.confirm.delete.text'),
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: translator.trans('admin.confirm.delete.confirm_button'),
        cancelButtonText: translator.trans('admin.confirm.delete.cancel_button')
    }).then((result) => {
        if (result.value) {
            $(element).parent('form').submit();
        }
    });
}

function logout(event) {
    if(event){
        event.preventDefault();
        $('#logout-form').submit();
    }
}

function uploadFile(element) {
    element.click();
}

function loadImageToImgTag(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
}
