class ProductAPI {
  constructor(
    page = 1,
  ) {
    this.currentPage = page;
    this.numItems = 8;
    this.searchElem = new URLSearchParams(window.location.search).get('k') === null ?
      ""
      :
      new URLSearchParams(window.location.search).get('k');
  }

  async renderProductCards(id_div) {
    loaders.show("loader-" + id_div, 'search');

    document.getElementById(id_div).style.display = "none";

    //! to delete
    //await new Promise(r => setTimeout(r, 2000));

    const timeout = new Promise((resolve, reject) => {
      setTimeout(reject, 1000, 'Request timed out');
    });

    let data;
    try {
      data = await Promise.race([this.downloadProduct(), timeout]);
    } catch (error) {
      console.error(error);
      loaders.hide("loader-" + id_div);
      document.getElementById(id_div).innerHTML = "<h1>Error loading products</h1>";
      document.getElementById(id_div).style.display = "flex";
      return;
    }

    if (Array.isArray(data) && data.length === 0) {
      loaders.hide("loader-" + id_div);
      document.getElementById(id_div).innerHTML = "<h1>No products found</h1>";
      document.getElementById(id_div).style.display = "flex";
    }
    else {
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
      document.getElementById(id_div).style.display = "flex";
    }
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
      `${backendUrl.development}/s?k=${this.searchElem}&page=${this.currentPage}&nElem=${this.numItems}`
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


class searchProduct extends ProductAPI {
  constructor() {
    super();
  }

  changeSearch = (e) => {
    const search_input = document.querySelector("input").value;
  }

  search = () => {
    const search_input = encodeURIComponent(document.querySelector("input").value);
    console.log(search_input)

    window.location.href = `http://localhost/sawProject/client/search?k=${search_input}`;

  }
}