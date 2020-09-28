<?php
include_once 'utils/php/design/header.php';
include_once 'utils/php/session/session.php';
include_once 'utils/php/session/database.php';
?>
<script>
    let tab = document.querySelector("#contact");
        tab.setAttribute('class', 'on');
</script>

  <div id="content">
    <h2>Contact</h2>
    <p>This doesn't really work xd</p>
    <fieldset>
    <legend>Contact form</legend>
    <form method="post" action="#">
      <p>
        <label for="name">Name: </label>
        <input type="text" name="name" id="name" />
      </p>
      <p>
        <label for="email">Email: </label>
        <input type="text" name="email" id="email" />
      </p>
      <p>
        <label for="subject">Subject: </label>
        <select name="subject" id="subject">
          <option>Enquiry</option>
          <option>Support</option>
          <option>Site bug</option>
        </select>
      </p>
      <p>
        <label for="message">Message: </label>
        <textarea name="message" id="message" cols="40" rows="10"></textarea>
      </p>
      <p>
        <label>&nbsp;</label>
        <input type="submit" value="Send" class="btn" />
      </p>
    </form>
    </fieldset>
  </div>
</div>
<?php
include_once 'utils/php/design/footer.php';
?>
