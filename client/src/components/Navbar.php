<nav class="global-navbar">
  <span class="search-bar-elem">
    <div class="navbar-search-select">
      <select class="">
        <option value="all">all</option>
        <option value="all">Ship</option>
      </select>
    </div>
    <script>
      const s = new searchProduct();
    </script>
    <form onsubmit="event.preventDefault(); s.search()">
      <input id="search-input" class="" type="text" placeholder="Search" onkeyup="s.changeSearch()">
    </form>
    <span class="search-btn" onclick="s.search()">
      <button onclick="s.search">
        <svg class="" viewBox="0 0 24 24" fill="none">
          <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </button>
    </span>
  </span>
</nav>