<div class="container mt-5">
    <h4>Send Email</h4>
<form id="send-email">
  <div class="mb-3">
    <label for="email_subject" class="form-label">Email Subject</label>
    <input type="text" class="form-control" name="email_subject" id="email_subject" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="email_content" class="form-label">Email Content</label>
    <textarea class="form-control" id="email_content" name="email_content"> </textarea>
  </div>
  <div class="mb-3">
    <label for="send_to" class="form-label">Send To</label>
    <input type="email" class="form-control" id="send_to" name="send_to">
  </div>
  <button type="submit" name="send" class="btn btn-primary btn-lg">Send</button>
</form>
<div id="msg"></div>
</div>