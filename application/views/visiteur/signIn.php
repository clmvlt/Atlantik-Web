<div class="d-flex justify-content-center">
  <div class="row">
    <div class="col-2"></div>
    <div class="col-8">
      <?php echo validation_errors(); ?>
    </div>
    <div class="col-2"></div>
  </div>
  <div class="row">
    <div class="col-1"></div>
    <div class="col-10">
      <?php
        echo form_open('visiteur/signIn');
        // creation d'un label devant la zone de saisie
        echo form_label('Mail ','txtMail');
        echo "<br/>";
        echo form_input('txtMail', set_value('txtMail'));    
        echo "<br/>";
        echo form_label('Mot de passe ','txtPw');
        echo "<br/>";
        echo form_password('txtPw', set_value('txtPw'));   
        echo "<br/>";
        echo form_label('Tel ','txtTel');
        echo "<br/>";
        echo form_input('txtTel', set_value('txtTel')); 
        echo "<br/>";
        echo form_label('Tel. Fixe ','txtTelFixe');
        echo "<br/>";
        echo form_input('txtTelFixe', set_value('txtTelFixe')); 
        echo "<br/>";
        echo form_label('Nom','txtNom');
        echo "<br/>";
        echo form_input('txtNom', set_value('txtNom'));   
        echo "<br/>";
        echo form_label('Prenom','txtPnom');
        echo "<br/>";
        echo form_input('txtPnom', set_value('txtPnom'));   
        echo "<br/>";
        echo form_label('Adresse','txtAd');
        echo "<br/>";
        echo form_input('txtAd', set_value('txtAd'));   
        echo "<br/>";
        echo form_label('Code Postal','txtCodpost');
        echo "<br/>";
        echo form_input('txtCodpost', set_value('txtCodpost'));   
        echo "<br/>";
        echo form_label('Ville','txtVille');
        echo "<br/>";
        echo form_input('txtVille', set_value('txtVille'));   
        echo "<br/>";
        echo form_submit('submit', 'Créer');
        echo form_close();
      ?>
    </div>
    <div class="col-1"></div>
  </div>
</div>