<main class="page">
  <aside class="products-filter"></aside>
  <section class="elem-section">
    <span id="loader-searched-elem" class="loader"></span>
    <div id="searched-elem" class="show-row-4">
      <script>
        let params = new URLSearchParams(window.location.search);
        let page = params.get('p');
        const search_input = params.get('s');
        const p = new Pagination('searched-elem');
        p.loadItems();
      </script>
    </div>
    <?php
    display("Pagination");
    ?>
  </section>

</main>