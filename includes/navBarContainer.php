<div class="nav-bar-container">
   <nav class="navBar">
       <span onclick="openPage('index.php')" role="link" tabindex=0 class="logo customLink"><i class="ion-headphone"></i></span>

       <div class="group">
           <div class="navItem">
               <a href="search.php" class="navItemLink">Search <span class="searchIcon"><i class="ion-ios-search" alt="Search"></i></span></a>
           </div>
       </div>

       <div class="group">
           <div class="navItem">
                <span onclick="openPage('index.php')" role="link" tabindex=1 class="navItemLink">Browse</span>
           </div>

           <div class="navItem">
               <span onclick="openPage('yourMusic.php')" role="link" tabindex=1 class="navItemLink">Your Music</span>
           </div>

           <div class="navItem">
               <a href="profile.php" class="navItemLink">Michel Ferreira</a>
           </div>
       </div>

   </nav>
   
    <script>
        $(".navBar").on("mousedown touchstart mousemove touchmove", function(e) {
            e.preventDefault();
        });
    </script>
</div>