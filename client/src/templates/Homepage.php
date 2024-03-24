<main class="homepage">
  <section id="">
    <div class="last-added">
      <h3 class="">Last Added</h3>
      <span id="last-added-row" class="elems-seq">
        <script>
          console.log("ciao")
          const p = new ProductAPI("http://localhost/server/sawProject/server/api/");
          p.renderProductCards("last-added-row");
        </script>
      </span>
    </div>

    <div class="wishlist">
      <h3 class="">From your wishlist</h3>
      <span id="wishlist-row" class="elems-seq">

        <div class="elem"><img src="" alt="elem"></div>
        <div class="elem"><img src="" alt="elem"></div>
        <div class="elem"><img src="" alt="elem"></div>
        <div class="elem"><img src="" alt="elem"></div>
        <div class="elem"><img src="" alt="elem"></div>
        <div class="elem"><img src="" alt="elem"></div>
        <div class="elem"><img src="" alt="elem"></div>
        <div class="elem"><img src="" alt="elem"></div>
        <div class="elem"><img src="" alt="elem"></div>
        <div class="elem"><img src="" alt="elem"></div>
        <div class="elem"><img src="" alt="elem"></div>
      </span>
    </div>

    <div class="most-sold">
      <h3 class="">Most sold</h3>
      <span id="most-sold-row" class="elems-seq">
        <div class="elem"><img src="" alt="elem"></div>
        <div class="elem"><img src="" alt="elem"></div>
        <div class="elem"><img src="" alt="elem"></div>
        <div class="elem"><img src="" alt="elem"></div>
        <div class="elem"><img src="" alt="elem"></div>
        <div class="elem"><img src="" alt="elem"></div>
        <div class="elem"><img src="" alt="elem"></div>
        <div class="elem"><img src="" alt="elem"></div>
        <div class="elem"><img src="" alt="elem"></div>
        <div class="elem"><img src="" alt="elem"></div>
        <div class="elem"><img src="" alt="elem"></div>
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