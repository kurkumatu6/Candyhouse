<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/adminHeader.php";
?>
<main id="adminMain_main">
    <h1 class="title">Список ингредиентов</h1>
    <div class="tabelBlock">
        <div class="ingredientControls">
            <div class="categorySelectorBlock">
                <label for="selectCategory" class="white">Категория</label>
                <select name="selectCategory" id="selectCategory">
                    <option value="all">Все</option>
                    <?php foreach ($categorys as $category): ?>
                        <option value="<?= $category->id ?>"><?= $category->name ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <button id="sort" class="sort ingredient_price_sort_button">Цена</button>
            <div class="serch_block">
                <input type="text" id="serchName">
                <button class="serchConfirm">Поиск</button>
            </div>

        </div>
        <table id="ingredientTable">
            <tr>
                <td class="td_ingredient_name">Название</td>
                <td class="td_ingredient_category">Категория</td>
                <td class="td_ingredient_price">Цена за 100 грамм</td>
                <td class="td_ingredient_calory">Калорийность</td>
                <td class="td_ingredient_slef_life">Срок годности</td>
                <td class="td_ingredient_buttons"></td>
            </tr>
            <?php foreach ($ingredients as $ingredient): ?>
                <tr>
                    <td class="name">
                        <?= $ingredient->ingredient ?>
                    </td>
                    <td class="">
                        <?= $ingredient->category ?>
                    </td>
                    <td class="td_ingredient_price">
                        <?= $ingredient->price_100g ?>
                    </td>
                    <td class="td_ingredient_calory"><?= $ingredient->calories_100g ?></td>
                    <td class="td_ingredient_slef_life"><?= $ingredient->self_life_days ?></td>
                    <td class="td_ingredient_buttons">
                        <div>
                            <button class="delIngredient" data-ingredient-id="<?= $ingredient->id ?>">Удалить</button>
                            <button class="changeIngredient" data-ingredient-id="<?= $ingredient->id ?>">Изменить</button>
                            <input type="checkbox" name="" id="" class="delChecks"
                                data-ingredient-id="<?= $ingredient->id ?>">
                        </div>
                    </td>
                </tr>

            <?php endforeach ?>
        </table>
        <button id="addIngredient" class="addIngredient">Добавить ингредиент</button>
        <button id="delMassIngredient" class="delMassIngredient">Удалить помеченные</button>
        <p>
            <?= $_SESSION["error"]["prodAdd"] ?? "" ?>
        </p>
    </div>
    </div>
</main>

</body>
<script src="/assets/js/feach.js"></script>
<script src="/assets/js/admin/adminIngredients.js"></script>

</html>