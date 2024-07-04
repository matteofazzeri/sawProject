<main class="checkout-page">

  <div id="checkout" class="checkout">
    <span id="loader-checkout" class="loader"></span>
    <script>
      const c = new Checkout();
      c.renderCheckout("checkout");
    </script>
  </div>

  <div class="total-price">
    <p id="checkout-total"></p>
    <button onclick="c.completeCheckout()">
      <p>Complete Purchase</p>
    </button>
  </div>

  <!-- <div id="cart-checkout"></div> -->


</main>