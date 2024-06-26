<section id="formContainer">
    <h1>Unos proizvođača</h1>
    <div class="formCard">
        <form method="POST" action="/dashboard/producers/create">
            <input type="text" name="mapTitle" placeholder="Title" data-input-type="txt">
            <input type="email" name="email" placeholder="Email" data-input-type="email">
            <input type="tel" name="contact" placeholder="Phone Number" data-input-type="phoneNumber">
            <input type="text" name="location" placeholder="Address" data-input-type="txt">
            <textarea type="text" name="mapBody" placeholder="Text of map bookmark" rows="8" data-input-type="txt"></textarea>
            <input type="text" name="mapLatitude" placeholder="Latitude" data-input-type="float">
            <input type="text" name="mapLongitude" placeholder="Longitude" data-input-type="float">
            <input type="text" name="popupMsg" placeholder="Popup Message" data-input-type="txt">
            <select name="category">
                <option value="proizvodi">Proizvodi</option>
                <option value="restorani">Restorani</option>
                <option value="caffe">Caffe</option>
                <option value="suveniri">Suveniri</option>
                <option value="usluge">Usluge</option>
                <option value="prenociste">Prenoćište</option>
                <option value="lokaliteti">Turistički lokaliteti</option>
                <option value="ostalo">Ostalo</option>
            </select>
            <div class="formButtons">
                <button type="submit" class="loginButton">Create</button>
            </div>
        </form>
    </div>
</section>

<script src="/assets/scripts/formValidation.js"></script>