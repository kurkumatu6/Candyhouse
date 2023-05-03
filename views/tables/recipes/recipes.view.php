<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/header.php"; ?>
<main id="index_main" class="price">
    <div class="recipes_comand_block">
        <h2>Глосарий и поиск</h2>
    <div class="glossary close">
        <?php foreach ($UserIngredients as $char => $ingredients) : ?>
            <div class="char_block">
            <h2 class="chars" data-char="<?= $char ?>"><?= $char ?></h2>
            <div class="ingredients_block close" data-char="<?= $char ?>">


                <?php foreach ($ingredients as $ingredient) : ?>
                    <p class="ingredientSelector" data-ingredient-id="<?= $ingredient->ingredient_id ?>"><?= $ingredient->name ?>-<?= $ingredient->count ?></p>
                <? endforeach ?>
            </div>
            </div>

        <? endforeach ?>
    </div>
    <div class="serchBlock close">
        <input type="text" id="serchText" class="serch_on_recipes">
        <button class="btnSerch serch_on_recipes_button">Поиск</button>
    </div>
    <button class="recipes_comand_block_open_close">↓</button>
    </div>

    <h2 class="recipesListHeader">Мои рецепты</h2>
    <div class="recipes">
        <?php foreach ($recipes as $recipe) : ?>
            <div class="recipeFromList">
                <h2 class="recipeFromListHeader word_Wrap"><a href="/app/tables/recipes/showRecipe.php?id=<?= $recipe->id ?>"><?=$recipe->name != null?"Название рецепта ".$recipe->name : "Номер рецепта ".  $recipe->id ?></a> </h2>
                <div class="ingredientListFromRecipe">
                    <h3 class="text_centr">Ингредиенты</h3>
                    <?php foreach ($ingredientsInRecipes[$recipe->id] as $ingredient) : ?>
                        <h4 class="word_Wrap"><?= $ingredient->ingredient ?></h4>
                    <?php endforeach ?>
                </div>
                <div class="steps">
                    <?php if (count( $discriptionsInRecipes[$recipe->id]) >= 1):?>
                    <h3 class="text_centr">Шаги изготовления</h3>
                    <div class="step_in_save_recipe">
                        <h4>Шаг № <?= $discriptionsInRecipes[$recipe->id][0]->step_number ?></h4>
                        <div class="step_body_in_save_recipe">
                            <p class="word_Wrap recipeStepDiscript text_centr"><?= $discriptionsInRecipes[$recipe->id][0]->discription ?></p>
                            <?php if ($discriptionsInRecipes[$recipe->id][0]->image != null):?>
                            <img src="/upload/<?= $discriptionsInRecipes[$recipe->id][0]->image ?>" alt="" class="recipe_step_image">
                            <?php endif?>
                        </div>

                    </div>
                    <?php endif?>
                    <!-- <?php if (count( $discriptionsInRecipes[$recipe->id]) >= 2):?>
                    <div class="step">
                        <h4>Шаг № <?= $discriptionsInRecipes[$recipe->id][1]->step_number ?></h4>
                        <div class="step_body">
                            <p class="word_Wrap"><?= $discriptionsInRecipes[$recipe->id][1]->discription ?></p>
                            <img src="/upload/<?= $discriptionsInRecipes[$recipe->id][1]->image ?>" alt="" class="recipe_step_image">
                        </div>

                    </div>
                    <?php endif?> -->

                </div>
                <div class="reciresControls">
                <button class="addRecipeInBasket" data-recipe-id="<?= $recipe->id ?>">В корзину</button>
                <button class="delRecipe" value="<?= $recipe->id ?>" data-recipe-id="<?= $recipe->id ?>" data-recipe-name = "<?=$recipe->name != null?$recipe->name :  $recipe->id ?>" <?=$recipe->countInOrders>0?"disabled":""?> title="<?=$recipe->countInOrders>0?"\n Данный рецепт невозможно удалить так как он находится внутри ваших действующих заказов":""?>">Удалить рецепт</button>
                </div>

            </div>
        <?php endforeach ?>
    </div>
</main>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/footer.php"; ?>
<script src="/assets/js/feach.js"></script>
<script src="/assets/js/recipes.js"></script>