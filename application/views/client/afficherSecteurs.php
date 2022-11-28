<div class="row">
    <div class="col-4">
        <div class="list-group">
            <?php 
                foreach ($tabSecteurs as $item) {
                    if ($item->nosecteur == $nosecteur) {
                        echo "<a href='".site_url('/Client/horrairesTravs/'. $item->nosecteur)."' class='list-group-item list-group-item-action active'>$item->nom</a>";
                    } else {
                        echo "<a href='".site_url('/Client/horrairesTravs/'. $item->nosecteur)."' class='list-group-item list-group-item-action'>$item->nom</a>";
                    }

                }
            ?>
        </div>
    </div>