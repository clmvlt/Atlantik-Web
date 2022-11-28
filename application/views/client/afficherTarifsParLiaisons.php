
<?php 
        foreach ($tabTarifs as $item) {
            echo $item->noperiode." ".$item->noliaison." ".$item->datedebut." ".$item->datefin." ".$item->lettrecategorie." ".$item->notype." ".$item->libelle."<br/>";
        }
      ?>