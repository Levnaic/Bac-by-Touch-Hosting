<button class="nav-btn open-btn">
    <i class="fa fa-bars" aria-hidden="true"></i>
</button>
<nav>
    <div class="nav nav-green">
        <div class="nav nav-yellow">
            <div class="nav nav-white">
                <button class="nav-btn close-btn">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </button>

                <ul class="list">
                    <li class="listEl"><a href="/">POČETNA</a></li>
                    <div class="dropdown listEl">
                        <button class="dropdownBtn">ISTRAŽI <i class="fa fa-angle-down" aria-hidden="true"></i></button>
                        <div class="dropdownContent">
                            <ul>
                                <li><a href="/storytelling">TURE</a></li>
                                <li><a href="/map">MAPA</a></li>
                                <li><a href="/virtual-tour">VIRTUELNA TURA</a></li>
                                <li><a href="/calendar">KALENDAR</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="dropdown listEl">
                        <button class="dropdownBtn">UPOZNAJTE NAS <i class="fa fa-angle-down" aria-hidden="true"></i></button>
                        <div class="dropdownContent">
                            <ul>
                                <li><a href="/blog">BLOG</a></li>
                                <li><a href="/aboutus">O NAMA</a></li>
                            </ul>
                        </div>
                    </div>
                </ul>
                <!-- login part -->
                <?php if (isset($_SESSION['username'])) : ?>
                    <div class='secondPart-user'>
                        <button class='navUserBtn'>
                            <i class="fa fa-user fa-3x" aria-hidden="true"></i>
                        </button>
                        <div class='dropdown-user'>
                            <div class="dropdown-userPart">
                                <p class='userCredencials'>Korisnik: </p>
                                <p class="userCredencials"><?= $_SESSION["username"] ?></p>
                            </div>
                            <div class="dropdown-userPart">
                                <p class='userCredencials'>Uloga: <?= $_SESSION["userRole"] ?></p>
                            </div>
                            <?php if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 'admin') { ?>
                                <a href='/dashboard' class='adminDashboardBtn'>Dashboard</a>
                            <?php } ?>
                            <button class='userLogOut' onclick="document.location='/logout'">Odjava</button>
                        </div>
                    </div>
                <?php else : ?>
                    <div class='secondPart-login'>
                        <a href='/register'>REGISTRACIJA</a>
                        <a href='/login'>PRIJAVA</a>
                    </div>
                <?php endif; ?>

                <!-- Language part -->
                <div class="langaugePart">
                    <button onclick="setLanguage('sr')">SR</button>
                    <p>/</p>
                    <button onclick="setLanguage('en')">EN</button>
                </div>
            </div>
        </div>
    </div>
</nav>