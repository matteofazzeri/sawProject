class Pagination {
  constructor(itemsPerPage = 16, id_div, cur_page = 1) {
    this.itemsPerPage = itemsPerPage;
    this.currentPage = cur_page;
    this.div = id_div;
  }

  // Fetch items for the current page
  async loadItems() {
    const Prod = new ProductAPI(this.itemsPerPage, this.currentPage);
    if(await Prod.renderProductCards(this.div) === -1){
      console.log("finish");
      this.previousPage();
    }
  }

  // Go to the next page
  nextPage() {
    // Get the current URL and its search parameters
    let url = new URL(window.location.href);
    let params = url.searchParams;
    params.set('page', ++this.currentPage);

    // Update the URL with the new search parameters
    url.search = params.toString();

    // Redirect to the updated URL
    window.location.href = url.toString();
  }

  // Go to the previous page
  previousPage() {
    if (this.currentPage > 1) {
      this.currentPage--;
    }
    // Get the current URL and its search parameters
    let url = new URL(window.location.href);
    let params = url.searchParams;
    params.set('page', this.currentPage);

    // Update the URL with the new search parameters
    url.search = params.toString();

    // Redirect to the updated URL
    window.location.href = url.toString();
  }

  // Go to a specific page
  goToPage(page) {
    this.currentPage = page;
    return this.loadItems();
  }

  setPagination() {

  }
}
