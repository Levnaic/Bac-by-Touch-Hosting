<section id="formContainer">
    <h1>Unos podataka za blog</h1>
    <div class="formCard">
        <form method="POST" action="/dashboard/posts/update?id=<?php echo $row->id; ?>" enctype="multipart/form-data" id="updateForm_<?php echo $row->id; ?>">
            <input type="hidden" name="_method" value="PATCH">
            <input type="text" name="title" id="createBlogTitle" placeholder="title" value="<?php echo $row->title; ?>">
            <input type="text" name="subtitle" id="createBlogSubtitle" placeholder="subtitle" value="<?php echo $row->subtitle; ?>">
            <textarea type="text" name="body" id="createBlogBody" placeholder="body" rows="8"><?php echo $row->body; ?></textarea>
            <p>Ime prošle slike: <?php echo $row->img; ?></p>
            <input type="file" name="img" id="createBlogImg" placeholder="image">
            <input type="text" name="imgAlt" id="createEventImgAlt" placeholder="Kratak opis slike" value="<?php echo $row->img_alt; ?>">
            <div class="formButtons">
                <button type="button" onclick="confirmUpdate(<?php echo $row->id; ?>)" class="loginButton">Create</button>
            </div>
        </form>
    </div>
</section>
<script src="/assets/scripts/confirmator.js"></script>