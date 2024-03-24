
<main class="page">
  <aside class="products-filter"></aside>
  <section id="searched-elem" class="show-row-4">
    <script>
      const p = new ProductAPI("http://localhost/server/sawProject/server/api/");
      p.renderProductCards("searched-elem");
    </script>
  </section>


</main>