$(document).ready(function () {
    $('#upload').click(function () {
        $('.file-upload').click();
    }); 
});

$(document).ready(function () {
    if ($('.file-upload').disabled() == true) {
      alert('Your browser does not support file upload');
    } 
});

$(document).ready(function () {
    $('.file-upload').bind('change', function() {
        if (license === null) {
            new Toast({
                message: 'Whoops. Forgot to hook you up with a unique ID. Please try refreshing the page.',
                type: 'danger'
            });
        }else{
            checkUpload($('.file-upload').get( 0 ).files[0]);
        }
    });
});

$(document).ready(function () {
    $('#file-uri').click(function () {
        $('#file-uri').select();
        document.execCommand('copy');
        new Toast({
            message: 'Copied to Clipboard!',
            type: 'success'
        });
    }); 
});

$(document).ready(function () {
    $('.uri-input').keydown(function () {
        if ($('.uri-input').val().length == 6) {
            window.location.assign('/?'+$('.uri-input').val());
        }
    });
});

$(document).ready(function(){
    $(window).on('dragenter', function(e){
        e.preventDefault();
    });
    $('body').bind('dragover', function(e){
        $(this).addClass('drag');
        swapUploadText('<i class="fas fa-mouse-pointer"></i>&nbsp;or drop it here');
        e.preventDefault();
    });
    $('body').bind('dragleave', function(e){
        $(this).removeClass('drag');
        swapUploadText('<i class="fas fa-upload"></i>&nbsp;Upload a file');
        e.preventDefault();
    });
    $('html').on('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('drag');
        swapUploadText('<i class="fas fa-upload"></i>&nbsp;Upload a file');
        var file = e.originalEvent.dataTransfer.files[0];
        checkUpload(file);
    });
});

function swapUploadText(text) {
    if ($('.upload-button').html() != text) {
        $('.upload-button').html(text);
    }
}

function licenseValidity() {
    $.get('https://shareli.me/auth/validate/?license='+license, function (data) {
        if (data == 'valid') {
            return true;
        } else {
            return false;
        }
    });
}

function checkUpload(file) {
    if (licenseValidity()) {
        if (file.size > 5000000000) {
            new Toast({
                message: 'We\'re sorry, but we currently only host files up to 5GB.',
                type: 'danger'
            });
        }else{
            startUpload(file);
        }
    }else{
        if (file.size > 1000000000) {
            new Toast({
                message: 'Your file exeeded 1GB. <a href="/upgrade/">Upgrade to Pro now</a> for 5GB per file.',
                type: 'warning'
            });
        }else{
            startUpload(file);
        }
    }
}