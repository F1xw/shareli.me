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
                    data = JSON.parse(data);
                    if (data.errors != undefined) {
                        window.location.assign("/?#err")
                    }else{
                        console.log('Upload complete.');
                        console.log('URI is: '+data.uri);
                        $('.upload-progress-container').hide();
                        $('.cancle-upload-button').hide();
                        $('.file-qr').html("<img src='/src/html/qr.php?fid="+data.uri+"'>");
                        $('.file-qr').show();
                        $('#file-uri').val('https://shareli.me/?'+data.uri);
                        $('.file-uri').show();
                    }
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
