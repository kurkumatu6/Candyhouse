<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/header.php"; ?>
<main class="construct_main">
    <!-- <div class="recipe_category_block">
        <select name="" id="recipe_category">
            <?php foreach ($categories as $category) : ?>
                <option value="<?= $category->id ?>"><?= $category->category ?></option>

            <?php endforeach ?>
        </select>
    </div> -->
    <div class="construct_ric">

        <form class="recipe_block" method="POST" enctype="multipart/form-data" action="/app/tables/recipes/saveRecipe.php">
            <h2 class="self_centr recipe_title">Название рецепта</h2>
            <input type="text" name="recipe_name" class="recipe_name">
            <div class="recipe">
                <h2 class="self_centr construct_ingerdient_list">Список ингредиентов</h2>
                <div class="recipe_ingr">

                </div>

            </div>
            <p><?= $_SESSION["error"]["ingredient_ilst"]??""?></p>
            <div class="discript_block">
                <h2 class="self_centr discript_title">Описание</h2>
                <div class="steps">
                    <div class="step_block" data-step-number="1">
                        <h2 class="step_title">Шаг 1</h2>
                        <div class="step_body">
                            <textarea name="step1" class="step" data-step-number="1" cols="30" rows="10"></textarea>
                            <div class="step_img_block">
                                <label for="img1" id="img_title1"  class="step_img_title">Добавить картинку</label>
                                <input type="file" data-id="1" class="image_step_add" name="img1" id="img1" style="display: none">
                                <input type="text" name="steps-id[]" value="1" style="display: none">
                                <div class="spec" id="spec1">
                                
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="stepAdd">
                        <h2>Добавить шаг</h2>
                        <h2 class="stepAddButton">+</h2>
                    </div>
                </div>

            </div>
            <div>
                <div class="construct_itog">
                    <h2>Итого по рецепту</h2>
                    <p class="price"></p>
                    <p class="calory"></p>
                </div>

                <button class="complitRecipe" <?= $_SESSION["auth"] ?? false ? "" : "disabled" ?>>Сохранить Рецепт</button>
                <p style="display:<?= !isset($_SESSION["auth"]) ? "block" : "none" ?>">Для сохранения рецепта нужно авторизоваться</p>
            </div>

        </form>
        <div class="ingredient_list_block">
            <h2 class="ingredient_list_title">Список ингредиентов</h2>
            <div class="ingredient_list">
                <?php foreach ($ingredientsByCategory as $category => $ingredients) : ?>
                    <div class="ingredient_list_category">
                        <h2 class="ingredient_list_category_title"><?= $category ?></h2>
                        <?php foreach ($ingredients as $ingredient) : ?>
                            <div>
                                <div class="ingredient draggable" draggable="true" data-calories="<?= $ingredient->calories_100g ?>" data-self-life-days="<?= $ingredient->self_life_days ?>" data-price="<?= $ingredient->price_100g ?>" data-name="<?= $ingredient->ingredient ?>" data-id="<?= $ingredient->id ?>">
                                    <h2><?= $ingredient->ingredient ?></h2>
                                    <h2>Цена за 100 грамм <?= (int)$ingredient->price_100g ?> руб</h2>
                                    <img src="/upload/<?= $ingredient->image ?>" alt="">
                                    <!-- <h2><? //$ingredient->calories_100g 
                                                ?></h2>
                                    <h2><? //$ingredient->self_life_days 
                                        ?></h2> -->
                                </div>
                            </div>
                        <?php endforeach ?>

                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</main>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/footer.php"; ?>
<script src="/assets/js/feach.js"></script>
<script src="/assets/js/construct.js"></script>
<!-- ingredientInRecipe -->