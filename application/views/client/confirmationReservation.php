<h1>Réservation confirmée</h1>
<?php 

foreach ($tabQuantiteRes as $key => $value) {
    if ($value != null)
        echo "$key : $value<br/>";
}
echo "<br/>Total : $montant €";

?>