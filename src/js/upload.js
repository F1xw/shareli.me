var upload_abort = false

function startUpload(file) {
    if(file){
        $('.upload-button').hide();
        $('.error-message').hide();
        $('.upload-progress-container').show();
        $('.cancle-upload-button').show();
        formData = new FormData();
        formData.append('file', file);
        console.log(file);

            $.ajax({
                url        : 'https://shareli.me/upload/',
                type       : 'POST',
                contentType: false,
                cache      : false,
                processData: false,
                data       : formData,
                xhr        : function (){
                    var jqXHR = null;
                    if ( window.ActiveXObject ){
                        jqXHR = new window.ActiveXObject("Microsoft.XMLHTTP");
                    }else{
                        jqXHR = new window.XMLHttpRequest();
                    }

                    //Upload progress
                    jqXHR.upload.addEventListener( "progress", function ( evt ){
                        if ( evt.lengthComputable ){
                            var percentComplete = Math.round( (evt.loaded * 100) / evt.total );
                            $('.upload-progress').css('width', percentComplete+'%');
                            $('.upload-percent').html(percentComplete+'%');
                        }
                        if (window.upload_abort == true) {
                            jqXHR.abort();
                        }
                    }, false );

                    return jqXHR;
                },
                success: function ( data ){
                    if (data.includes("ERR_")) {
                        window.location.assign("/?#err")
                    }
                    console.log('Upload complete.');
                    $('.upload-progress-container').hide();
                    $('.cancle-upload-button').hide();
					$('.file-qr').html("<img src='/src/html/qr.php?fid="+data+"'>");
					$('.file-qr').show();
                    $('#file-uri').val('https://shareli.me/?'+data);
                    $('.file-uri').show();
                }
            } );
    }
}

$(document).ready(function () {
    $('.cancle-upload-button').click(function()
    {
        window.upload_abort = true;
        window.location.reload(1);
    }); 
});
