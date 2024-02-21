<section id="formContainer">
    <div class="formCard">
        <form method="POST" action="/dashboard/events/update?id=<?php echo $row->id; ?>" enctype="multipart/form-data" id="updateForm_<?php echo $row->id; ?>">
            <input type="hidden" name="_method" value="PATCH">
            <input type="text" name="eventName" placeholder="Naslov događaja" data-input-type="txt" value="<?php echo $row->event_name; ?>">
            <textarea type="text" name="eventText" placeholder="Tekst o događaju" rows="8" data-input-type="txt"><?php echo $row->event_text; ?></textarea>
            <input type="date" name="eventDate" placeholder="Datum događaja" data-input-type="date" value="<?php echo $row->event_date; ?>">
            <input type="text" name="eventDescription" placeholder="Kratki opis događaja" data-input-type="txt" value="<?php echo $row->event_description; ?>">
            <input type="checkbox" name="everyYear" placeholder="Da li se događaj dešava svake godine?" <?php if ($row->is_every_year) echo "checked"; ?>>
            <input type="file" name="img" id="createEventImg" placeholder="Slika dogadjaja">
            <p>Ime prošle slike: <?php echo $row->img; ?></p>
            <input type="text" name="imgAlt" id="createEventImgAlt" placeholder="Kratak opis slike" data-input-type="txt" value="<?php echo $row->img_alt; ?>">
            <div class="formButtons">
                <button type="button" onclick="confirmUpdate(<?php echo $row->id; ?>)" class="loginButton">Create</button>
            </div>
        </form>
    </div>
</section>

<script src="/assets/scripts/formValidation.js"></script>
<script src="/assets/scripts/confirmator.js"></script>