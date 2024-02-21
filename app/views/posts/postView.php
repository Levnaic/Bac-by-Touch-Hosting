<section class="pageControll margins">
    <a href="/blog">
        <div class="btnStandard">
            <p>Idi nazad</p>
        </div>
    </a>
</section>

<section class="postBlog margins">
    <h1 class="blogTitle"><?php echo $row->title; ?></h1>
    <div class="blogImage">
        <img src="/assets/img/blog-img/<?php echo $row->img; ?>" alt="slika bloga">
    </div>
    <p class="blogBody"><?php echo $row->body; ?></p>
    <div class="blogData">
        <p class="blogMeta">Autor bloga: <?php echo $row->user_name; ?></p>
        <p class="blogDate">Datum postavljanja: <?php echo date("d", strtotime($row->created_at)) . "." . date("m", strtotime($row->created_at)) . "." . date("Y", strtotime($row->created_at)) . "."; ?></p>
    </div>

</section>

<script src="assets/scripts/header_footer.js"></script>