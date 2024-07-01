<main class="homepage">
  <section id="">
    <div class="last-added">
      <h3 class="">Last Added</h3>
      <span id="last-added-row" class="elems-seq">
        <span id="loader-last-added-row" class="loader"></span>
        <script>
          const lap = new ProductAPI(10);
          lap.renderProductCards("last-added-row");
        </script>
      </span>
    </div>

    <div class="wishlist">
      <h3 class="">From your wishlist</h3>
      <span id="wishlist-row" class="elems-seq">
        <span id="loader-wishlist-row" class="loader"></span>
        <script>
          const wp = new ProductAPI(10);
          wp.renderProductCards("wishlist-row");
        </script>
      </span>
    </div>

    <div class="most-sold">
      <h3 class="">Most sold</h3>
      <span id="most-sold-row" class="elems-seq">
        <span id="loader-most-sold-row" class="loader"></span>
        <script>
          const msp = new ProductAPI(10);
          msp.renderProductCards("most-sold-row");
        </script>
      </span>
    </div>
  </section>


  <!-- 
    //? 1. Most sold
    //? 2. Last Added
    //? 3. From your wish list
    //? 4. Aggiungere controllo su elementi che visuallizza solo, ma che non ha nel carrello o nella lista dei desideri
   -->


</main>