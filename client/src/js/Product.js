class ProductAPI {
  constructor(baseURL) {
    this.baseURL = baseURL;
  }

  renderProductCards(id_div) {
    const data = this.downloadProduct()
    var productHTML = data
      .map(function (product) {
        return `
                <div class="product-card">
                    <div class="image">
                        <img src="${
                          product.imageSrc
                        }" alt="${product.title}" class="product-image">
                    </div>
                    <div class="details">
                        <h1 class="product-title">${product.title}</h1>
                        <div class="product-rating">Rating: ${
                          product.rating
                        }</div>
                        <div class="product-tags">Tags: ${product.tags.join(
                          ", "
                        )}</div>
                        <p class="latest-comment">Latest Comment: ${
                          product.latestComment
                        }</p>
                    </div>
                </div>
            `;
      })
      .join("");

    document.getElementById(id_div).innerHTML = productHTML;
  }

  // Upload product JSON
  async uploadProduct(product) {
    const response = await fetch(`${this.baseURL}/products`, {
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
  async downloadProduct(productId) {
    const response = await fetch(`${this.baseURL}/products/${productId}`);

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    return response.json();
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
