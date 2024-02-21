<section class="pageControll margins">
    <a href="/calendar">
        <div class="btnStandard">
        <p>Idi nazad</p> 
        </div>
    </a>
</section>

<section class="evnet margins">
    <h1 class="title"><?php echo $row->event_name; ?></h1>
    <p class="date"><?php echo $row->event_date; ?></p>
    <div class="img">
        <img src="/assets/img/events-img/<?php echo $row->img; ?>" alt="<?php echo $row->img_alt; ?>">
    </div>
    <p class="body"><?php echo $row->event_text; ?></p>
</section>

<script src="assets/scripts/header_footer.js"></script>