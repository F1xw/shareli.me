$(document).ready(function () {
   function authSubmit(e) {
       e.preventDefault();
        if ($('.form-signin').parsley().validate()) {
            window.handleEvent();
        }
   }
});