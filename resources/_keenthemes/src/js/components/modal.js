window.confirmAction = function(title, text, formId) {
    document.querySelector('#modal .modal-title').textContent = title;
    document.querySelector('#modal .modal-body').textContent = text;

    var form = document.getElementById(formId);

    document.querySelector('#modal .btn-primary').onclick = function() {
        form.submit();
    };

    $('#modal').modal('show');
};

$(document).ready(function(){
    document.getElementById('cancelButton').addEventListener('click', function () {
        $('#modal').modal('hide');
    });
});
