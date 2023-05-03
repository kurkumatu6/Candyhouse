<?php
        
require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/adminHeader.php";?>
    <main id="adminMain_main">
    <h1 class="title">Список продуктов</h1>
        <div class="tabelBlock">
        <p class="error"><?=$_SESSION["error"]["prodAdd"]??""?></p>
            <div class="productControls productSelectors">
                <div class="categorySelectorBlock">
                <label for="selectCategory" class="white">Категория</label>
                <select name="selectCategory" id="selectCategory">
                    <option value="all">Все</option>
                    <?php foreach($categories as $category):?>
                    <option value="<?=$category->id?>" ><?=$category->category?></option>
                    <?php endforeach?>
                </select>
                </div>

                <button id="sort" class="product_price_sort_button">Цена</button>
                <div class="serch_block">
                <input type="text" id="serchName">
                <button class="serchConfirm">Поиск</button>
                </div>
                
            </div>
            <table id="productTable">
                <tr>
                    <td >Название</td>
                    <td>Категория</td>
                    <td class="td_product_price">Цена</td>
                    <td class="td_product_count">Покупок за прошлый месяц</td>
                    <td class="td_product_buttons" id="head_td_buttons_order"></td>
                </tr>
                <?php foreach($products as $product):?>
                <tr>
                <td class="name"><?= $product->name?></td>
                    <td><?= $product->category?></td>
                    <td class="td_product_price"><?= $product->price?></td>
                    <td class="td_product_count"><?=$productsCount[$product->id]->count?></td>
                    <td class="td_product_buttons">
                        <div>
                        <button class="delProduct" data-product-id="<?=$product->id?>">Удалить</button>
                        <button class="changeProduct" data-product-id="<?=$product->id?>">Изменить</button>
                        <input type="checkbox" name="" id="" class="delChecks"   data-product-id="<?=$product->id?>">
                        </div>


                    </td>
                </tr>

                <?php endforeach?>
            </table>
            <button id="addProduct" class="addProduct">Добавить продукт</button>
            <button id="delMassProduct" class="delMassProduct">Удалить помеченные</button>

        </div>

    </main>
<script src="/assets/js/feach.js"></script>
<script src="/assets/js/admin/adminProduct.js"></script>
</body>

</html>