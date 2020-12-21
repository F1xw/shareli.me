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

            function licenseValidity() {
                $.get('https://shareli.me/auth/validate/?license='+license, function (data) {
                    if (data == 'valid') {
                        return true;
                    } else {
                        return false;
                    }
                });
            }

            if (licenseValidity()) {
                if (this.files[0].size > 5000000000) {
                    new Toast({
                        message: 'We\'re sorry, but we currently only host files up to 5GB.',
                        type: 'danger'
                    });
                }else{
                    startUpload();
                }
            }else{
                if (this.files[0].size > 1000000000) {
                    new Toast({
                        message: 'Your file exeeded 1GB. <a href="/upgrade/">Upgrade to Pro now</a> for 5GB per file.',
                        type: 'warning'
                    });
                }else{
                    startUpload();
                }
            }
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

