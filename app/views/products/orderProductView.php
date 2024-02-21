<a href="javascript:history.back()">
    <div class="backIcon">
        <i class="fa fa-arrow-left" aria-hidden="true"></i>
    </div>
</a>
<h1>Popunite Vašu porudžbinu</h1>
<section id="formContainer">
    <div class="formCard">
        <form method="POST" action="/products/order?id=<?php echo $id; ?>">
            <input type="hidden" name="csrf_token" value="<?php $csrfToken; ?>">

            <label for="orderMailName">Ime:</label>
            <input type="text" name="name" id="orderMailName">

            <label for="orderEmail">Email:</label>
            <input type="email" name="email" id="orderEmail">

            <label for="orderMailPhone">Broj telefona:</label>
            <input type="tel" name="phone" id="orderMailPhone">

            <div class="productsContainer">
                <?php
                foreach ($rows as $i => $row) :
                ?>
                    <div class="product">
                        <p class="productName"><?php echo $row->product_name; ?></p>
                        <p class="productPrice" data-price="<?php echo $row->price; ?>">Cena jednog artikla: <?php echo $row->price ?> din.</p>

                        <label for="product<? echo $i; ?>">Količina: </label>
                        <input type="number" id="product<?php echo $i; ?>" name="<?php echo 'product' . $row->product_name; ?>" class="quantity">
                    </div>
                <?php endforeach; ?>
            </div>

            <label for="orderTextArea">Poruka:</label>
            <textarea name="message" id="orderTextArea" cols="30" rows="10" placeholder="Napišite poruku"></textarea>

            <label for="priceSum">Ukupno:</label>
            <input type="number" name="priceSum" id="priceSum" value="0" readonly>
            <div class="formButtons">
                <button type="submit" class="loginButton">Naruči</button>
            </div>
        </form>
    </div>
</section>

<script src="/assets/scripts/products.js"></script>