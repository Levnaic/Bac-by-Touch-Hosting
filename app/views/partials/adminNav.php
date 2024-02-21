<!-- NAV BAR -->
<nav id="dashboardBack" class="margins">
    <?php
    $uriExploded = explode("/", $_SERVER['REQUEST_URI']);
    array_pop($uriExploded);
    $backLink = implode('/', $uriExploded);
    $backLink = !empty($backLink) ? $backLink : '/dashboard';
    echo "<a href='$backLink' class='btnStandard'>Nazad</a>"
    ?>
</nav>