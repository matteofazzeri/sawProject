<script>
  // Sample JSON data (you will replace this with the actual fetched data)
  var jsonData = <?php echo json_encode($items); ?>;

  // should add the script so it can be downloaded from the server

  // Function to render product cards
  function renderProductCards(data) {
    var productHTML = data.map(function(product) {
      return `
                <div class="product-card">
                    <div class="image">
                        <img src="${product.imageSrc}" alt="${product.title}" class="product-image">
                    </div>
                    <div class="details">
                        <h1 class="product-title">${product.title}</h1>
                        <div class="product-rating">Rating: ${product.rating}</div>
                        <div class="product-tags">Tags: ${product.tags.join(', ')}</div>
                        <p class="latest-comment">Latest Comment: ${product.latestComment}</p>
                    </div>
                </div>
            `;
    }).join('');

    document.getElementById('product-container').innerHTML = productHTML;
  }

  // Call the function to render product cards
  renderProductCards(jsonData);
</script>