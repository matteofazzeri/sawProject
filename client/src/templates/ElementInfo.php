<?php $eid = $_GET['eid'] ?>

<main class="element-page">
  <script>
    window.onload = function() {
      const elem = new ProductAPI();
      elem.fillElemPage();
    }
  </script>
  <section class="elem" id=<?php echo $eid ?>>
    <!-- Immagini del prodotto | titolo, descrizione, presso, recensione | area per comprare/aggiungere al carello -->
    <div id="elem-images"></div>

    <div class="elem-info">
      <h1 id="elem-title"></h1>
      <div class="elem-mark">
        <div id="elem-stars"></div>
        <a href="#review" id="n-votes">100 Voti</a>
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
      <div>Invia a Address</div>
      <h3>Disponibilità Immediata</h3>
      <div class="select-quantity">
        <button id="" onclick="c.decrement_value(this)">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
            <path d="M200-440v-80h560v80H200Z" />
          </svg>
        </button>
        <p id=<?php echo "add-" . $eid ?>>Quantity: 1</p>
        <button onclick="c.increment_value(this)">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
            <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" />
          </svg>
        </button>


      </div>

      <button onclick="c.addToCart(this)" class="add-to-cart">Add to cart</button>
    </div>
  </section>
  <section>
    <!-- Spesso comprati assieme -->
  </section>
  <section>
    <!-- Prodotti correlati a questo articolo -->
  </section>
  <section class="review">
    <!-- Recensioni -->

    <div class="review-form">
      <h2>Make a Review</h2>
      <form id="review-form" onsubmit="r.addReview(event)">
        <div class="title">
          <label for="review-title">Title</label>
          <input type="text" id="review-title" name="review-title" class="rev-title" required>
        </div>

        <!-- Star rating inputs -->

        <div>
          <input class="star star-5" id="star-5-2" type="radio" name="star" value="5" />
          <label class="star star-5" for="star-5-2"></label>

          <input class="star star-4" id="star-4-2" type="radio" name="star" value="4" />
          <label class="star star-4" for="star-4-2"></label>

          <input class="star star-3" id="star-3-2" type="radio" name="star" value="3" />
          <label class="star star-3" for="star-3-2"></label>

          <input class="star star-2" id="star-2-2" type="radio" name="star" value="2" />
          <label class="star star-2" for="star-2-2"></label>

          <input class="star star-1" id="star-1-2" type="radio" name="star" value="1" />
          <label class="star star-1" for="star-1-2"></label>

        </div>
        <span id="star-err" class="invalid"></span>

        <div class="rev-box">
          <textarea id="review-text" class="review" cols="30" rows="5" name="review" placeholder="Brief Review"></textarea>
        </div>

        <button type="submit" class="review-btn loader" id="post-rev-btn">Submit</button>
      </form>
    </div>


    <div class="review-list">
      <h2>Recensioni</h2>
      <div id="review"></div>
    </div>

  </section>
</main>