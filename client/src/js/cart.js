class Cart {
  constructor(productAPI) {
    this.productAPI = productAPI;
  }

  async addProductToCart(product, quantity) {
    const body_message = {
      elem_id: product,
      uuid: "1",
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

    location.reload();
  }

  increment_value(e) {
    const card = e.closest('.elem');
    const quantity_id = "add-" + card.id;
    const quantity = document.getElementById(quantity_id);
    let clean_quantity = quantity.textContent.replace("Quantity: ", "");

    clean_quantity -= 0; // this convert the string to number
    clean_quantity += 1;

    quantity.innerHTML = "Quantity: " + clean_quantity;
  }

  decrement_value(e) {
    const card = e.closest('.elem');
    const quantity_id = "add-" + card.id;
    const quantity = document.getElementById(quantity_id);
    let clean_quantity = quantity.textContent.replace("Quantity: ", "");

    clean_quantity -= 0; // this convert the string to number
    if (clean_quantity - 1 >= 1) clean_quantity -= 1;

    quantity.innerHTML = "Quantity: " + clean_quantity;
  }

  async downloadCart() {
    const response = await fetch(`${backendUrl.development}c?uuid=1`, {
      method: "GET",
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    console.log(response);
  }
}