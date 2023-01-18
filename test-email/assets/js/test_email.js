jQuery(document).ready(function () {
   
    // var test_email = {
    //     init:function(){
    //         this.init_events();
    //     },
    //     init_events:function(){
            jQuery('#send-email').submit(function (e) {
                e.preventDefault();
                subject = jQuery('#email_subject').val();
                content =  jQuery('#email_content').val();
                to = jQuery('#send_to').val();
                console.log(subject);
                jQuery.ajax({
                    url: myscript.ajaxurl,
                    method: 'post',
                    data: {action: "emaildata", "subject": subject, "content":content, "to": to, "security": myscript.my_script_nonce},
                    success: function(result) {
                        jQuery('#msg').html(result);
                    }
                })
        })
        // }
    // };
    // test_email.init();
});