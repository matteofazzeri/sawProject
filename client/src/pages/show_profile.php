<?php
display('Head', false, [
  'title' => 'SAW: Profile',
  'css' => ['generic', 'navbar'],
  'js' => ['config', 'Loaders', 'show_profile', 'product']
]);

display('Navbar');
?>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    profile.showProfile();
  });
</script>

<main>

  <form id="show-profile">

  </form>

</main>

<?php

display('Footer');
