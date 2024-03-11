<?php


// Define the number of items per page
$itemsPerPage = 15;

// Sample JSON data (you will replace this with the actual fetched data)
$jsonData = [
    [
        "title" => "Product 1",
        "imageSrc" => "https://i.postimg.cc/jjBSrfnQ/poster1-img.jpg",
        "rating" => "5 stars",
        "tags" => ["tag1", "tag2", "tag3"],
        "latestComment" => "This is a great product!"
    ],
    [
        "title" => "Product 2",
        "imageSrc" => "https://i.postimg.cc/3Jc3QvXk/poster2-img.jpg",
        "rating" => "4 stars",
        "tags" => ["tag4", "tag5"],
        "latestComment" => "I love this product!"
    ],
    [
        "title" => "Product 3",
        "imageSrc" => "https://i.postimg.cc/3Jc3QvXk/poster3-img.jpg",
        "rating" => "3 stars",
        "tags" => ["tag6", "tag7"],
        "latestComment" => "Nice product!"
    ],
    [
        "title" => "Product 4",
        "imageSrc" => "https://i.postimg.cc/3Jc3QvXk/poster4-img.jpg",
        "rating" => "4.5 stars",
        "tags" => ["tag8", "tag9"],
        "latestComment" => "Awesome product!"
    ],
    [
        "title" => "Product 5",
        "imageSrc" => "https://i.postimg.cc/3Jc3QvXk/poster5-img.jpg",
        "rating" => "4 stars",
        "tags" => ["tag10", "tag11"],
        "latestComment" => "Good product!"
    ],
    [
        "title" => "Product 6",
        "imageSrc" => "https://i.postimg.cc/3Jc3QvXk/poster6-img.jpg",
        "rating" => "4.8 stars",
        "tags" => ["tag12", "tag13"],
        "latestComment" => "Fantastic product!"
    ],
    [
        "title" => "Product 7",
        "imageSrc" => "https://i.postimg.cc/3Jc3QvXk/poster7-img.jpg",
        "rating" => "3.5 stars",
        "tags" => ["tag14", "tag15"],
        "latestComment" => "Decent product!"
    ],
    [
        "title" => "Product 8",
        "imageSrc" => "https://i.postimg.cc/3Jc3QvXk/poster8-img.jpg",
        "rating" => "4.2 stars",
        "tags" => ["tag16", "tag17"],
        "latestComment" => "Great product!"
    ],
    [
        "title" => "Product 9",
        "imageSrc" => "https://i.postimg.cc/3Jc3QvXk/poster9-img.jpg",
        "rating" => "4.7 stars",
        "tags" => ["tag18", "tag19"],
        "latestComment" => "Amazing product!"
    ],
    [
        "title" => "Product 10",
        "imageSrc" => "https://i.postimg.cc/3Jc3QvXk/poster10-img.jpg",
        "rating" => "3.8 stars",
        "tags" => ["tag20", "tag21"],
        "latestComment" => "Superb product!"
    ],
    [
        "title" => "Product 11",
        "imageSrc" => "https://i.postimg.cc/3Jc3QvXk/poster11-img.jpg",
        "rating" => "4.9 stars",
        "tags" => ["tag22", "tag23"],
        "latestComment" => "Excellent product!"
    ],
    [
        "title" => "Product 12",
        "imageSrc" => "https://i.postimg.cc/3Jc3QvXk/poster12-img.jpg",
        "rating" => "3.3 stars",
        "tags" => ["tag24", "tag25"],
        "latestComment" => "Not bad!"
    ],
    [
        "title" => "Product 13",
        "imageSrc" => "https://i.postimg.cc/3Jc3QvXk/poster13-img.jpg",
        "rating" => "4.6 stars",
        "tags" => ["tag26", "tag27"],
        "latestComment" => "Impressive product!"
    ],
    [
        "title" => "Product 14",
        "imageSrc" => "https://i.postimg.cc/3Jc3QvXk/poster14-img.jpg",
        "rating" => "3.7 stars",
        "tags" => ["tag28", "tag29"],
        "latestComment" => "Satisfactory product!"
    ],
    [
        "title" => "Product 15",
        "imageSrc" => "https://i.postimg.cc/3Jc3QvXk/poster15-img.jpg",
        "rating" => "4.4 stars",
        "tags" => ["tag30", "tag31"],
        "latestComment" => "Pleasing product!"
    ],
    [
        "title" => "Product 16",
        "imageSrc" => "https://i.postimg.cc/3Jc3QvXk/poster16-img.jpg",
        "rating" => "3.9 stars",
        "tags" => ["tag32", "tag33"],
        "latestComment" => "Okay product!"
    ],
    [
        "title" => "Product 17",
        "imageSrc" => "https://i.postimg.cc/3Jc3QvXk/poster17-img.jpg",
        "rating" => "4.3 stars",
        "tags" => ["tag34", "tag35"],
        "latestComment" => "Fair product!"
    ],
    [
        "title" => "Product 18",
        "imageSrc" => "https://i.postimg.cc/3Jc3QvXk/poster18-img.jpg",
        "rating" => "3.6 stars",
        "tags" => ["tag36", "tag37"],
        "latestComment" => "Adequate product!"
    ],
    [
        "title" => "Product 19",
        "imageSrc" => "https://i.postimg.cc/3Jc3QvXk/poster19-img.jpg",
        "rating" => "4.1 stars",
        "tags" => ["tag38", "tag39"],
        "latestComment" => "Wonderful product!"
    ],
    [
        "title" => "Product 20",
        "imageSrc" => "https://i.postimg.cc/3Jc3QvXk/poster20-img.jpg",
        "rating" => "3.4 stars",
        "tags" => ["tag40", "tag41"],
        "latestComment" => "Terrific product!"
    ],
    // Add more products as needed
];

// Calculate total number of pages based on total number of items in JSON data
$totalItems = count($jsonData);
$totalPages = ceil($totalItems / $itemsPerPage);

// Get current page number from query parameter, default to 1 if not set
$currentpage = isset($_GET['page']) ? $_GET['page'] : 1;
$currentpage = max(1, min($currentpage, $totalPages)); // Ensure current page is within valid range

// Calculate offset for fetching items from database
$offset = ($currentpage - 1) * $itemsPerPage;

// Fetch items from database based on current page and items per page
// Replace this with your actual database query logic
$items = array_slice($jsonData, $offset, $itemsPerPage);
?>


<div id="product-container" class="">
    <!-- Product cards will be rendered here -->
</div>
<!-- Pagination links -->
<div class="pagination">
    <?php if ($currentpage > 1) : ?>
        <a href="?page=<?php echo ($currentpage - 1); ?>">Previous</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
        <a href="?page=<?php echo $i; ?>" <?php echo ($i == $currentpage) ? 'class="active"' : ''; ?>><?php echo $i; ?></a>
    <?php endfor; ?>
    <?php if ($currentpage < $totalPages) : ?>
        <a href="?page=<?php echo ($currentpage + 1); ?>">Next</a>
    <?php endif; ?>
</div>




<script>
    // Sample JSON data (you will replace this with the actual fetched data)
    var jsonData = <?php echo json_encode($items); ?>;

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