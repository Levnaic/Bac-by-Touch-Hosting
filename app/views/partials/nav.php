 <!-- responsive -->
 <button aria-label="Open menu" class="burger-menu" type="button">
   <i class="fa fa-bars fa-2x" aria-hidden="true"></i>
 </button>
 <div class="menu__wrapper-green">
   <div class="menu__wrapper-yellow">
     <header class="menu__wrapper">

       <div class="menu__bar">
         <a href="/" title="Home" aria-label="home" class="logo">
           Bac By Touch
         </a>
         <nav>
           <ul class="navigation hide">
             <li>
               <a href="/map"> Mapa </a>
             </li>
             <li>
               <a href="/calendar"> Kalendar </a>
             </li>
             <li>
               <a href="/storytelling">Ture</a>
             </li>
             <li class="dropdown-li">
               <button class="nav-btn">
                 Mesta
                 <svg class="dropdown-svg" aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16">
                   <path d="M12.78 5.22a.749.749 0 0 1 0 1.06l-4.25 4.25a.749.749 0 0 1-1.06 0L3.22 6.28a.749.749 0 1 1 1.06-1.06L8 8.939l3.72-3.719a.749.749 0 0 1 1.06 0Z"></path>
                 </svg>
               </button>
               <div class="dropdown__wrapper">
                 <div class="dropdown">
                   <ul class="list-items-with-description">
                     <li>
                       <a href="/tvrdjava" class="item-title">
                         <h3>Bačka tvrđava</h3>
                         <p>Lorem ipsum dolor sit amet.</p>
                       </a>
                     </li>
                     <li>
                       <a href="/samostan" class="item-title">
                         <h3>Franjevački samostan</h3>
                         <p>Lorem ipsum dolor sit amet.</p>
                       </a>
                     </li>
                     <li>
                       <a href="/manastir" class="item-title">
                         <h3>Manastir Bođani</h3>
                         <p>Lorem ipsum dolor sit amet.</p>
                       </a>
                     </li>
                     <li>
                       <a href="tursko-kupatilo" class="item-title">
                         <h3>Tursko kupatilo</h3>
                         <p>Dynamic pages, static speed</p>
                       </a>
                     </li>
                     <li>
                       <a href="siljak" class="item-title">
                         <h3>Kula Šiljak</h3>
                         <p>Lorem ipsum dolor sit amet.</p>
                       </a>
                     </li>
                     <li>
                       <div class="item-title">
                         <h3>Lorem ipsum</h3>
                         <p>Lorem ipsum dolor sit amet.</p>
                       </div>
                     </li>
                   </ul>
                 </div>
               </div>
             </li>
             <li class="dropdown-li">
               <button class="nav-btn">
                 Upoznajte nas
                 <svg class="dropdown-svg" aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16">
                   <path d="M12.78 5.22a.749.749 0 0 1 0 1.06l-4.25 4.25a.749.749 0 0 1-1.06 0L3.22 6.28a.749.749 0 1 1 1.06-1.06L8 8.939l3.72-3.719a.749.749 0 0 1 1.06 0Z"></path>
                 </svg>
               </button>
               <div class="dropdown__wrapper">
                 <div class="dropdown">
                   <ul class="list-items-with-description">
                     <li>
                       <a href="/aboutus" class="item-title">
                         <h3>O nama</h3>
                         <p>Lorem ipsum dolor sit amet.</p>
                       </a>
                     </li>
                     <li>
                       <a href="/blog" class="item-title">
                         <h3>Blog</h3>
                         <p>Lorem ipsum dolor sit amet.</p>
                       </a>
                     </li>
                   </ul>
                 </div>
               </div>
             </li>
           </ul>
         </nav>
       </div>
       <div class="right-side">
         <div class="language-change">
           <button onclick="setLanguage('sr')">SR</button>
           <p>/</p>
           <button onclick="setLanguage('en')">EN</button>
         </div>
         <div class="action-buttons hide">
           <?php if (!isset($_SESSION['username'])) : ?>
             <a href="/login" title="Log in" class="secondary"> Prijava </a>
             <a href="/register" title="Sign up" class="primary"> Registracija </a>
           <?php else : ?>
             <?php if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 'admin') { ?>
               <a href="/dashboard" class="secondary">Admin panel</a>
             <?php } ?>
             <a href="/logout" class="primary">Odjava</a>
           <?php endif; ?>
         </div>
       </div>
     </header>
   </div>
 </div>