<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/header.php";
// session_start();
// var_dump($_SESSION["xx"]);
?>
<main id="profile_main">
    <div class="prof">
        <div class="person">
            <h2>Имя: <?= $client->name ?></h2>
            <h2>Телефон: <?= $client->phone ?></h2>
            <h2>Статус: <?= $client->status ?></h2>
        </div>
        <div class="user_orders">
            <h2>Ваши заказы</h2>
            <?php foreach ($orders as $order) : ?>
                <div class="order">
                    <div class="order_title">
                        <h2>№ <?= $order->id ?></h2>
                        <h2 class="text_centr">Статус: <?= $order->status ?></h2>
                    </div>

                    <?php if (count($ordersProducts[$order->id]) > 0) : ?>

                        <div class="product_in_order_table_block">
                            <h2>Товары в заказе</h2>
                            <div class="product_in_order_table">
                                <!-- <div class="product_in_order_table_titles classultimaTr">
                                <td></td>
                                <td>Название</td>
                                <td>Цена</td>
                                <td>Количество</td>
                                <td>Стоимость</td>
                                <?php if ($order->status_of_order_id == "3") : ?>
                            <td></td>
                            <?php endif ?>
                            </div> -->
                                <?php foreach ($ordersProducts[$order->id] as $product) : ?>
                                    <div class="classultimaTr">
                                        <div class="center_align">
                                            <div class="order_product_title">
                                                <div class="imgBlocck"><img src="/upload/<?= $product->image ?? "placeholder.png" ?>" alt=""></div>
                                                <div class="order_product_name_and_price">
                                                    <h2 class="word_Wrap classOrderNameGrid"><a href="/app/tables/product/product.php?id=<?= $product->product_id ?>"> "<?= $product->name ?>"</a></h2>
                                                    <h2 class=" classOrderPriceGrid"> <?= $product->price ?> ₽</h2>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="center_align2">
                                            <div class="content_prod_table">
                                                <div class="content_prod_table_info">
                                                    <div>
                                                        <p>Количество</p>
                                                        <h2 class="count_number"> <?= $product->count ?> <span class="small"> шт</span></h2>
                                                    </div>
                                                    <div>
                                                        <p>Стоимость</p>
                                                        <h2 class="sum_number"> <?= $product->price * $product->count ?> <span class="small">₽</span> </h2>
                                                    </div>
                                                </div>

                                                <?php if ($order->status_of_order_id == "3") : ?>
                                                    <div><button class="addReview" data-product-id="<?= $product->product_id ?>">Оставить отзыв</button></div>
                                                <?php endif ?>
                                            </div>
                                        </div>


                                    </div>


                                <?php endforeach ?>
                            </div>
                        </div>
                    <?php endif ?>
                    <?php if (count($ordersRecipes[$order->id]) > 0) : ?>
                        <div class="recipe_in_order_block">
                            <h2>Рецепты в заказе</h2>
                            <div class="recipe_in_order_table">
                                <?php foreach ($ordersRecipes[$order->id] as $recipe) : ?>
                                <div class="classultimaTr">
                                        <div class="center_align">
                                            <div class="order_product_title">
                                                <div class="imgBlocck"><img src="/assets/images/ricipe_icon.png" alt=""></div>
                                                <div class="order_product_name_and_price">
                                                <h2 class="word_Wrap">  <a href="/app/tables/recipes/showRecipe.php?id=<?= $recipe->number  ?>"><?= $recipe->name != null ? (mb_strlen($recipe->name) > 15? '"'. mb_substr($recipe->name, 0, 15).'...'.'"' : '"'. $recipe->name.'"' ): "№".$recipe->number ?></a></h2>
                                                <h2 class=" classOrderPriceGrid"> <?= $recipe->price ?>₽</h2>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="center_align2">
                                            <div class="content_prod_table">
                                                <div class="content_prod_table_info">
                                                    <div>
                                                        <p>Количество</p>
                                                        <h2 class="count_number"><?= $recipe->count ?> <span class="small"> шт</span></h2>
                                                    </div>
                                                    <div>
                                                        <p>Стоимость</p>
                                                        <h2 class="sum_number"> <?= $recipe->price * $recipe->count ?> <span class="small">₽</span> </h2>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>


                                    </div>
                                    <!-- <div class="arrrrrrr">
                                            <div>


                                            

                                            </div>
                                            <div>
                                            <h2 class="text_centr">Количество >шт</h2>

                                            <h2 class="text_centr">Стоимость ₽</h2>
                                            </div>




                                    </div> -->


                                <?php endforeach ?>
                            </div>
                        </div>
                    <?php endif ?>
                    <div class="order_itogi">

                        <h2 class="text_centr">Количество товаров: <?= $order->count + $order->countRic ?> шт</h2>
                        <h2 class="text_centr">Итого <?= $order->sum ?> руб</h2>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>

</main>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/footer.php"; ?>
<script src="/assets/js/feach.js"></script>
<script src="/assets/js/Profile.js"></script>