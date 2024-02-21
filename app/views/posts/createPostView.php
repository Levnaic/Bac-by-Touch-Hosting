<section id="formContainer">
    <h1>Unos podataka za blog</h1>
    <div class="formCard">
        <form method="POST" action="/dashboard/posts/create" enctype="multipart/form-data">
            <input type="hidden" name="">
            <input type="text" name="title" id="createBlogTitle" placeholder="title">
            <input type="text" name="subtitle" id="createBlogSubtitle" placeholder="subtitle">
            <textarea type="text" name="body" id="createBlogBody" placeholder="body" rows="8"></textarea>
            <input type="file" name="img" id="createBlogImg" placeholder="image">
            <input type="text" name="imgAlt" id="createEventImgAlt" placeholder="Kratak opis slike">
            <div class="formButtons">
                <button type="submit" name="submit" class="loginButton">Create</button>
            </div>
        </form>
    </div>
</section>