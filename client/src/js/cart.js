class Cart {
  constructor(productAPI) {
    this.productAPI = productAPI;
  }

  async addProductToCart(product, quantity) {
    const body_message = {
      elem_id: product,
      uuid: localStorage.getItem("uuid") || "1",
      n_elem: quantity,
    };

    const response = await fetch(`${backendUrl.development}c`, {
      method: "POST",

      body: JSON.stringify(body_message),
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
  }

  async addToCart(e) {
    const card = e.closest('.elem');
    const quantity_id = "add-" + card.id;
    const quantity = document.getElementById(quantity_id);
    const clean_quantity = quantity.textContent.replace("Quantity: ", "");

    await this.addProductToCart(card.id, clean_quantity);

    document.getElementById(card.id + "saveNQ").style.display = "none";

    // location.reload();
  }

  increment_value(e) {
    const card = e.closest('.elem');
    const quantity_id = "add-" + card.id;
    const quantity = document.getElementById(quantity_id);
    let clean_quantity = quantity.textContent.replace("Quantity: ", "");

    document.getElementById(card.id + "saveNQ").style.display = "block";

    clean_quantity -= 0; // this convert the string to number
    clean_quantity += 1;

    quantity.innerHTML = "Quantity: " + clean_quantity;
  }

  decrement_value(e) {
    const card = e.closest('.elem');
    const quantity_id = "add-" + card.id;
    const quantity = document.getElementById(quantity_id);
    let clean_quantity = quantity.textContent.replace("Quantity: ", "");
    document.getElementById(card.id + "saveNQ").style.display = "block";

    clean_quantity -= 0; // this convert the string to number
    if (clean_quantity - 1 >= 1) clean_quantity -= 1;

    quantity.innerHTML = "Quantity: " + clean_quantity;
  }

  async downloadCart() {
    const response = await fetch(`${backendUrl.development}c?uuid=${localStorage.getItem("uuid") || "1"}`, {
      method: "GET",
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    return await response.json();
  }

  async removeProductFromCart(product) {
    const card = product.closest('.elem');

    console.log("deleting " + card.id + "...");

    const body_message = {
      prod_id: card.id,
      uuid: localStorage.getItem("uuid") || "1",
    };

    const response = await fetch(`${backendUrl.development}c`, {
      method: "DELETE",

      body: JSON.stringify(body_message),
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    await location.reload();
  }

  async renderCart(id_div) {

    loaders.show("loader-" + id_div, "search");

    const timeout = new Promise((resolve, reject) => {
      setTimeout(reject, 1000, 'Request timed out');
    });

    let data;
    var total = 0;
    var numItems = 0;

    try {
      data = await Promise.race([this.downloadCart(), timeout]);
    } catch (error) {
      console.error(error);
      loaders.hide("loader-" + id_div);
      document.getElementById(id_div).innerHTML = "<h1>Error loading products</h1>";
      document.getElementById(id_div).style.display = "flex";
      return 500;
    }

    if (Array.isArray(data) && data.length === 0) {
      loaders.hide("loader-" + id_div);
      document.getElementById(id_div).innerHTML = "<h1>No products found</h1>";
      document.getElementById(id_div).style.display = "flex";
      return 404;
    } else if (data['page'] === "0") {
      return -1;

    } else {
      var productHTML = data
        .map(function (product) {
          total += product.product_price * product.quantity;
          numItems += product.quantity;
          return `
            <div class="cart-item elem" id="${product.product_id}">
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
                  <button id="add-${product.product_id}">Quantity: ${product.quantity}</button>
                  <button onclick="c.increment_value(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                      <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" />
                    </svg>
                  </button>
                  <button id="${product.product_id}saveNQ" class="saveNQ" onclick="c.addToCart(this)" >OK</button>
                  <button onclick="c.removeProductFromCart(this)">Rimuovi</button>
                  <button>Salva per dopo</button>
                  <button>Condividi</button>
                </span>
              </div>
              <div>
                <span id="item-price"><b>${product.product_price} €</b></span>
              </div>
            </div>
          `;
        })
        .join("");

      loaders.hide("loader-" + id_div);
      document.getElementById(id_div).innerHTML = productHTML;
      document.getElementById(id_div).style.display = "flex";
      document.getElementById(id_div + "-total").innerHTML = `Totale provvisorio (${numItems} articoli): <b>${total.toFixed(2)}€</b> `;
    }

  }

}

class Checkout extends Cart {


  async renderCheckout() {
    if (await this.renderCart("checkout") === 404) {
      window.location.href = "cart";
    }
  }

  async completeCheckout() {
    console.log("done");

    const body_message = {
      uuid: localStorage.getItem("uuid") || "1",
    };

    const response = await fetch(`${backendUrl.development}c/checkout`, {
      method: "POST",

      body: JSON.stringify(body_message),
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    

  }

}