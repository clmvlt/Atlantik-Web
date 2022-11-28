<?php
  echo validation_errors(); // mise en place de la validation

  echo form_open('visiteur/login');
  // creation d'un label devant la zone de saisie
  echo form_label('Mail','txtMail');
  echo form_input('txtMail', set_value('txtMail'));    
 
  echo form_label('Mot de passe','txtPw');
  echo form_password('txtPw', set_value('txtPw'));    
 
  echo form_submit('submit', 'Se connecter');
  echo form_close();
?>