<section id="formContainer">
    <h1>Izmena proizvođača</h1>
    <div class="formCard">
        <form method="POST" action="/dashboard/producers/update?id=<?php echo $row->id; ?>" id="updateForm_<?php echo $row->id; ?>">
            <input type="hidden" name="_method" value="PATCH">
            <input type="text" name="title" id="createMapTitle" placeholder="title" value="<?php echo $row->title; ?>">
            <input type="email" name="email" placeholder="Email" data-input-type="email" value="<?php echo $row->email; ?>">
            <input type="tel" name="contact" placeholder="Phone Number" data-input-type="phoneNumber" value="<?php echo $row->contact;  ?>">
            <input type="text" name="location" placeholder="Address" data-input-type="txt" value="<?php echo $row->producerLocation; ?>">
            <textarea type="text" name="body" id="createMapBody" placeholder="body" rows="8"><?php echo $row->body; ?></textarea>
            <input type="text" name="latitude" id="createMapLatitude" placeholder="latitude" value="<?php echo $row->latitude; ?>">
            <input type="text" name="longitude" id="createMapLongitude" placeholder="longitude" value="<?php echo $row->longitude; ?>">
            <input type="text" name="popupMsg" id="createMapPopupMsg" placeholder="popupMsg" value="<?php echo $row->popupMsg; ?>">
            <select name="category">
                <option value="proizvodi" <?php if ($row->category == "proizvodi") echo "selected"; ?>>Proizvodi</option>
                <option value="restorani" <?php if ($row->category == "restorani") echo "selected"; ?>>Restorani</option>
                <option value="caffe" <?php if ($row->category == "caffe") echo "selected"; ?>>Caffe</option>
                <option value="suveniri" <?php if ($row->category == "suveniri") echo "selected"; ?>>Suveniri</option>
                <option value="usluge" <?php if ($row->category == "usluge") echo "selected"; ?>>Usluge</option>
                <option value="ostalo" <?php if ($row->category == "usluge") echo "selected"; ?>>Ostalo</option>
            </select>
            <div class="formButtons">
                <button type="button" onclick="confirmUpdate(<?php echo $row->id; ?>)" class="loginButton">Create</button>
            </div>
        </form>
    </div>
</section>

<script src="/assets/scripts/confirmator.js"></script>