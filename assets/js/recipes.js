
document.addEventListener("click", function(e){
        if(e.target.classList.contains("addRecipeInBasket")){
            console.log(postJSON("/app/tables/recipes/addRecipe.php", e.target.dataset.recipeId, "addRecipeInBusket"));
        }
        if(e.target.classList.contains("recipes_comand_block_open_close")){
            let glossary = document.querySelector(".glossary")
            let serchBlock = document.querySelector(".serchBlock")
            if(glossary.classList.contains("close") && serchBlock.classList.contains("close")){
                e.target.textContent = "↑"
                glossary.classList.add("openflex")
                serchBlock.classList.add("openflex")
                serchBlock.classList.remove("close")
                glossary.classList.remove("close")
            }
            else if(glossary.classList.contains("openflex") && serchBlock.classList.contains("openflex")){
                e.target.textContent = "↓"
                glossary.classList.add("close")
                serchBlock.classList.add("close")
                serchBlock.classList.remove("openflex")
                glossary.classList.remove("openflex")
            }
        }
        if(e.target.classList.contains("ingredientSelector")){
            // console.log(postJSON("/app/tables/recipes/addRecipe.php", e.target.dataset.ingredientId, "getAllUserRecipesByIngredient"));
            document.querySelector(".recipes").innerHTML = "";
            postJSON("/app/tables/recipes/addRecipe.php", e.target.dataset.ingredientId, "getAllUserRecipesByIngredient").then(function(value){
                value.productInBasket.forEach(element => {
                    // console.log(element);
                    document.querySelector(".recipes").insertAdjacentHTML("beforeend", `
                    <div class="recipeFromList">
                    <h2 class="recipeFromListHeader word_Wrap"><a href="/app/tables/recipes/showRecipe.php?id=${element.id}">${element.name != null?`Название рецепта ${element.name}`: `Номер рецепта ${element.recipe_id}`}</a> </h2>
                    <div id="ingredients${element.id}" class="ingredientListFromRecipe" >
                        <h3 class="text_centr">Ингредиенты</h3>
                    </div>
                    <div id="steps${element.id}" class="steps">
                    <h3 class="text_centr">Шаги изготовления</h3>
        
        
                    </div>
                    <div class="reciresControls">
                    <button class="addRecipeInBasket" data-recipe-id="${element.id}">В корзину</button>
                    <button class="delRecipe" data-recipe-id="${element.id}" data-recipe-name = "${element.name != null?element.name: element.recipe_id}">Удалить рецепт</button>
                    </div>
                </div>
                    `)
                   console.log( postJSON("/app/tables/recipes/addRecipe.php", element.id, "getAllIngredientsInRecipes"));
                   postJSON("/app/tables/recipes/addRecipe.php", element.id, "getAllIngredientsInRecipes").then(function(value){
                    value.productInBasket.forEach(item => {
                        document.querySelector(`#ingredients${item.recipe_id}`).insertAdjacentHTML("beforeend", `<h4>${item.ingredient}</h4>`)
                    })
                   })
                   postJSON("/app/tables/recipes/addRecipe.php", element.id, "getAllIDiscriptionsInRecipes").then(function(value){
                    if(value.productInBasket[0].image == null){
                        document.querySelector(`#steps${element.recipe_id}`).insertAdjacentHTML("beforeend", `                
                        <div class="step_in_save_recipe">
                        <h4>Шаг № ${value.productInBasket[0].step_number}</h4>
                        <div class="step_body_in_save_recipe text_centr">
                            <p class="word_Wrap text_centr">${value.productInBasket[0].discription}</p>
                        </div>
                        </div>
    
                        `)
                    }
                    else{
                        document.querySelector(`#steps${element.recipe_id}`).insertAdjacentHTML("beforeend", `                
                        <div class="step_in_save_recipe">
                        <h4>Шаг № ${value.productInBasket[0].step_number}</h4>
                        <div class="step_body_in_save_recipe text_centr">
                            <p class="word_Wrap text_centr">${value.productInBasket[0].discription}</p>
                            <img src="/upload/${value.productInBasket[0].image}" alt="" class="recipe_step_image">
                        </div>
                        </div>
    
                        `)
                    }
                   })
                //    console.log( postJSON("/app/tables/recipes/addRecipe.php", element.id, "getAllIDiscriptionsInRecipes"));
                });
            })
        }
    if(e.target.classList.contains("btnSerch")){
        let serch = document.querySelector("#serchText").value
        console.log( postJSON("/app/tables/recipes/addRecipe.php", serch, "getSerchRecipes"))
        document.querySelector(".recipes").innerHTML = "";
        postJSON("/app/tables/recipes/addRecipe.php", serch, "getSerchRecipes").then(function(value){
            value.productInBasket.forEach(element => {
                // console.log(element);
                document.querySelector(".recipes").insertAdjacentHTML("beforeend", `

            <div class="recipeFromList">
            <h2 class="recipeFromListHeader word_Wrap"><a href="/app/tables/recipes/showRecipe.php?id=${element.recipe_id}"> ${element.name != null?`Название рецепта ${element.name}`: `Номер рецепта ${element.recipe_id}`}</a> </h2>
            <div id="ingredients${element.recipe_id}" class="ingredientListFromRecipe">
                <h3 class="text_centr">Ингредиенты</h3>
            </div>
            <div id="steps${element.recipe_id}" class="steps">
            <h3 class="text_centr">Шаги изготовления</h3>


            </div>
            <div class="reciresControls">
            <button class="addRecipeInBasket" data-recipe-id="${element.id}">В корзину</button>
            <button class="delRecipe" data-recipe-id="${element.id}" data-recipe-name = "${element.name != null?element.name: element.recipe_id}">Удалить рецепт</button>
            </div>

        </div>
                `)
            //    console.log( postJSON("/app/tables/recipes/addRecipe.php", element.recipe_id, "getAllIngredientsInRecipes"));
               postJSON("/app/tables/recipes/addRecipe.php", element.recipe_id, "getAllIngredientsInRecipes").then(function(value){
                value.productInBasket.forEach(item => {
                    document.querySelector(`#ingredients${element.recipe_id}`).insertAdjacentHTML("beforeend", `<h4>${item.ingredient}</h4>`)
                })
               })
               postJSON("/app/tables/recipes/addRecipe.php", element.recipe_id, "getAllIDiscriptionsInRecipes").then(function(value){
                // value.productInBasket[0]
                if(value.productInBasket[0].image == null){
                    document.querySelector(`#steps${element.recipe_id}`).insertAdjacentHTML("beforeend", `                
                    <div class="step_in_save_recipe">
                    <h4>Шаг № ${value.productInBasket[0].step_number}</h4>
                    <div class="step_body_in_save_recipe text_centr">
                        <p class="word_Wrap text_centr">${value.productInBasket[0].discription}</p>
                    </div>
                    </div>

                    `)
                }
                else{
                    document.querySelector(`#steps${element.recipe_id}`).insertAdjacentHTML("beforeend", `                
                    <div class="step_in_save_recipe">
                    <h4>Шаг № ${value.productInBasket[0].step_number}</h4>
                    <div class="step_body_in_save_recipe text_centr">
                        <p class="word_Wrap text_centr">${value.productInBasket[0].discription}</p>
                        <img src="/upload/${value.productInBasket[0].image}" alt="" class="recipe_step_image">
                    </div>
                    </div>

                    `)
                }


               })
            //    console.log( postJSON("/app/tables/recipes/addRecipe.php", element.recipe_id, "getAllIDiscriptionsInRecipes"));
            });
        })
    }
    if(e.target.classList.contains("chars")){
        document.querySelectorAll(".ingredients_block").forEach(item => {
            if(item.dataset.char == e.target.dataset.char){
                if(item.classList.contains("open")){
                    item.classList.add("close")
                    item.classList.remove("open")
                    // console.log(item)
                }
                else if(item.classList.contains("close")){
                    item.classList.add("open")
                    item.classList.remove("close")
                    // console.log(item)
                }
            }
        })
    }
    if(e.target.classList.contains("delRecipe")){
        document.querySelector("body").insertAdjacentHTML("beforeend", `
        <div class="modal-wrapper">
          <div class="modal delRecipeModal">
            <div class="delRecipeBlock">
                <h2 class="word_Wrap">Вы действительно хотите удалить рецепт "${e.target.dataset.recipeName}"</h2>
                <form action="/app/tables/recipes/addRecipe.php" method="POST">
                <button class="delRecipeConfirm" value="${e.target.dataset.recipeId}" name="delRecipeConfirm" data-product-id="${e.target.dataset.recipeId}">Подтвердить удаление</button>
                </form>

            </div>

          </div>
        </div>
        `)
        modal = document.querySelector(".modal-wrapper")
        modal.addEventListener("click", function(e){
          if(e.target == e.currentTarget){
            modal.remove()
          }
        })
        document.addEventListener("keyup", function(e){
          console.log(e.key)
          if(e.key == "Escape"){
            modal.remove()
          }
        })
    }

})
// <?php foreach($ingredientsInRecipes[$recipe->id] as $ingredient):?>
// <h4><?=$ingredient->ingredient?></h4>
// <?php endforeach?>
// <?php foreach($discriptionsInRecipes[$recipe->id] as $discription):?>
// <h4>Шаг № <?=$discription->step_number?></h4>
// <p><?=$discription->discription?></p>
// <?php endforeach?>
{/* <div>
<h2>Номер рецепта ${element.recipe_id}</h2>
<div id="ingredients${element.recipe_id}">
    <h3>Ингредиенты</h3>

</div>
<div id="steps${element.recipe_id}">
<h3 >Шаги изготовления</h3>

</div>
<button class="addRecipeInBasket" data-recipe-id="${element.id}">В корзину</button>
</div> */}