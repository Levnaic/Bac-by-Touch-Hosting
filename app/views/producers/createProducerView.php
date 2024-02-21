<section id="formContainer">
    <h1>Unos proizvođača</h1>
    <div class="formCard">
        <form method="POST" action="/dashboard/producers/create">
            <input type="text" name="mapTitle" placeholder="Title" data-input-type="txt">
            <input type="email" name="email" placeholder="Email" data-input-type="email">
            <textarea type="text" name="mapBody" placeholder="Text of map bookmark" rows="8" data-input-type="txt"></textarea>
            <input type="text" name="mapLatitude" placeholder="Latitude" data-input-type="float">
            <input type="text" name="mapLongitude" placeholder="Longitude" data-input-type="float">
            <input type="text" name="popupMsg" placeholder="Popup Message" data-input-type="txt">
            <input type="text" name="category" placeholder="Category" data-input-type="txt">
            <div class="formButtons">
                <button type="submit" class="loginButton">Create</button>
            </div>
        </form>
    </div>
</section>

<script src="/assets/scripts/formValidation.js"></script>