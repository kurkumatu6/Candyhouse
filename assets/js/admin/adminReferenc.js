async function showProductsCategorys(categoriesProduct){
    let table = document.querySelector("#prodCategoriesTable>tbody")
    table.innerHTML =`                <tr>
    <td>id</td>
    <td>Название</td>
    <td></td>
</tr>`

categoriesProduct.then(async function(value){
        value.productInBasket.forEach(element => {

            table.insertAdjacentHTML("beforeend", `
            <tr>
            <td>${element.id}</td>
            <td>${element.category}</td>
            <td>
            <button class="delProductCategory delButton"  data-prod-category-id="${element.id}" data-prod-category-name="${element.category}" value="${element.id}">Удалить</button>
            </td>
            </tr>
            `)
        });

    })
}
async function showIngredientsCategorys(categoriesIngredients){
    let table = document.querySelector("#ingrCategoriesTable>tbody")
    table.innerHTML =`                <tr>
    <td>id</td>
    <td>Название</td>
    <td></td>
</tr>`

categoriesIngredients.then(async function(value){
        value.productInBasket.forEach(element => {

            table.insertAdjacentHTML("beforeend", `
            <tr>
            <td>${element.id}</td>
            <td>${element.name}</td>
            <td>
            <button class="delIngredientCategory delButton" data-ingr-category-id="${element.id}" data-ingr-category-name="${element.name}" value="${element.id}">Удалить</button>
            </td>
            </tr>
            `)
        });

    })
}
async function showClientsStatuses(clientsStatuses){
    let table = document.querySelector("#clientStatusesTable>tbody")
    table.innerHTML =`                <tr>
    <td>id</td>
    <td>Название</td>
    <td></td>
</tr>`

clientsStatuses.then(async function(value){
        value.productInBasket.forEach(element => {

            table.insertAdjacentHTML("beforeend", `
            <tr>
            <td>${element.id}</td>
            <td>${element.status}</td>
            <td>
            <button class="delClientsSatus delButton" data-client-status-id="${element.id}" data-client-status-name="${element.status}" value="${element.id}">Удалить</button>
            </td>
            </tr>
            `)
        });

    })
}
async function showOrderStatuses(orderStatuses){
    let table = document.querySelector("#orderStatusesTable>tbody")
    table.innerHTML =`                <tr>
    <td>id</td>
    <td>Название</td>
    <td></td>
</tr>`

orderStatuses.then(async function(value){
        value.productInBasket.forEach(element => {

            table.insertAdjacentHTML("beforeend", `
            <tr>
            <td>${element.id}</td>
            <td>${element.status}</td>
            <td>
            <button class="delOrderStatus delButton" data-order-status-id="${element.id}" data-order-status-name="${element.status}" value="${element.id}">Удалить</button>
            </td>
            </tr>
            `)
        });

    })
}
document.addEventListener("click", async function(e){
    if(e.target.classList.contains("delProductCategory")){
        document.querySelector("body").insertAdjacentHTML("beforeend", `
            <div class="modal-wrapper">
              <div class="modal delModal">
                <div class="delModalDiv">
                    <h2>Вы действительно хотите удалить категорию "${e.target.dataset.prodCategoryName}" для продуктов?</h2>
                    <button class="delProductCategoryConfirm" data-prod-category-id="${e.target.dataset.prodCategoryId}">Подтвердить удаление</button>
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
    if(e.target.classList.contains("delIngredientCategory")){
        document.querySelector("body").insertAdjacentHTML("beforeend", `
            <div class="modal-wrapper">
              <div class="modal delModal">
                <div class="delModalDiv">
                    <h2>Вы действительно хотите удалить категорию "${e.target.dataset.ingrCategoryName}" для ингредиентов?</h2>
                    <button class="delIngredientCategoryConfirm" data-ingr-category-id="${e.target.dataset.ingrCategoryId}">Подтвердить удаление</button>
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
    if(e.target.classList.contains("delClientsSatus")){
        document.querySelector("body").insertAdjacentHTML("beforeend", `
            <div class="modal-wrapper">
              <div class="modal delModal">
                <div class="delModalDiv">
                    <h2>Вы действительно хотите удалить статус "${e.target.dataset.clientStatusName}" для клиентов?</h2>
                    <button class="delClientsSatusConfirm" data-client-status-id="${e.target.dataset.clientStatusId}">Подтвердить удаление</button>
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
    if(e.target.classList.contains("delOrderStatus")){
        document.querySelector("body").insertAdjacentHTML("beforeend", `
            <div class="modal-wrapper">
              <div class="modal delModal">
                <div class="delModalDiv">
                    <h2>Вы действительно хотите удалить статус "${e.target.dataset.orderStatusName}" для закзов?</h2>
                    <button class="delOrderStatusConfirm" data-order-status-id="${e.target.dataset.orderStatusId}">Подтвердить удаление</button>
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
    if(e.target.classList.contains("delProductCategoryConfirm")){
        postJSON("/app/admin/adminReferenceBooksJsLoader.php", e.target.dataset.prodCategoryId , "delProductCategory").then(async function(){
          await showProductsCategorys(postJSON("/app/admin/adminReferenceBooksJsLoader.php", "" , "getAllProductCategory"))
          document.querySelector(".modal-wrapper").remove()
        })

    }
    if(e.target.classList.contains("delIngredientCategoryConfirm")){
        postJSON("/app/admin/adminReferenceBooksJsLoader.php", e.target.dataset.ingrCategoryId , "delIngredientCategory").then(async function(){
          await showIngredientsCategorys(postJSON("/app/admin/adminReferenceBooksJsLoader.php", "" , "getAllIngredientCategory"))
          document.querySelector(".modal-wrapper").remove()
        })

    }
    if(e.target.classList.contains("delClientsSatusConfirm")){
        postJSON("/app/admin/adminReferenceBooksJsLoader.php", e.target.dataset.clientStatusId , "delClientsSatus").then(async function(){
          await showClientsStatuses(postJSON("/app/admin/adminReferenceBooksJsLoader.php", "" , "getAllClientsSatus"))
          document.querySelector(".modal-wrapper").remove()
        })

    }
    if(e.target.classList.contains("delOrderStatusConfirm")){
        postJSON("/app/admin/adminReferenceBooksJsLoader.php", e.target.dataset.orderStatusId , "delOrderStatus").then(async function(){
          await showOrderStatuses(postJSON("/app/admin/adminReferenceBooksJsLoader.php", "" , "getAllOrderStatus"))
          document.querySelector(".modal-wrapper").remove()
        })

    }
})