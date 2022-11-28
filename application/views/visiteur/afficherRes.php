<?php 
    foreach ($tabRes as $item) {
        echo $item->noreservation." | ".$item->dateheure." | ".$item->pdepnom." | ".$item->parrnom." | ".$item->dateheuredepart." | ".$item->montanttotal." | ".$item->paye."<br/>";
    }  
?>
<p><?php echo $liensPagination; ?></p>