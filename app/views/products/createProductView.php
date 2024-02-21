<section id="formContainer">
    <h1>Unos podataka za proizvode</h1>
    <div class="formCard">
        <form method="POST" action="/dashboard/products/create">
            <input type="text" name="productName" placeholder="Ime proizvoda">
            <input list="producers" name="productProducer" id="producer" placeholder="Proizvodjac">
            <datalist id="producers">
                <?php
                foreach ($rows as $row) :
                ?>
                    <option value="<?php echo $row->id; ?>"><?php echo $row->title; ?></option>
                <?php endforeach ?>
            </datalist>
            <input type="number" name="productPrice" placeholder="Cena jednog proizvoda">
            <input type="number" name="productInStock" placeholder="Proizvoda na stanju">
            <div class="formButtons">
                <button type="submit" class="loginButton">Create</button>
            </div>
        </form>
    </div>
</section>