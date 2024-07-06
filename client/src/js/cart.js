class Cart {
  constructor(productAPI) {
    this.productAPI = productAPI;
  }

  async addProductToCart(product, quantity) {
    const body_message = {
      elem_id: product,
      uuid: localStorage.getItem("uuid") || null,
      n_elem: quantity,
    };

    const response = await fetch(`${backendUrl.development}c`, {
      method: "POST",

      body: JSON.stringify(body_message),
    });

    if (!response.ok) {

      if (response.status === 401) {
        window.location.href = "login";
      } else if (response.status === 409) {
        document.getElementById(product + "-error").innerHTML = "Errore: Quantità non disponibile";
      } else {
        throw new Error(`HTTP error! status: ${response.status}`);
      }



      throw new Error(`HTTP error! status: ${response.status}`);
    }
  }

  async addToCart(e) {
    const card = e.closest('.elem');
    const quantity_id = "add-" + card.id;
    const quantity = document.getElementById(quantity_id);
    const clean_quantity = quantity.textContent.replace("Quantity: ", "");

    await this.addProductToCart(card.id, clean_quantity);


    const okBTN = document.getElementById(card.id + "saveNQ");
    okBTN !== null ? okBTN.style.display = "none" : null;

    // location.reload();
  }

  increment_value(e) {
    const card = e.closest('.elem');
    const quantity_id = "add-" + card.id;
    const quantity = document.getElementById(quantity_id);
    let clean_quantity = quantity.textContent.replace("Quantity: ", "");

    const okBTN = document.getElementById(card.id + "saveNQ");
    okBTN !== null ? okBTN.style.display = "block" : null;

    clean_quantity -= 0; // this convert the string to number
    clean_quantity += 1;

    quantity.innerHTML = "Quantity: " + clean_quantity;
  }

  decrement_value(e) {
    const card = e.closest('.elem');
    const quantity_id = "add-" + card.id;
    const quantity = document.getElementById(quantity_id);
    let clean_quantity = quantity.textContent.replace("Quantity: ", "");

    const okBTN = document.getElementById(card.id + "saveNQ");
    okBTN !== null ? okBTN.style.display = "block" : null;

    clean_quantity -= 0; // this convert the string to number
    if (clean_quantity - 1 >= 1) clean_quantity -= 1;

    quantity.innerHTML = "Quantity: " + clean_quantity;
  }

  async downloadCart() {
    const response = await fetch(`${backendUrl.development}c?uuid=${localStorage.getItem("uuid") || null}`, {
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
      uuid: localStorage.getItem("uuid") || null,
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

    if (localStorage.getItem("uuid") === null) {
      loaders.hide("loader-" + id_div);
      document.getElementById(id_div).innerHTML = "<h1>You must be logged in to view your cart</h1><p>Redirecting you to login page...</p>";
      document.getElementById(id_div).style.display = "flex";

      setTimeout(function () {
        window.location.href = "login";
      }, 3000);

      return 401;
    }

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
                <h1 class="product-title"><a href="${product.product_id}/${product.product_name.replace(/ /g, "-")}?eid=${product.product_id}">${product.product_name}</a></h1>
                <div class="product-rating">Rating: ${product.product_rating}</div>
                <span>
                  <div class="quantity-selector">
                    <button onclick="c.decrement_value(this)">
                      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                        <path d="M200-440v-80h560v80H200Z" />
                      </svg>
                    </button>
                    <p id="add-${product.product_id}">Quantity: ${product.quantity}</p>
                    <button onclick="c.increment_value(this)">
                      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                        <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" />
                      </svg>
                    </button>
                  </div>
                    
                  <button id="${product.product_id}saveNQ" class="saveNQ" onclick="c.addToCart(this)" >OK</button>

                  ${product.product_quantity <= 0 ? "<p style='color: red'> no product</p>" : product.product_quantity < 10 ?
              `<p style='color: orange'>Prodotti rimasti: ${product.product_quantity}</p>` : `<p style='color: green'>Disponibilità immediata</p>`
            }

                  <div class="cart-elem-option">
                    <button onclick="c.removeProductFromCart(this)">Rimuovi</button>
                    <button>Salva per dopo</button>
                    <button>Condividi</button>
                  </div>
                </span>
                <p class="error" id="${product.product_id}-error"></p>
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
      document.getElementById(id_div + "-total").innerHTML = `Totale (${numItems} articoli): <b>${total.toFixed(2)}€</b> `;
    }
  }
}

class Checkout extends Cart {


  async renderCheckout() {
    if (await this.renderCart("checkout") === 404) {
      window.location.href = "cart";
    } else if (await this.renderCart("checkout") === 401) {
      window.location.href = "login";
    }

    Array.from(document.getElementsByClassName("cart-elem-option")).forEach(function (item) {
      item.style.display = "none";
    });
  }

  async completeCheckout() {

    document.getElementById("checkout").innerHTML = '<span id="loader-checkout" class="loader"></span>';

    loaders.show("loader-checkout", "bubble", "Completing checkout...");


    const body_message = {
      uuid: localStorage.getItem("uuid") || null,
    };

    const response = await fetch(`${backendUrl.development}c/checkout`, {
      method: "POST",
      body: JSON.stringify(body_message),
    });

    if (!response.ok) {
      /* document.getElementById("checkout").innerHTML = response.status + " - " +response.statusText; */

      if (response.status === 409) {
        loaders.show("loader-checkout", "bubble", "Checkout Failed! Redirecting to the cart...");
        setTimeout(function () {
          window.location.href = "cart";
        }, 3000);
      }
      loaders.hide("loader-checkout");
      window.location.href = "cart";
      throw new Error(`HTTP error! status: ${response.status}`);
    } else {
      loaders.show("loader-checkout", "bubble", "Checkout completed! Redirecting to home page...");
    }

    setTimeout(function () {
      window.location.href = "";
    }, 3000);

  }
}