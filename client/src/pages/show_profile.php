<?php

require __DIR__ . '/../libs/functions.php';

display('Head', false, [
  'title' => 'SAW: Profile',
  'css' => ['generic', 'navbar'],
  'js' => ['config', 'Loaders', 'show_profile', 'product']
]);

display('Navbar');

?>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    showProfile();
  });
</script>

<main>

  <div id="show-profile"></div>

</main>

<?php

display('Footer');
