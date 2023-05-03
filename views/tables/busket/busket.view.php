<?php
// session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/header.php";
// var_dump($_SESSION['aa']);
// var_dump($_SESSION["zz"]);
// var_dump($_SESSION["gg"])

?>

<div id="basket_main">
    <div class="head">
        <h1>Корзина</h1>
    </div>
    <div class="basket">
        <div class="row row-cols-1 row-cols-md-3 row-cols-xl-4 g-4 products-container back basket_prod">
            <?php foreach ($baskets as $basket): ?>
                <div class="col basket-position">
                    <div class="card">
                        <img src="/upload/<?= $basket->image ?? "placeholder.png" ?>" class="card-img-top"
                            alt="<?= $basket->image ?>">
                        <div class="card-body">
                            <h4 class="card-title word_WrapNOPR">
                                <?= $basket->product_name ?>
                            </h4>
                            <p class="count card-text" id="product-count-<?= $basket->product_id ?>">Количество: <?= $basket->count ?> шт
                            </p>
                            <div class="controls_basket_position">
                                <button name="plus" class="plus prod_control"
                                    data-product-id="<?= $basket->product_id ?>">+</button>
                                <button name="minus" class="minus prod_control"
                                    data-product-id="<?= $basket->product_id ?>">-</button>
                                <button class="delete prod_control_del" id="product-del-<?= $basket->product_id ?>"
                                    data-product-id="<?= $basket->product_id ?>">Удалить</button>
                            </div>

                            <p class="price" data-product-id="<?= $basket->product_id ?>">Цена <?= $basket->price ?><span class="small2">₽</span></p>
                            <p class="itogo" id="product-price-<?= $basket->product_id ?>"
                                data-product-id="<?= $basket->product_id ?>">Стоимость <?= $basket->price_position ?><span class="small2">₽</span>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
            <?php foreach($recipes as $recipe):?>
            <div class="col basket-position">
                    <div class="card">
                    <img src="/assets/images/ricipe_icon.png" class="card-img-top"
                            alt="Рецепт">
                        <div class="card-body">
                            <a class="recipes_ccl" href="/app/tables/recipes/showRecipe.php?id=<?= $recipe->recipe_id ?>">

                            <h4 class="card-title word_Wrap2">
                            <?=$recipe->name != null?"Название рецепта ".$recipe->name : "Номер рецепта ".  $recipe->recipe_id ?>
                            </h4>
                            </a>

                            <p class="count card-text" id="recipe-count-<?= $recipe->recipe_id ?>">Количество: <?= $recipe->count ?> шт
                            </p>
                            <div class="controls_basket_position">
                                <button name="plusRecipe" class="plusRecipe prod_control"
                                    data-product-id="<?= $recipe->recipe_id ?>">+</button>
                                <button name="minusRecipe" class="minusRecipe prod_control"
                                    data-product-id="<?= $recipe->recipe_id ?>">-</button>
                                <button class="deleteRecipe prod_control_del" id="recipe-del-<?= $recipe->recipe_id ?>"
                                    data-product-id="<?= $recipe->recipe_id ?>">Удалить</button>
                            </div>

                            <p class="price" data-product-id="<?= $recipe->recipe_id ?>">Цена <?= $recipe->recipe_price ?><span class="small2">₽</span></p>
                            <p class="itogo" id="recipe-price-<?= $recipe->recipe_id ?>"
                                data-product-id="<?= $recipe->recipe_id?>">Стоимость <?= $recipe->price_position ?><span class="small2">₽</span>
                            </p>


                        </div>
                    </div>
                </div>
            <? endforeach?>


        </div>
        <div class="basket_controls">
            <div class="basket_all_position">
                <h2 class="count_all itogi" id="total-count">Количество
                    <?= $count ?> шт
                </h2>
                <h2 class="summa itogi" id="obsh">Общая сумма
                    <?= $summer ?> рублей
                </h2>

            </div>
            <div class="buttons_bask">
                <button class="createOrderBtnl" name="createOrderBtn"
                    value="<?= $_SESSION["user"]["id"] ?? "" ?>">Оформить заказ</button>
                <button class="clear bask_control">Очистить корзину</button>
            </div>
        </div>
    </div>

</div>

<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/footer.php";
// unset($_SESSION['aa']);
// unset($_SESSION['gg']);
// unset($_SESSION['dd']);?>
<script src="/assets/js/feach.js"></script>
<script src="/assets/js/busketLoad.js"></script>