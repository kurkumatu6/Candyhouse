<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/header.php"; ?>
<main id="index_main">
    <h1>Каталог</h1>
    <div>
        <div class="selectors">
            <div class="categorySelectorBlock">
                <p class="categorySelectorLabel">Категория: </p>
            <select name="" id="categorySelector">
                <option value="0" >Все</option>
                <?php foreach ($categories as $category) : ?>
                    <option value="<?= $category->id ?>"><?= $category->category ?></option>

                <?php endforeach ?>
            </select>
            </div>

            <button id="priceSort">Цена</button>
        </div>
        <div class="products-container">

        </div>
        <div id="pageLoader">

        </div>
    </div>

</main>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/footer.php"; ?>
<script src="/assets/js/feach.js"></script>
        <script src="/assets/js/showProducts.js"></script>

