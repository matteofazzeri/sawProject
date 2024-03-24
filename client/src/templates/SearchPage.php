<?
require __DIR__ . '/../libs/help_func.php';

display("Navbar", false);

?>
<main class="page">
  <aside class="products-filter"></aside>
  <section id="searched-elem" class="show-4-grid">
    <script>
      const p = new ProductAPI("http://localhost/server/sawProject/server/api/");
      p.renderProductCards("searched-elem");
    </script>
  </section>


</main>

<?php
require __DIR__ . '/../components/Footer.php';