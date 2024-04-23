<main class="page">
  <aside class="products-filter"></aside>
  <section class="elem-section">
    <span id="loader-searched-elem">

    </span>
    <div id="searched-elem" class="show-row-4">
      <script>
        let params = new URLSearchParams(window.location.search);
        let page = params.get('page');
        const p = new Pagination(8, 'searched-elem', page);
        p.loadItems();
      </script>
    </div>
    <?php
    display("Pagination");
    ?>
  </section>

</main>