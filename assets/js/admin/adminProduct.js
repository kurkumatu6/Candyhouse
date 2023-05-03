let imageBlocks = 1;
let arrDelId = [];
let sort = true;
let categoriesTry = true;
document.querySelector("#selectCategory").addEventListener("change", function(e){
    console.log(1111);
    categoriesTry = true;
    let productsCategorys = postJSON("/app/admin/adminProductJsLoader.php", e.currentTarget.value, "productsOnCategory");
    console.log(productsCategorys);
    showProductsByTable(sort, productsCategorys )
})
async function showProductsByTable(sort, products){
    let table = document.querySelector("#productTable")
    document.querySelector("#productTable").innerHTML=`
    <tr>
    <td>Название</td>
    <td>Категория</td>
    <td class="td_product_price">Цена</td>
    <td class="td_product_count">Покупок за прошлый месяц</td>
    <td class="td_product_buttons" id="head_td_buttons_order"></td>
    </tr>
    `
    products.then(function(value){
        let arr = value.productInBasket
        if(sort){
            arr.sort((a,b)=> a.price - b.price)
            document.querySelector("#sort").textContent = "Цена ↑"
        }
        else{
            arr.sort((a,b)=> b.price - a.price)
            document.querySelector("#sort").textContent = "Цена ↓"
        }
        
        arr.forEach(element => {
            document.querySelector("#productTable>tbody").insertAdjacentHTML("beforeend", `
            <tr>
            <td>${element.name}</td>
                <td>${element.category}</td>
                <td class="td_product_price">${element.price}</td>
                <td class="td_product_count" id="count${element.id}"></td>
                <td class="td_product_buttons">
                    <div>
                        <button class="delProduct" data-product-id="${element.id}">Удалить</button>
                        <button class="changeProduct" data-product-id="${element.id}">Изменить</button>
                        <input type="checkbox" name="" id="" class="delChecks" data-product-id="${element.id}">
                    </div>
                </td>
            </tr>
            `)
            postJSON("/app/admin/adminProductJsLoader.php", element.id, "getCountProduct").then(function(value){
                console.log(value)
                console.log(element.id)
                console.log(document.querySelector(`#count${element.id}`))
                document.querySelector(`#count${element.id}`).innerHTML = `<p>${value.productInBasket.count}</p>`
            })
        });
    })
}
document.querySelector("#sort").addEventListener("click", function(){
    sort = !sort
    if(categoriesTry){
        let productsCategorys = postJSON("/app/admin/adminProductJsLoader.php", document.querySelector("#selectCategory").value, "productsOnCategory");
        console.log(document.querySelector("#selectCategory").value);
        showProductsByTable(sort, productsCategorys )
    }
    else{
        let serchProducts = postJSON("/app/admin/adminProductJsLoader.php", document.querySelector("#serchName").value, "productsOnSerch");
        showProductsByTable(sort, serchProducts )
    }

})
document.addEventListener("click", async  function(e){

    if(e.target.classList.contains("serchConfirm")){
        console.log("dasda")
        categoriesTry = false;
        let serchProducts = postJSON("/app/admin/adminProductJsLoader.php", document.querySelector("#serchName").value, "productsOnSerch");
        showProductsByTable(sort, serchProducts )
    }
    if(e.target.classList.contains("delProduct")){
        document.querySelector("body").insertAdjacentHTML("beforeend", `
        <div class="modal-wrapper">
          <div class="modal delModal">
            <div class="delModalDiv">
                <h2>Вы действительно хотите удалить данный товар</h2>
                <button class="delProductConfirm" data-product-id="${e.target.dataset.productId}">Подтвердить удаление</button>
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
    if(e.target.classList.contains("delProductConfirm")){
         postJSON("/app/admin/adminProductJsLoader.php", e.target.dataset.productId, "delProduct").then(async function(){
            document.querySelector(".modal-wrapper").remove();
            if(categoriesTry){
                let productsCategorys = postJSON("/app/admin/adminProductJsLoader.php", document.querySelector("#selectCategory").value, "productsOnCategory");
                console.log(document.querySelector("#selectCategory").value);
                await showProductsByTable(sort, productsCategorys )
            }
            else{
                let serchProducts =  postJSON("/app/admin/adminProductJsLoader.php", document.querySelector("#serchName").value, "productsOnSerch");
                await showProductsByTable(sort, serchProducts )
            }
         })

    }
    if(e.target.classList.contains("addProduct")){
        console.log("dasda")
         imageBlocks = 1;
        document.querySelector("body").insertAdjacentHTML("beforeend", `
        <div class="modal-wrapper">
          <div class="modal addProductModal">
            <form id='addProductForm' method="POST" action="/app/admin/addProductLoad.php" enctype="multipart/form-data">
            
            <label for="">Добавление продукта</label>
            <div>
                <label>Название</label>
                <input type="text" name="productName">
            </div>
            <div>
                <label>Время изготовления(В днях)</label>
                <input type="number" name="preparation_time" id="">
            </div>
            <div>
                <label>Список ингредиентов</label>
                <textarea class="ingredientListTextarea" name="ingredient_list" id="" cols="30" rows="10"></textarea>
            </div>
            <div>
                <label>Категория</label>
                <select name="category" id="categoryByAdd">
        
                </select>
            </div>
            <div>
                <label>Каллорийность на 100 грамм</label>
                <input type="number" name="calories" id="">
            </div>
            <div>
                <label>Цена</label>
                <input type="number" name="price" id="">
            </div>
            <div>
                <label>Вес в граммах</label>
                <input type="number" name="weight_g" id="">
            </div>
            <div>
                <label>Срок годности в днях</label>
                <input type="number" name="self_life_days" id="">
            </div>
            <div class="imageAddBlockClass">
            <div class="imageBlock">
            <label for="imagesAdd${imageBlocks}">Выбрать картинку</label>
            <input type="file" data-image-block-id="${imageBlocks}" class="addImageInput" style="display:none" name="imagesAdd${imageBlocks}" id="imagesAdd${imageBlocks}" >
            <button type="button" class="delImageBlockButtons">Удалить картинку</button>
            </div>
            <div class="imageBlock${imageBlocks} container">
            </div>
            </div>

            <p class="addImage" >Добавить ещё картинку</p>

            <button class="addProductConfirm" name="product_id">Сохранить</button>
          </form>

          </div>
        </div>
        `)
        

        let categorys = postJSON("/app/admin/adminProductJsLoader.php", "", "getCaqtegories")
        categorys.then(function(value){
            value.productInBasket.forEach(item => {
                document.querySelector("#categoryByAdd").insertAdjacentHTML("beforeend", `
                <option value="${item.id}">${item.category}</option>
                `)
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
    if(e.target.classList.contains("addImage")){
        imageBlocks +=1
        e.target.insertAdjacentHTML("beforebegin", `
        <div class="imageAddBlockClass">
        <div class="imageBlock">
        <label for="imagesAdd${imageBlocks}">Выбрать картинку</label>
        <input type="file" data-image-block-id="${imageBlocks}" class="addImageInput" name="imagesAdd${imageBlocks}" style="display:none" id="imagesAdd${imageBlocks}" >
        <button type="button" class="delImageBlockButtons">Удалить картинку</button>
    </div>
    <div class="imageBlock${imageBlocks} container">
    </div>
        
        </div>            
        `)
    }
    if(e.target.classList.contains("delMassProduct")){
        let arrDel =  document.querySelectorAll(".delChecks")
        arrDel = [...arrDel]

        let arrCheckedDel = arrDel.filter(item => item.checked == true)

        arrDelId = arrCheckedDel.map(item => item.dataset.productId)
        console.log(arrDelId)
        document.querySelector("body").insertAdjacentHTML("beforeend", `
        <div class="modal-wrapper">
          <div class="modal delMassModal">
            <div class="delMassBlock">
                <h2 class="delMassTitle">Вы действительно хотите удалить ${arrDelId.length} товаров</h2>
                <div class="delProductNames"></div>
                <div class="buttonsForMassDel">
                <button class="delProductsShow">Просмотреть список удаляемых наименваний</button>
                <button class="delMassProductConfirm" data-product-id="${e.target.dataset.productId}">Подтвердить удаление</button>
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
        // postJSON("/app/admin/adminProductJsLoader.php", document.querySelector("#serchName").value, "delSelectedProduct")
    }
    if(e.target.classList.contains("delProductsShow")){
        postJSON("/app/admin/adminProductJsLoader.php", arrDelId, "showDelSelectedProduct").then(function(value){
            if(value.productInBasket){
                document.querySelector(".delProductNames").innerHTML ="";
                value.productInBasket.forEach(item =>{
                    document.querySelector(".delProductNames").insertAdjacentHTML("beforeend", `
                        <p class="delMassProductNames">${item.name}</p>
        `)
                })
            }

        })

    }
    if(e.target.classList.contains("delMassProductConfirm")){
        postJSON("/app/admin/adminProductJsLoader.php", arrDelId, "delSelectedProduct").then(async function(){
            document.querySelector(".modal-wrapper").remove();
            if(categoriesTry){
                let productsCategorys = postJSON("/app/admin/adminProductJsLoader.php", document.querySelector("#selectCategory").value, "productsOnCategory");
                console.log(document.querySelector("#selectCategory").value);
                await showProductsByTable(sort, productsCategorys )
            }
            else{
                let serchProducts =  postJSON("/app/admin/adminProductJsLoader.php", document.querySelector("#serchName").value, "productsOnSerch");
                await showProductsByTable(sort, serchProducts )
            }
        })

    }
    if(e.target.classList.contains("changeProduct")){
        imageBlocks = 1;
        postJSON("/app/admin/adminProductJsLoader.php", e.target.dataset.productId, "getProductById").then(function (value) {
            console.log(value)
            document.querySelector("body").insertAdjacentHTML("beforeend", `
        <div class="modal-wrapper">
          <div class="modal addProductModal">
            <form id='addProductForm' method="POST" action="/app/admin/changeProductLoad.php" enctype="multipart/form-data">
            
            <label for="">Изменение продукта</label>
            <div>
                <label>Название</label>
                <input type="text" name="productName" value="${value.productInBasket.name}">
            </div>
            <div>
                <label>Время изготовления(В днях)</label>
                <input type="number" name="preparation_time" id="" value="${value.productInBasket.preparation_time}">
            </div>
            <div>
                <label>Список ингредиентов</label>
                <textarea name="ingredient_list" id="ingredient_list" cols="30" rows="10" value=""></textarea>
            </div>
            <div>
                <label>Категория</label>
                <select name="category" id="categoryByChange">
        
                </select>
            </div>
            <div>
                <label>Каллорийность на 100 грамм</label>
                <input type="number" name="calories" id="" value="${value.productInBasket.calories}">
            </div>
            <div>
                <label>Цена</label>
                <input type="number" name="price" id="" value="${value.productInBasket.price}">
            </div>
            <div>
                <label>Вес в граммах</label>
                <input type="number" name="weight_g" id="" value="${value.productInBasket.weight_g}">
            </div>
            <div>
                <label>Срок годности в днях</label>
                <input type="number" name="self_life_days" id="" value="${value.productInBasket.self_life_days}">
            </div>
            <div id="startImages"></div>

            <div id="endImages"></div>
            <p class="addImage" >Добавить ещё картинку</p>

            <button class="addProductConfirm" name="product_id" value="${value.productInBasket.id}">Сохранить изменения</button>
          </form>

          </div>
        </div>
        `)
        document.querySelector("#ingredient_list").textContent = value.productInBasket.ingredient_list;
        let categorys = postJSON("/app/admin/adminProductJsLoader.php", "", "getCaqtegories")
        categorys.then(function(valueCategory){
            valueCategory.productInBasket.forEach(item => {
                document.querySelector("#categoryByChange").insertAdjacentHTML("beforeend", `
                <option class="categoryOption" value="${item.id}" ${item.id == value.productInBasket.category_id?"selected":""}>${item.category}</option>
                `)
            })
            // document.querySelectorAll(".categoryOption").forEach(item => {
            //     console.log()
            //     console.log(item.value == value.productInBasket.category_id)
            //     item.selected = item.value == value.productInBasket.category_id
            // })
        })
        let images = postJSON("/app/admin/adminProductJsLoader.php", value.productInBasket.id, "getImagesForProduct")
        images.then(function(value){
            value.productInBasket.forEach(item=>{
                document.querySelector("#endImages").insertAdjacentHTML("beforebegin", `
                    <div class="block changeImageBlockStart">
                    <div class="changeImageBlockStartOldImage">
                        <h2>Картинка</h2>
                        <img src="/upload/${item.image}" alt="">
                    </div>
                    <div class="changeImageBlockButtons">
                    <label for="imagesChange${item.id}">Изменить картинку</label>
                    <input type="file" class="changeImageInput" data-id="${item.id}" name="imagesChange${item.id}" style="display: none" id="imagesChange${item.id}" >
                    <input type="text" name="imagesChangeIds[]" value="${item.id}" style="display: none">
                    <button type="button" class="delImage" data-image-id="${item.id}">Удалить данную картинку</button>
                    </div>

                    <div class="changeImageBlockRez${item.id} changeImageBlockRezStyles">
                    
                    </div>
                    </div>

                `)
            })
            document.querySelectorAll(".delImage").forEach(item=> {
                item.addEventListener("click", function(e){
                    console.log(1111)
                    console.log()
                    e.target.closest(".block").insertAdjacentHTML("beforebegin", `
                    <input type="text" name="imagesDelIds[]" value="${e.currentTarget.dataset.imageId}" style="display: none">
                    `)
                    e.target.closest(".block").remove()
                })
            })
            document.querySelector("#endImages").insertAdjacentHTML("beforebegin", `
            <div class="imageAddBlockClass">
            <div class="imageBlock">
                <label for="imagesAdd${imageBlocks}">Выбрать картинку</label>
                <input type="file" data-image-block-id="${imageBlocks}" class="addImageInput" style="display:none"  name="imagesAdd${imageBlocks}" id="imagesAdd${imageBlocks}" >
                <button type="button" class="delImageBlockButtons">Удалить картинку</button>
            </div>
            <div class="imageBlock${imageBlocks}">
            </div>
            </div>
        `)
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
        // console.log(document.querySelectorAll(".categoryOption"))

        })

    }
    if(e.target.classList.contains("delImageBlockButtons")){
        let block = e.target.closest(".imageAddBlockClass");

        block.remove()
    }

})
document.addEventListener("change", function(e){
    if(e.target.classList.contains("addImageInput")){
        let block = document.querySelector(`.imageBlock${e.target.dataset.imageBlockId}`)
        block.innerHTML="";
        let file = e.target.files[0]
        let imgURL =URL.createObjectURL(file)
        block.insertAdjacentHTML("beforeend", `
        <h2 class="textCenter">Выбранная картинка</h2>
        <img src="${imgURL}" class="addsImadges" alt="" />
        `)
    }
    if(e.target.classList.contains("changeImageInput")){
        let block = document.querySelector(`.changeImageBlockRez${e.target.dataset.id}`)
        block.innerHTML="";
        let file = e.target.files[0]
        let imgURL =URL.createObjectURL(file)
        block.insertAdjacentHTML("beforeend", `
        <h2 class="textCenter">Выбранная картинка</h2>
        <img src="${imgURL}" class="addsImadges" alt="" />
        `)
    }
})


//             <textarea name="review" id="reviweText" cols="30" rows="10"></textarea>
{/* <p class="error" id="rewievError" style="display:none"></p>
<input type="text" name="product_id" value="${e.target.dataset.productId}" style="display: none"> */}
{/* <div>
<label for="">Картинки</label>
<input type="file" name="images${imageBlocks}" id="" >
</div>
<div class="imageBlock${imageBlocks}">
</div> */}