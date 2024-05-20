<main class="element-page">
  <script>
    window.onload = function() {
      fillElemPage();
    }
  </script>
  <section class="elem">
    <!-- Immagini del prodotto | titolo, descrizione, presso, recensione | area per comprare/aggiungere al carello -->
    <div id="elem-images"><!-- Image --></div>

    <div class="elem-info">
      <h1 id="elem-title"><!-- Image --></h1>
      <div class="elem-mark">
        <div id="elem-stars">

        </div>
        <p id="n-votes">100</p>
      </div>

      <h4 id="elem-description"></h4>
    </div>


    <div class="box-outer">
      <span id="elem-price"></span>
      <p>Consegna senza costi aggiuntivi
        <?php
        $currentTimestamp = time();
        $targetTimestamp = mktime(21, 0, 0);
        $remainingSeconds = $targetTimestamp - $currentTimestamp;
        $remainingHours = floor($remainingSeconds / 3600);
        $remainingMinutes = floor(($remainingSeconds % 3600) / 60);

        if ($remainingHours > 0) {
          echo "<b>domani</b>. Ordina entro ";
          echo $remainingHours . " ore e " . $remainingMinutes . " min.";
        } else {
          echo "<b>dopo domani</b>. Ordina entro ";
          echo -$remainingHours + 21 . " ore e " . -$remainingMinutes . " min.";
        }
        ?>

        <a href="">Maggiori informazioni</a>
      </p>
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