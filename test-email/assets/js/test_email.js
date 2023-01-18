jQuery(document).ready(function () {
    jQuery('#send-email').validate({
        rules: {
            email_subject: {
                required: true
            },
            email_content: {
                required: true,
            },
            send_to: {
                required: true,
            }
        },
        messages: {
            email_subject: {
                required: "Please Enter subjec!!",
            },
            email_content: {
                required: "Please Enter content",
            },
            send_to: {
                required: "Please Enter Email address!!",
            }
        }
    })
    jQuery('#send-email').submit(function (e) {
        e.preventDefault();
        if (jQuery('#send-email').valid()) {
            subject = jQuery('#email_subject').val();
            content = jQuery('#email_content').val();
            to = jQuery('#send_to').val();
            console.log(subject);
            jQuery.ajax({
                url: myscript.ajaxurl,
                method: 'post',
                data: { action: "emaildata", "subject": subject, "content": content, "to": to, "security": myscript.my_script_nonce },
                success: function (result) {
                    jQuery('#send-email')[0].reset();
                    jQuery('#msg').html(result);
                }
            })
        }

    })
});