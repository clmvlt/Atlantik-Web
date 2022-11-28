<table class="table">
  <thead>
    <tr>
      <th scope="col">Nom secteur</th>
      <th scope="col">Num Liaison</th>
      <th scope="col">Distance</th>
      <th scope="col">Port de départ</th>
      <th scope="col">Port d'arrivé</th>
    </tr>
  </thead>
  <tbody>
      <?php 
        foreach ($tableauSecteurLiaisons as $item) {
            echo "<tr><td>".$item->snom."</td>";
            echo "<td><a href='".site_url('Client/tarifLiaison/'.$item->noliaison)."'>".$item->noliaison."</a></td>";
            echo "<td>".$item->distance."</td>";
            echo "<td>".$item->pdepnom."</td>";
            echo "<td>".$item->parrnom."</td></tr>";
        }
      ?>
  </tbody>
</table>