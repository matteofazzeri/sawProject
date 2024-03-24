

<nav class="global-navbar">
  <span>
    <div class="navbar-search-select">
      <select class="w-fit h-full rounded-l-md bg-gray-500/40 outline-none overflow-auto">
        <option value="all">all</option>
        <option value="all">Ship</option>
      </select>
    </div>
    <input id="search-input" class="w-full border pl-1 pr-4 py-2 focus:border-blue-500 focus:outline-none focus:shadow-outline" type="text" placeholder="Search" onkeypress="changeSearch(this)">
    <span class="w-12 flex items-center justify-center rounded-r-md bg-gray-500/40">
      <svg class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none">
        <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
    </span>
  </span>
</nav>

<script>
  const changeSearch = (e) => {
    console.log(e.value);
    const search_input = document.querySelector("input").value;
    console.log(search_input)
  }
</script>