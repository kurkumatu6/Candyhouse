document.addEventListener("click", function(e){
    if(e.target.classList.contains("addRecipeInBasket")){
        console.log(postJSON("/app/tables/recipes/addRecipe.php", e.target.dataset.recipeId, "addRecipeInBusket"));
    }
    if(e.target.classList.contains("delRecipe")){
        document.querySelector("body").insertAdjacentHTML("beforeend", `
        <div class="modal-wrapper">
          <div class="modal delRecipeModal">
            <div class="delRecipeBlock">
                <h2>Вы действительно хотите удалить рецепт "${e.target.dataset.recipeName}"</h2>
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