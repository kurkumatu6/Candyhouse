<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/adminHeader.php"; ?>
<main id="adminMain_main">
    <h1 class="title">Справочники</h1>
    <div class="tabelBlock tabelBlock_refer">
        <div class="categories_block">
            <div class="small_table_block">
                <h2>Категории товаров</h2>
                <table id="prodCategoriesTable" class="small_table">
                    <tr>
                        <td>id</td>
                        <td>Название</td>
                        <td></td>
                    </tr>
                    <?php foreach ($productsCategorys as $prodCategory): ?>
                        <tr>
                            <td>
                                <?= $prodCategory->id ?>
                            </td>
                            <td>
                                <?= $prodCategory->category ?>
                            </td>
                            <td>
                            <button class="delProductCategory delButton" type="button" data-prod-category-id="<?= $prodCategory->id ?>" data-prod-category-name="<?= $prodCategory->category ?>" value="<?= $prodCategory->id ?>">Удалить</button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </table>
                <form action="/app/admin/adminReferenceBooksLoader.php" method="POST">
                    <div>
                    <label for="">Название</label>
                    <input type="text" name="addProdCategoryName" id="addProdCategoryName">
                    </div>

                    <button class="addProdCategory" name="addProdCategory">Добавить категорию продуктов</button>
                    <p class="error"><?= $_SESSION["error"]["addProdCategory"]??""?></p>
                </form>

            </div>
            <div class="small_table_block">
                <h2>Категории ингредиентов</h2>
                <table id="ingrCategoriesTable" class="small_table">
                    <tr>
                        <td>id</td>
                        <td>Название</td>
                        <td></td>
                    </tr>
                    <?php foreach ($ingredientsCategorys as $ingredientCategory): ?>
                        <tr>
                            <td>
                                <?= $ingredientCategory->id ?>
                            </td>
                            <td>
                                <?= $ingredientCategory->name ?>
                            </td>
                            <td>
                            <button class="delIngredientCategory delButton" data-ingr-category-id="<?= $ingredientCategory->id ?>" data-ingr-category-name="<?= $ingredientCategory->name ?>" value="<?= $ingredientCategory->id ?>">Удалить</button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </table>
                <form action="/app/admin/adminReferenceBooksLoader.php" method="POST">
                    <div>
                    <label for="">Название</label>
                    <input type="text" name="addIngredientCategoryName">
                    </div>

                    <button name="addIngredientCategory" type="button" class="addIngredientCategory ">Добавить категорию ингредиентов</button>
                    <p class="error"><?= $_SESSION["error"]["addIngrCategory"]??""?></p>
                </form>

            </div>
        </div>
        <div class="statuses_block">
            <div class="small_table_block">
                <h2>Статусы клиентов</h2>
                <table id="clientStatusesTable" class="small_table">
                    <tr>
                        <td>id</td>
                        <td>Название</td>
                        <td></td>
                    </tr>
                    <?php foreach ($clientsStatuses as $clientsStatus): ?>
                        <tr>
                            <td>
                                <?= $clientsStatus->id ?>
                            </td>
                            <td>
                                <?= $clientsStatus->status ?>
                            </td>
                            <td>
                            <button class="delClientsSatus delButton" type="button" data-client-status-id="<?= $clientsStatus->id ?>" data-client-status-name="<?= $clientsStatus->status ?>" value="<?= $clientsStatus->id ?>">Удалить</button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </table>
                <form action="/app/admin/adminReferenceBooksLoader.php" method="POST">
                    <div>
                    <label for="">Название</label>
                    <input type="text" name="addClientsStatusName">
                    </div>

                    <button name="addClientsStatus" class="addClientsStatus">Добавить статус клиентов</button>
                    <p class="error"><?= $_SESSION["error"]["addClientStatus"]??""?></p>
                </form>

            </div>
            <div class="small_table_block">
                <h2>Статусы заказов</h2>
                <table id="orderStatusesTable" class="small_table">
                    <tr>
                        <td>id</td>
                        <td>Название</td>
                        <td></td>
                    </tr>
                    <?php foreach ($orderStatuses as $orderStatus): ?>
                        <tr>
                            <td>
                                <?= $orderStatus->id ?>
                            </td>
                            <td>
                                <?= $orderStatus->status ?>
                            </td>
                            <td>
                                <button class="delOrderStatus delButton" data-order-status-id="<?= $orderStatus->id ?>" data-order-status-name="<?= $orderStatus->status ?>" value="<?= $orderStatus->id ?>">Удалить</button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </table>
                <form action="/app/admin/adminReferenceBooksLoader.php" method="POST">
                    <div>
                    <label for="">Название</label>
                    <input type="text" name="addOrdersStatusName">
                    </div>

                    <button name="addOrdersStatus" class="addOrdersStatus">Добавить статус заказов</button>
                    <p class="error"><?= $_SESSION["error"]["addOrderStatus"]??""?></p>
                </form>

            </div>
        </div>
        <?php if(isset($_SESSION["super"]["admin"]) && $_SESSION["super"]["admin"]??false ):?>
        <form action="/app/admin/adminReferenceBooksLoader.php" class="adminAddForm" method="POST">
            <h2>Добавление нового администратора</h2>
            <label for="">Login</label>
            <input type="text" name="addAdminLogin">
            <label for="">Password</label>
            <input type="text" name="addAdminPassword" >

            <button name="addAdmin" class="addAdmin">Добавить администратора</button>
            <p class="error"><?= $_SESSION["error"]["addAdmin"]??""?></p>
        </form>
        <?php endif?>
    </div>
</main>
</body>
<script src="/assets/js/feach.js"></script>
<script src="/assets/js/admin/adminReferenc.js"></script>

</html>