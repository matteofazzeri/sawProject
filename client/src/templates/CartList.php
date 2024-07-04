<main class="cart-page">

  <div id="cart-list" class="cart-list">
    <span id="loader-cart-list" class="loader"></span>
    <script>
      const c = new Cart();
      c.renderCart("cart-list");
    </script>
  </div>

  <div class="total-price">
    <p id="cart-list-total"></p>
    <a href="checkout"><p>Checkout</p></a>
  </div>

  <!-- <div id="cart-checkout"></div> -->

</main>