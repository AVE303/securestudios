<div id="content">
  <div id="inner-content">
    <h1>CMS Secure Studios</h1><br />
    <?php 
    
    if($this->session->flashdata('message_login')){
      echo '<div class="message">'.$this->session->flashdata('message_login').'</div>';
    }
    ?>
    <div id="login_form">
      <h1>Inloggen AUB!</h1>
      <?php
      echo form_open('login/validate_credentials').PHP_EOL;
      echo form_label('Gebruikersnaam', 'name').PHP_EOL;
      echo form_input('name', '', 'id="name"').PHP_EOL;
      echo form_label('Wachtwoord', 'password').PHP_EOL;
      echo form_password('password', '', 'id="password"').PHP_EOL;
      echo form_submit('submit', 'Login').PHP_EOL;
      echo form_close().PHP_EOL;
      ?>
    </div>