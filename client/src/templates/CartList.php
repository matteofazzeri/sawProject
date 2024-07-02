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
    <button>
      <a href="checkout">Checkout</a>
    </button>
  </div>

  <!-- <div id="cart-checkout"></div> -->

</main>