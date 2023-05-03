<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/header.php"; ?>
<main id="index_main">
    <h1 class="word_Wrap"><?=$recipe->name != null?"Название рецепта ".$recipe->name : "Номер рецепта ".  $recipe->id ?></h1>
    <div class="showRecipe">
    <div class="showRecipe_ingredient_list_block">
        <h2 class="showRecipe_ingredient_list_title">Список ингредиентов</h2>
        <div class="showRecipe_ingredient_list">
        <?php foreach($recipeIngredients as $ingredient):?>
            <div class="showRecipe_ingredient">
                <h3><?=$ingredient->ingredient?></h3>
                <p>Количество <?=$ingredient->weight_G?> грамм</p>
                <p>Калорийность на 100 грамм <?=$ingredient->calories_100g?> Ккал</p>
                <p>Цена за 100 грамм <?=$ingredient->price_100g?> рублей</p>
                <p>Стоимость <?=$ingredient->weight_G * $ingredient->price_100g /100?> рублей</p>
            </div>
        <?php endforeach?>
        </div>
    </div>
    <div class="showRecipe_steps_block">
        <h2>Шаги изготовления</h2>
        <div class="showRecipe_steps">
        <?php foreach($steps as $step):?>
            <div class="showRecipe_step">
                <h3>Шаг № <?=$step->step_number?></h3>
                <p class="word_Wrap"><?=$step->discription?></p>
                <img class="step_img_for_show" src="/upload/<?=$step->image == null ? "placeholder.png":$step->image?>" alt="">
            </div>
        <?php endforeach?>
        </div>

    </div>
    </div>

    <div class="showRecipe_itogi">
    <h2 class="w320TextCenter">Итого по рецепту <?= $recipe->price?> рублей</h2>
    <h2 class="w320TextCenter">Срок годности <?= $recipe->self_live_days?> дней</h2>
    <button class="addRecipeInBasket" data-recipe-id="<?= $recipe->id ?>">В корзину</button>
    <button class="delRecipe" value="<?= $recipe->id ?>" data-recipe-id="<?= $recipe->id ?>" data-recipe-name = "<?=$recipe->name != null?$recipe->name :  $recipe->id ?>" <?=$recipe->countInOrders>0?"disabled":""?> title="<?=$recipe->countInOrders>0?"Данный рецепт невозможно удалить так как он находится внутри ваших действующих заказов":""?>">Удалить рецепт</button>
    </div>

</main>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/footer.php"; ?>
<script src="/assets/js/feach.js"></script>
        <script src="/assets/js/showRecipe.js"></script>
