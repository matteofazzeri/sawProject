class ProductAPI {
  constructor(numItems = 8, toRender = ""
  ) {
    this.currentPage = 1;
    this.numItems = numItems;
    this.searchElem = new URLSearchParams(window.location.search).get('k') === null ?
      ""
      :
      new URLSearchParams(window.location.search).get('k');

    this.toRender = toRender;
  }

  async renderProductCards(id_div, currentPage) {
    this.currentPage = currentPage;
    loaders.show("loader-" + id_div, 'search');

    document.getElementById(id_div).style.display = "none";

    const timeout = new Promise((resolve, reject) => {
      setTimeout(reject, 10000, 'Request timed out');
    });

    let data;

    try {
      data = await Promise.race([this.downloadProduct(), timeout]);
    } catch (error) {
      console.error(error);
      loaders.hide("loader-" + id_div);
      document.getElementById(id_div).innerHTML = `<h1>${error}</h1>`;
      document.getElementById(id_div).style.display = "flex";
      return;
    }



    if (Array.isArray(data) && data.length === 0) {
      loaders.hide("loader-" + id_div);
      document.getElementById(id_div).innerHTML = "<h1>No products found</h1>";
      document.getElementById(id_div).style.display = "flex";
    } else if (data === -1) {
      loaders.hide("loader-" + id_div);
      return -1;
    } else {
      var productHTML = data
        .map(function (product) {
          return `
            <div class="product-card elem" id="${product.product_id}">
              <div class="image">
                <img src="${product.product_image}" alt="${product.product_name}" class="product-image">
              </div>
              <div class="details">
                  <h1 class="product-title"><a href="${product.product_id}/${product.product_name.replace(/ /g, "-")}?eid=${product.product_id}">${product.product_name}</a></h1>
                  <div class="product-rating">Rating: ${product.product_rating}</div>
                  <span class="edit-quantity-elem" >
                    <button onclick="c.decrement_value(this)">
                      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                        <path d="M200-440v-80h560v80H200Z" />
                      </svg>
                    </button>
                    <p id="add-${product.product_id}" >Quantity: ${product.quantity}</p>
                    <button onclick="c.increment_value(this)">
                      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                        <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" />
                      </svg>
                    </button>
                    <button id="${product.product_id}saveNQ" class="saveNQ" onclick="c.addToCart(this)" >OK</button>
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
      `${backendUrl.development}s?k=${this.searchElem}&page=${this.currentPage}&nElem=${this.numItems}&uuid=${localStorage.getItem("uuid") || "1"}&x=${this.toRender}`,
      {
        method: "GET",
      }
    );

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    } else {
      if (response.status === 204)
        return -1;
      else
        return await response.json();
    }
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
    } else {
      return await response.json();
    }
  }

  async fillElemPage() {
    const url = new URL(window.location.href);
    const id = url.pathname.split('/')[3];
    const response = await fetch(`${backendUrl.development}e?eid=${id}&uuid=${localStorage.getItem("uuid") || "1"}`, {
      method: "GET",
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    } else {
      const data = (await response.json())[0];

      document.getElementById("elem-price").innerHTML = data['product_price'] + "$";
      document.getElementById("elem-title").innerHTML = data['product_name'];
      document.getElementById("elem-description").innerHTML = data['product_description'];
      document.getElementById("add-" + data['product_id']).innerHTML = "Quantity: " + data['quantity'];


      // document.getElementById("elem-rating").innerHTML = data['product_rating'];

      // render images of the product in the carousel
    }
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
    
    window.location.href = `http://localhost/sawProject/client/search?k=${search_input}`;
  }
}
