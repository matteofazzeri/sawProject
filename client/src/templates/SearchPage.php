<?php
require __DIR__ . '/../components/Navbar.php';

// Define the number of items per page
$itemsPerPage = 10;

// Calculate total number of pages based on total number of items
$totalItems = 100; // Assuming you have a total of 100 items
$totalPages = ceil($totalItems / $itemsPerPage);

// Get current page number from query parameter, default to 1 if not set
$currentpage = isset($_GET['page']) ? $_GET['page'] : 1;
$currentpage = max(1, min($currentpage, $totalPages)); // Ensure current page is within valid range

// Calculate offset for fetching items from database
$offset = ($currentpage - 1) * $itemsPerPage;

// Fetch items from database based on current page and items per page
// Replace this with your actual database query logic
$items = []; // Fetch items based on current page and offset

?>

<main class="w-full bg-yellow-200 flex flex-row">
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
</main>



<?php
require __DIR__ . '/../components/Footer.php';
?>