<div class="container mt-5">
  <h4><?php _e('Send Email', 'test_email_plugin') ?></h4>
  <form id="send-email" autocomplete="off">
    <div class="mb-3">
      <label for="email_subject" class="form-label"><?php _e('Email Subject', 'test_email_plugin') ?></label>
      <input type="text" class="form-control" name="email_subject" id="email_subject" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
      <label for="email_content" class="form-label"><?php _e('Email Content', 'test_email_plugin') ?></label>
      <textarea class="form-control" id="email_content" name="email_content"> </textarea>
    </div>
    <div class="mb-3">
      <label for="send_to" class="form-label"><?php _e('Send To', 'test_email_plugin') ?></label>
      <input type="email" class="form-control" id="send_to" name="send_to">
    </div>
    <button type="submit" name="send" class="btn btn-primary btn-lg"><?php _e('Send', 'test_email_plugin') ?></button>
  </form>
  <div id="msg"></div>
</div>