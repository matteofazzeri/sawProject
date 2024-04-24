<main class="page">
  <aside class="products-filter"></aside>
  <section class="elem-section">
    <span id="loader-searched-elem" class="loader"></span>
    <div id="searched-elem" class="show-row-4">
      <script>
        let params = new URLSearchParams(window.location.search);
        let page = params.get('p');
        const search_input = params.get('s');
        if (page === null) {
          page = 1;
        }
        if (search_input === null) {
          window.location.href = 'http://localhost/sawProject/client';
        }
        const p = new Pagination(8, 'searched-elem', page);
        p.loadItems();
      </script>
    </div>
    <?php
    display("Pagination");
    ?>
  </section>

</main>