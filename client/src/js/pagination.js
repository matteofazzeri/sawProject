class Pagination {
  constructor(baseURL, itemsPerPage) {
    this.baseURL = baseURL;
    this.itemsPerPage = itemsPerPage;
    this.currentPage = 1;
  }

  // Fetch items for the current page
  async fetchItems() {
    const response = await fetch(
      `${this.baseURL}?page=${this.currentPage}&page=${this.itemsPerPage}`
    );

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    return response.json();
  }

  // Go to the next page
  nextPage() {
    this.currentPage++;
    return this.fetchItems();
  }

  // Go to the previous page
  previousPage() {
    if (this.currentPage > 1) {
      this.currentPage--;
    }
    return this.fetchItems();
  }

  // Go to a specific page
  goToPage(page) {
    this.currentPage = page;
    return this.fetchItems();
  }
}
