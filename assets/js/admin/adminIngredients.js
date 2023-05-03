let sort = true
let delIngredientsIds = []
let categoriesTry = true;
async function showIngredients(orders, sort= true){
    // orders = showOrders(postJSON("/app/admin/adminOrdersJsLoader.php", document.querySelector("#selectStatus").value, "getOrdersByStatus"))
    let table = document.querySelector("#ingredientTable>tbody")
    table.innerHTML =`                <tr>
    <td class="td_ingredient_name">Название</td>
    <td class="td_ingredient_category">Категория</td>
    <td class="td_ingredient_price">Цена за 100 грамм</td>
    <td class="td_ingredient_calory">Калорийность</td>
    <td class="td_ingredient_slef_life">Срок годности</td>
    <td class="td_ingredient_buttons"></td>
</tr>`

    orders.then(async function(value){
        arr = value.productInBasket;
        if(sort){
            arr.sort((a,b)=> a.price_100g - b.price_100g)
            document.querySelector("#sort").textContent = "Цена ↑"
        }
        else{
            arr.sort((a,b)=> b.price_100g - a.price_100g)
            document.querySelector("#sort").textContent = "Цена ↓"
        }
        arr.forEach(element => {

            table.insertAdjacentHTML("beforeend", `
            <tr>
            <td class="td_ingredient_name">${element.ingredient}</td>
                <td class="td_ingredient_category">${element.category}</td>
                <td class="td_ingredient_price">${element.price_100g}</td>
                <td class="td_ingredient_calory">${element.calories_100g}</td>
                <td class="td_ingredient_slef_life">${element.self_life_days}</td>
                <td class="td_ingredient_buttons">
                <div>
                
                <button class="delIngredient" data-ingredient-id="${element.id}">Удалить</button>
                <button class="changeIngredient" data-ingredient-id="${element.id}">Изменить</button>
                <input type="checkbox" name="" id="" class="delChecks"   data-ingredient-id="${element.id}">
                </div>


                </td>
            </tr>
            `)
        });

    })
}
document.querySelector("#selectCategory").addEventListener("change", function(e){
    categoriesTry = true;
    showIngredients(postJSON("/app/admin/adminIngredientsJsLoader.php", e.currentTarget.value, "getIngredientsByCategory"), sort)
})
document.addEventListener("click", async function(e){
    if(e.target.classList.contains("sort")){
        sort = !sort
        if(categoriesTry){
            let ingredientsCategorys = postJSON("/app/admin/adminIngredientsJsLoader.php", document.querySelector("#selectCategory").value, "getIngredientsByCategory");
            console.log(document.querySelector("#selectCategory").value);
            showIngredients( ingredientsCategorys, sort )
        }
        else{
            let serchProducts = postJSON("/app/admin/adminIngredientsJsLoader.php", document.querySelector("#serchName").value, "IngredientBySech");
            showIngredients( serchProducts,sort )
        }
    }
    if(e.target.classList.contains("serchConfirm")){
        serchProducts = postJSON("/app/admin/adminIngredientsJsLoader.php", document.querySelector("#serchName").value, "IngredientBySech")
        showIngredients( serchProducts, sort )
    }
    if(e.target.classList.contains("delIngredient")){
        document.querySelector("body").insertAdjacentHTML("beforeend", `
        <div class="modal-wrapper">
          <div class="modal delModal">
            <div class="delModalDiv">
                <h2>Вы действительно хотите удалить данный ингредиент: </h2>
                <button class="delIngredientConfirm" data-product-id="${e.target.dataset.ingredientId}">Подтвердить удаление</button>
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
    if(e.target.classList.contains("delIngredientConfirm")){
        postJSON("/app/admin/adminIngredientsJsLoader.php", e.target.dataset.productId, "delIngredient").then(async function(){
            document.querySelector(".modal-wrapper").remove();
            if(categoriesTry){
             let ingredientsCategorys = postJSON("/app/admin/adminIngredientsJsLoader.php", document.querySelector("#selectCategory").value, "getIngredientsByCategory");
             console.log(document.querySelector("#selectCategory").value);
             await showIngredients( ingredientsCategorys, sort )
         }
         else{
             let serchProducts = postJSON("/app/admin/adminIngredientsJsLoader.php", document.querySelector("#serchName").value, "IngredientBySech");
             await showIngredients( serchProducts,sort )
         }
        });

   }

   if(e.target.classList.contains("addIngredient")){
    document.querySelector("body").insertAdjacentHTML("beforeend", `
    <div class="modal-wrapper">
      <div class="modal addIngredientModal">
        <form id="addIngredientForm" method="POST">
            <h2>Добавление ингредиента</h2>
            <div>
                <h3>Название</h3>
                <input class="bigInp" type="text" name="name">
            </div>
            <div>
                <h3>Цена за 100 грамм</h3>
                <input class="mimiInp" type="number" name="price_100g">
            </div>
            <div>
                <h3>Калорийность на 100 грамм</h3>
                <input class="mimiInp" type="number" name="calory">
            </div>
            <div>
                <h3>Срок годности</h3>
                <input class="mimiInp" type="number" name="self_life_days">
            </div>
            <div>
            <h3>Категория</h3>
                <select name="categoryInAddIngredient" id="categoryInAddIngredient">
                
                </select>
            </div>
            <button class="addIngredientConfirm buttonStyle" type="button" name="addIngredientConfirm">Сохранить</button>
        </form>

      </div>
    </div>
    `)
    postJSON("/app/admin/adminIngredientsJsLoader.php", "", "getAllIngredientsCategorys").then(function(value){
        let select = document.querySelector("#categoryInAddIngredient")
        value.productInBasket.forEach(item=>{
            select.insertAdjacentHTML("beforeend", `<option value="${item.id}">${item.name}</option>`)
        })
    })
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
   if(e.target.classList.contains("addIngredientConfirm")){
    postFormData("/app/admin/adminIngredientsJsLoader.php", document.querySelector("#addIngredientForm")).then(async function(){
        if(categoriesTry){
            let ingredientsCategorys = postJSON("/app/admin/adminIngredientsJsLoader.php", document.querySelector("#selectCategory").value, "getIngredientsByCategory");
            console.log(document.querySelector("#selectCategory").value);
            await showIngredients( ingredientsCategorys, sort )
        }
        else{
            let serchProducts = postJSON("/app/admin/adminIngredientsJsLoader.php", document.querySelector("#serchName").value, "IngredientBySech");
            await showIngredients( serchProducts,sort )
        }
        document.querySelector(".modal-wrapper").remove();
    })


   }
   if(e.target.classList.contains("delMassIngredient")){
    delIngredientsIds = []
        document.querySelectorAll(".delChecks").forEach(item =>{
            if(item.checked){
                delIngredientsIds.push(item.dataset.ingredientId)
            }
        })
        let text = ""
        if(delIngredientsIds.length>=5 && delIngredientsIds.length <= 15){
            text="ингредиентов"
        }
        else{
            if(delIngredientsIds.length%10 == 1){
                text="ингредиент"
            }
            if(delIngredientsIds.length%10 > 1 && delIngredientsIds.length%10 <= 4){
                text="ингредиентa"
            }
            if(delIngredientsIds.length%10 > 5 || delIngredientsIds.length%10 == 0){
                text="ингредиентов"
            }
        }
        document.querySelector("body").insertAdjacentHTML("beforeend", `
        <div class="modal-wrapper">
          <div class="modal delMassModal">
            <div class="delMassBlock">
                <h2 class="delMassTitle">Вы действительно хотите удалить ${delIngredientsIds.length} ${text}</h2>
                <div id="delIngrediensBlock" class=" delProductNames">
                
                </div>
                <div class="buttonsForMassDel">
                    <button class="showDelIngrediens">Показать удаляемые ингредиеты</button>
                    <button class="delMassIngredientConfirm" data-product-id="${e.target.dataset.ingredientId}">Подтвердить удаление</button>
                </div>
               
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
   if(e.target.classList.contains("showDelIngrediens")){
    let block = document.querySelector("#delIngrediensBlock")
    postJSON("/app/admin/adminIngredientsJsLoader.php", delIngredientsIds, "showDelMassIngredientsList").then(function(value){
        value.productInBasket.forEach(item=>{
            block.insertAdjacentHTML("beforeend", `<p>${item.ingredient}</p>`)
        })
    })
   }
   if(e.target.classList.contains("delMassIngredientConfirm")){
        postJSON("/app/admin/adminIngredientsJsLoader.php", delIngredientsIds, "delMassIngredients").then(async function(){
            document.querySelector(".modal-wrapper").remove();
            if(categoriesTry){
             let ingredientsCategorys = postJSON("/app/admin/adminIngredientsJsLoader.php", document.querySelector("#selectCategory").value, "getIngredientsByCategory");
             console.log(document.querySelector("#selectCategory").value);
             await showIngredients( ingredientsCategorys, sort )
         }
         else{
             let serchProducts = postJSON("/app/admin/adminIngredientsJsLoader.php", document.querySelector("#serchName").value, "IngredientBySech");
             await showIngredients( serchProducts,sort )
         }
        })

   }
   if(e.target.classList.contains("changeIngredient")){
    console.log(e.target.dataset.ingredientId)
    postJSON("/app/admin/adminIngredientsJsLoader.php", e.target.dataset.ingredientId , "getIngredient" ).then(function(ingredient){
        document.querySelector("body").insertAdjacentHTML("beforeend", `
        <div class="modal-wrapper">
          <div class="modal addIngredientModal">
            <form id="addIngredientForm" method="POST">
                <h2>Изменение ингредиента</h2>
                <div>
                    <h3>Название</h3>
                    <input class="bigInp" type="text" name="name" id="changeName" value="${ingredient.productInBasket.ingredient}">
                </div>
                <div>
                    <h3>Цена за 100 грамм</h3>
                    <input class="mimiInp" type="number" name="price_100g" id="changePrice_100g" value="${ingredient.productInBasket.price_100g}">
                </div>
                <div>
                    <h3>Калорийность на 100 грамм</h3>
                    <input class="mimiInp" type="number" name="calory" id="changeCalory" value="${ingredient.productInBasket.calories_100g}">
                </div>
                <div>
                    <h3>Срок годности</h3>
                    <input class="mimiInp" type="number" name="self_life_days" id="changeSelf_life_days" value="${ingredient.productInBasket.self_life_days}">
                </div>
                <div>
                <h3>Категория</h3>
                    <select name="categoryInAddIngredient" id="categoryInAddIngredient" >
                    
                    </select>
                </div>
                <button class="changeIngredientConfirm buttonStyle" type="button" data-ingredient-id="${ingredient.productInBasket.id}" name="addIngredientConfirm">Сохранить</button>
            </form>
    
          </div>
        </div>
        `)
        postJSON("/app/admin/adminIngredientsJsLoader.php", "", "getAllIngredientsCategorys").then(function(value){
            let select = document.querySelector("#categoryInAddIngredient")
            value.productInBasket.forEach(item=>{
                select.insertAdjacentHTML("beforeend", `<option value="${item.id}" ${item.id == ingredient.productInBasket.ingredient_category_id?"selected":""}>${item.name}</option>`)
            })
        })
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
    })
        
   }
   if(e.target.classList.contains("changeIngredientConfirm")){
    let data = {
        "id":e.target.dataset.ingredientId,
        "name": document.querySelector("#changeName").value,
        "price_100g": document.querySelector("#changePrice_100g").value,
        "calory": document.querySelector("#changeCalory").value,
        "self_life_days": document.querySelector("#changeSelf_life_days").value,
        "categoryInAddIngredient": document.querySelector("#categoryInAddIngredient").value,
    }
    postJSON("/app/admin/adminIngredientsJsLoader.php", data, "changeIngredientConfirm" )
    document.querySelector(".modal-wrapper").remove();
    if(categoriesTry){
     let ingredientsCategorys = postJSON("/app/admin/adminIngredientsJsLoader.php", document.querySelector("#selectCategory").value, "getIngredientsByCategory");
     console.log(document.querySelector("#selectCategory").value);
     await showIngredients( ingredientsCategorys, sort )
 }
 else{
     let serchProducts = postJSON("/app/admin/adminIngredientsJsLoader.php", document.querySelector("#serchName").value, "IngredientBySech");
     await showIngredients( serchProducts,sort )
 }
   }
})