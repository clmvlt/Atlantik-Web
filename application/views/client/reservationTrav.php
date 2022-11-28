<div class="row">
<div class="col-2"></div>
<div class="col-8">
<?php 
if (!isset($travInfo) || !isset($userInfo)) redirect(site_url('Welcome/index'));

echo validation_errors(); // mise en place de la validation
echo form_open('Client/ReservationTrav/'.$travInfo->notraversee);

echo "<p>$travInfo->pdepnom - $travInfo->parrnom<br/>Traversée n°$travInfo->notraversee le $travInfo->dateheuredepart<br/>Saisir les informations relatives à la réservation</p><br/>";
echo "<p>Nom : $userInfo->nom $userInfo->prenom<br/>Adresse : $userInfo->adresse<br/>Code postal : $userInfo->codepostal, Ville : $userInfo->ville</p><br/><br/>";

echo "<table class='table table-bordered'>
<thead><tr><th>Catégorie</th><th>Tarifs</th></tr></thead>
";
foreach ($tarifs as $item) {
    echo "<tr><td>$item->libelle</td><td>$item->tarif</td><td>".form_input($item->lettrecategorie.';'.$item->notype, set_value($item->lettrecategorie.';'.$item->notype))."</td></tr>";
}

echo "</table>";
echo form_submit('submit', 'Réserver');
echo form_close();
?>
</div>
<div class="col-2"></div>
</div>