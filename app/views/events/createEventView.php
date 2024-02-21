<section id="formContainer">
    <h1>Unos podataka za događaj</h1>
    <div class="formCard">
        <form method="POST" action="/dashboard/events/create" enctype="multipart/form-data">
            <input type="text" name="eventName" placeholder="Naslov događaja">
            <textarea type="text" name="eventText" placeholder="Tekst o događaju" rows="8"></textarea>
            <input type="date" name="eventDate" placeholder="Datum događaja">
            <input type="text" name="eventDescription" placeholder="Kratki opis događaja">
            <input type="checkbox" name="everyYear" placeholder="Da li se događaj dešava svake godine?">
            <input type="file" name="img" id="createEventImg" placeholder="Slika dogadjaja">
            <input type="text" name="imgAlt" id="createEventImgAlt" placeholder="Kratak opis slike">
            <div class="formButtons">
                <button type="submit" class="loginButton">Create</button>
            </div>
        </form>
    </div>
</section>