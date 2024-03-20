class ProductAPI {
  constructor(baseURL) {
    this.baseURL = baseURL;
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
