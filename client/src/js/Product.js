class ProductAPI {
  constructor(
    elemPerPage = 8,
    page = 1,
    api,
  ) {
    this.currentPage = page;
    this.numItems = elemPerPage;
    this.apiURL = api;
  }

  async renderProductCards(id_div) {
    loaders.show("loader-" + id_div, 'circular');

    await new Promise(r => setTimeout(r, 2000));

    const data = await this.downloadProduct();

    if (!data || (Array.isArray(data) && data.length === 0)) {
      return -1;
    }
    var productHTML = data
      .map(function (product) {
        return `
                <div class="product-card">
                    <div class="image">
                        <img src="${product.product_image}" alt="${product.product_name}" class="product-image">
                    </div>
                    <div class="details">
                        <h1 class="product-title">${product.product_name}</h1>
                        <div class="product-rating">Rating: ${product.product_rating}</div>
                        
                        <div class="product-tags">Tags: ${product.tags && product.tags.length > 0 ? product.tags.join(", ") : "No tags available"}</div>
                        <p class="latest-comment">Latest Comment: Aggiungere ultimo commentoooooooo oooootjtjakoooooo oooooo ooooooooooloooooo oooooooooo ooooooooo oooooooo ooo oooooo oooooo oooooo o!</p>
                    </div>
                </div>
            `;
      })
      .join("");

    loaders.hide("loader-" + id_div);
    document.getElementById(id_div).innerHTML = productHTML;
  }

  // Upload product JSON
  async uploadProduct(product) {
    const response = await fetch(`${backendUrl.development}/p`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(product),
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    return response.json();
  }

  // Download product JSON
  async downloadProduct() {
    const response = await fetch(
      `${backendUrl.development}/s?page=${this.currentPage}&nElem=${this.numItems}`
    );

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    return await response.json();
  }

  // Edit product JSON
  async editProduct(productId, updatedProduct) {
    const response = await fetch(`${this.baseURL}/products/${productId}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(updatedProduct),
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    return response.json();
  }
}
