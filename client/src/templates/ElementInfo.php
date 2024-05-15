<main>
  <section id="elem-info">
    <!-- Immagini del prodotto | titolo, descrizione, presso, recensione | area per comprare/aggiungere al carello -->
    <div id="elem-image"><!-- Image --></div>
    <div id="elem-description"></div>
    <div>
      <span>19.99$</span>
      <p>Consegna senza costi aggiuntivi
        
      <?php 
        $now = new DateTime('Europe/Rome');
        $midnight = new DateTime('20:00:00');
        $diff = $now->diff($midnight);
        echo $diff->format('%H:%I:%S');


      ?>
      
      Maggiori informazioni</p>
    </div>
  </section>
  <section>
    <!-- Spesso comprati assieme -->
  </section>
  <section>
    <!-- Prodotti correlati a questo articolo -->
  </section>
  <section>
    <!-- Recensioni -->
  </section>
</main>