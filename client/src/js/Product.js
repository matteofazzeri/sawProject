class ProductAPI {
  constructor(
  ) {
    this.currentPage = 1;
    this.numItems = 8;
    this.searchElem = new URLSearchParams(window.location.search).get('k') === null ?
      ""
      :
      new URLSearchParams(window.location.search).get('k');
  }

  async renderProductCards(id_div, currentPage) {
    this.currentPage = currentPage;
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
    } else if (data['page'] === "0") {
      return -1;

    }
    else {
      var productHTML = data
        .map(function (product) {
          return `
            <div class="product-card elem" id="${product.product_id}">
                <div class="image">
                  <img src="${product.product_image}" alt="${product.product_name}" class="product-image">
                </div>
                <div class="details">
                    <h1 class="product-title"><a href="${product.product_id}/${product.product_name.replace(/ /g, "-")}?id=${product.product_id}">${product.product_name}</a></h1>
                    <div class="product-rating">Rating: ${product.product_rating}</div>
                    <span>
                      <button onclick="c.decrement_value(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                          <path d="M200-440v-80h560v80H200Z" />
                        </svg>
                      </button>
                      <button onclick="c.addToCart(this)" id="add-${product.product_id}">Quantity: 1</button>
                      <button onclick="c.increment_value(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                          <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" />
                        </svg>
                      </button>
                    </span>
                    
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


  

  // Download product JSON
  async downloadProduct() {
    const response = await fetch(
      `${backendUrl.development}s?k=${this.searchElem}&page=${this.currentPage}&nElem=${this.numItems}`
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

  async fillElemPage() {
    const url = new URL(window.location.href);
    const id = url.pathname.split('/')[3];
    const response = await fetch(`${backendUrl.development}e?eid=${id}`);

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = (await response.json())[0];

    document.getElementById("elem-price").innerHTML = data['product_price'] + "$";
    document.getElementById("elem-title").innerHTML = data['product_name'];
    document.getElementById("elem-description").innerHTML = data['product_description'];
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