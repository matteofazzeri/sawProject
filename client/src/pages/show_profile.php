<?php
display('Head', false, [
  'title' => 'SAW: Profile',
  'css' => ['generic', 'navbar', 'footer'],
  'js' => ['config', 'Loaders', 'show_profile', 'product']
]);

display('Navbar');
?>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    profile.showProfile();
    profileDetails.showDetails();
  });
</script>

<main>

  <form id="show-profile"></form>

  <form id="show-details"></form>

</main>

<?php

display('Footer');
