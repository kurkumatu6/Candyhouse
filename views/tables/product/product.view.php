<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/header.php"; ?>
<main id="product_main">
    <div class="product-block">
        <div class="product-block-top">
            <div class="product-img-block">

                <?php if($countImages != 0):?>
                    <button id="back"><</button>
                    <?php for($i=0; $i<$countImages; $i++): ?>
                        <img src="/upload/<?= $images[$i]->image??"placeholder.png" ?>" alt="" class="productImage" data-num="<?= $i?>" data-count="<?= $countImages-1?>">
                    <?php endfor ?>
                <button id="next">></button>
                <?php else:?>
                    <img src="/upload/placeholder.png" alt="" class="productImage" data-num="0">
                <?endif?>
            </div>
            <div class="product-info-block">
                <h1 class="word_Wrap"><?=$product->name?></h1>
                <h2>Цена <?=$product->price?> Руб</h2>
                <h2>Вес <?=$product->weight_g?> грамм</h2>
                <h2>Каллорийность: <?=$product->calories?> калл/100 грамм</h2>
                <button class="addProductInBasket" data-product-id="<?=$product->id?>">Добавить в корзину</button>
            </div>
        </div>
        <div class="product-block-bot">
            <div class="product-indgredientList-block">
                <h2>Список ингредиентов</h2>
                <?php //foreach ($ingredients as $ingredient) : ?>
                    <h3><?=$product->ingredient_list?></h3>

            </div>
            <div class="product-srok-block">
                <h2>Срок годности</h2>
                <h3>При температуре 10°С <?=$product->self_life_days?> дней</h3>
            </div>
        </div>
    </div>
    <div class="rewiwes-block">
        <h2 class="rewievs-title">Отзывы</h2>
        <div class="rewievs">
        <?php foreach ($reviwes as $reviwe):?>
                <div class="rewiev">
                    <h4 class="rewiev-name"><?=$reviwe->client ?></h4>
                    <h4 class="rewiev-content"><?=$reviwe->content?></h4>
                </div>
        <?php endforeach?>
        </div>
    </div>
</main>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/footer.php"; ?>
<script src="/assets/js/feach.js"></script>
<script src="/assets/js/Product.js"></script>
<!-- SELECT reviews.*, clients.name as client, products.name as product FROM `reviews` INNER JOIN clients ON clients.id = reviews.client_id INNER JOIN products.id = reviews.product_id WHERE product_id =  -->