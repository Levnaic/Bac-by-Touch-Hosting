<section id="formContainer">
    <h1>Izmena podataka za proizvode</h1>
    <div class="formCard">
        <form method="POST" action="/dashboard/products/update?id=<?php echo $row->id; ?>" id="updateForm_<?php echo $row->id; ?>">
            <input type="hidden" name="_method" value="PATCH">
            <input type="text" name="productName" placeholder="Ime proizvoda" value="<?php echo $row->product_name; ?>">
            <input list="producers" name="productProducer" id="producer" placeholder="Proizvodjac" value="<?php echo $row->producer_id; ?>">
            <datalist id="producers">
                <?php
                foreach ($rowsProducers as $rowProducer) :
                ?>
                    <option value="<?php echo $rowProducer->id; ?>"><?php echo $rowProducer->title; ?></option>
                <?php endforeach ?>
            </datalist>
            <input type="number" name="productPrice" placeholder="Cena jednog proizvoda" value="<?php echo $row->price; ?>">
            <input type="number" name="productInStock" placeholder="Proizvoda na stanju" value="<?php echo $row->in_stock; ?>">
            <div class="formButtons">
                <button type="button" onclick="confirmUpdate(<?php echo $row->id; ?>)" class="loginButton">Create</button>
            </div>
        </form>
    </div>
</section>

<script src="/assets/scripts/confirmator.js"></script>