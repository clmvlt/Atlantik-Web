    <div class="col-8">
        <div class="list-group">
            <?php 
            $liaisons = array();
            foreach ($tabLiaisons as $item) {
                $liaisons[$item->noliaison] = $item->pdep." - ".$item->parr;
            }

            $periodes = array();
            foreach ($tabPeriodes as $item) {
                $periodes[$item->datedebut] = $item->datedebut." - ".$item->datefin;
            }
            echo form_open('Client/horrairesTravs/'.$nosecteur);

            echo form_dropdown('ddLiaisons', $liaisons, 'default');
            echo form_dropdown('ddPeriodes', $periodes, 'default');
            echo form_hidden('nosecteur', $nosecteur);
            
            echo form_submit('submit', 'Afficher');
            echo form_close();

            if (isset($tabTarifsTravs)) {
                foreach ($tabTarifsTravs as $item) {
                    echo $item."<br/>";
                }
            }
                
            ?>
        </div>
    </div>
</div>