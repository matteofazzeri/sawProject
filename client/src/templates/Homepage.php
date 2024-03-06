<?php
require __DIR__ . '/../components/Navbar.php';
?>

<main class="w-full bg-yellow-200 p-4">

  <section id="">
    <div class="w-full h-full bg-green-200 p-3">
      <div class="w-full">
        <h3 class="font-bold text-lg">Last Added</h3>
        <span class="max-w-full w-full flex flex-row gap-2 overflow-auto py-1">
          <div class="min-w-[200px] h-[300px] bg-white"><img src="" alt="elem"></div>
          <div class="min-w-[200px] h-[300px] bg-white"><img src="" alt="elem"></div>
          <div class="min-w-[200px] h-[300px] bg-white"><img src="" alt="elem"></div>
          <div class="min-w-[200px] h-[300px] bg-white"><img src="" alt="elem"></div>
          <div class="min-w-[200px] h-[300px] bg-white"><img src="" alt="elem"></div>
          <div class="min-w-[200px] h-[300px] bg-white"><img src="" alt="elem"></div>
          <div class="min-w-[200px] h-[300px] bg-white"><img src="" alt="elem"></div>
          <div class="min-w-[200px] h-[300px] bg-white"><img src="" alt="elem"></div>
        </span>
      </div>
    </div>

    <div class="w-full h-full bg-green-200 p-3">
      <div class="w-full">
        <h3 class="font-bold text-lg">Most sold</h3>
        <span class="max-w-full w-full flex flex-row gap-2 overflow-auto py-1">
          <div class="min-w-[200px] h-[300px] bg-white"><img src="" alt="elem"></div>
          <div class="min-w-[200px] h-[300px] bg-white"><img src="" alt="elem"></div>
          <div class="min-w-[200px] h-[300px] bg-white"><img src="" alt="elem"></div>
          <div class="min-w-[200px] h-[300px] bg-white"><img src="" alt="elem"></div>
          <div class="min-w-[200px] h-[300px] bg-white"><img src="" alt="elem"></div>
          <div class="min-w-[200px] h-[300px] bg-white"><img src="" alt="elem"></div>
          <div class="min-w-[200px] h-[300px] bg-white"><img src="" alt="elem"></div>
          <div class="min-w-[200px] h-[300px] bg-white"><img src="" alt="elem"></div>
        </span>
      </div>
    </div>

    <!-- //* Aggiungere il controllo se nella lista dei desideri ci sono abbastanza elementi -->
    <div class="w-full h-full bg-green-200 p-3">
      <div class="w-full">
        <h3 class="font-bold text-lg">From your wish list</h3>
        <span class="max-w-full w-full flex flex-row gap-2 overflow-auto py-1">
          <div class="min-w-[200px] h-[300px] bg-white"><img src="" alt="elem"></div>
          <div class="min-w-[200px] h-[300px] bg-white"><img src="" alt="elem"></div>
          <div class="min-w-[200px] h-[300px] bg-white"><img src="" alt="elem"></div>
          <div class="min-w-[200px] h-[300px] bg-white"><img src="" alt="elem"></div>
          <div class="min-w-[200px] h-[300px] bg-white"><img src="" alt="elem"></div>
          <div class="min-w-[200px] h-[300px] bg-white"><img src="" alt="elem"></div>
          <div class="min-w-[200px] h-[300px] bg-white"><img src="" alt="elem"></div>
          <div class="min-w-[200px] h-[300px] bg-white"><img src="" alt="elem"></div>
        </span>
      </div>
    </div>
  </section>


  <!-- 
    //? 1. Most sold
    //? 2. Last Added
    //? 3. From your wish list
    //? 4. Aggiungere controllo su elementi che visuallizza solo, ma che non ha nel carrello o nella lista dei desideri
   -->


</main>

<?php
require __DIR__ . '/../components/Footer.php';
