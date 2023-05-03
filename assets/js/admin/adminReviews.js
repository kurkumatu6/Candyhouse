document.addEventListener("change", function(e){
    let form = document.querySelector("#reviewsSelectorsForm")
    let reviews = postFormData("/app/admin/adminReviewsJsLoader.php", form)
    showIngredients(reviews)
})
async function showIngredients(reviews){
    // orders = showOrders(postJSON("/app/admin/adminOrdersJsLoader.php", document.querySelector("#selectStatus").value, "getOrdersByStatus"))
    let table = document.querySelector("#reviewTable>tbody")
    table.innerHTML =`                <tr>
    <td class="td_review_id">id</td>
    <td>Продукт</td>
    <td>Клиент(email)</td>
    <td>Дата</td>
    <td class="td_review_buttons"></td>
</tr>`

    reviews.then(async function(value){
        value.productInBasket.forEach(element => {

            table.insertAdjacentHTML("beforeend", `
            <tr>
            <td class="td_review_id">
            ${element.id}
        </td>
        <td>
        ${element.product}
        </td>
        <td>
        ${element.email}
        </td>
        <td>${element.date_reviews}</td>
        <td class="td_review_buttons">
            <button class="delReview" data-review-id="${element.id}">Удалить</button>
            <button class="showReview" data-review-id="${element.id}">Просмотреть</button>

        </td>
            </tr>
            `)
        });

    })
}
document.addEventListener("click", async function(e){
    if(e.target.classList.contains("showReview")){
        postJSON("/app/admin/adminReviewsJsLoader.php", e.target.dataset.reviewId , "showReview").then(function(value){
            document.querySelector("body").insertAdjacentHTML("beforeend", `
            <div class="modal-wrapper">
              <div class="modal ShowRewiewModal">
                <div class="ShowRewiewBlock">
                <div class="row">
                <div class="headShowReview">
                <h2>Отзыв № ${value.productInBasket.id}</h2>
                <p>Товар ${value.productInBasket.product}</p>
                
                 </div>
            <div class="smallShowRewiew">
                <h2>Дата публикации ${value.productInBasket.date_reviews}</h2>
                <p>Клиент ${value.productInBasket.email}</p>
            </div>
                
                </div>

                    <div class="contentShowRewiew">
                        <p>${value.productInBasket.content}</p>
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
        })
    }
    if(e.target.classList.contains("delReview")){
        postJSON("/app/admin/adminReviewsJsLoader.php", e.target.dataset.reviewId , "showReview").then(function(value){
            document.querySelector("body").insertAdjacentHTML("beforeend", `
            <div class="modal-wrapper">
              <div class="modal ShowRewiewModal">
                    <h1>Подтверждение удаления отзыва</h1>
                <div class="ShowRewiewBlock">
                    <div class="row">
                        <div class="headShowReview">
                            <h2>Отзыв № ${value.productInBasket.id}</h2>
                            
                            <p>Товар ${value.productInBasket.product}</p>
                        </div>
                        <div class="smallShowRewiew">
                            <h2>Дата публикации ${value.productInBasket.date_reviews}</h2>
                            <p>Клиент ${value.productInBasket.email}</p>
                        </div>
                    </div>

                    <div class="contentShowRewiew">
                        <p>${value.productInBasket.content}</p>
                    </div>
                </div>
                <div class="user_warning_block">
                <label for="">Выдать пользователю пердупреждение</label>
                <input type="checkbox" name=""  id="warning">

                </div>
                <div class="warning_area">
                
                </div>
                <button class="delReviewConfirm" data-review-id="${value.productInBasket.id}">Подтвердить удаление отзыва</button>
              </div>
            </div>
            `)

            document.querySelector("#warning").addEventListener("change", function(e){
                let blockForArea= document.querySelector(".warning_area")
                if(e.currentTarget.checked){
                    if(document.querySelector("#reason_warning") == null){
                        blockForArea.insertAdjacentHTML("beforeend", `
                        <h2>Причина предупреждения</h2>
                        <textarea name="reason_warning" id="reason_warning" cols="30" rows="10"></textarea>
                    `)
                    }

                }
                else{
                    if(document.querySelector("#reason_warning") != null){
                        document.querySelector("#reason_warning").remove()
                    }
                }
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
    if(e.target.classList.contains("delReviewConfirm")){
        let srt= "";
        srt.length
        if(document.querySelector("#reason_warning") !== null){
            if(document.querySelector("#reason_warning").value.length > 10){
                postJSON("/app/admin/adminReviewsJsLoader.php", {"review_id": e.target.dataset.reviewId, "warning": document.querySelector("#warning").checked, "reason_warning": document.querySelector("#reason_warning").value} , "delReview").then(async function(){
                    let form = document.querySelector("#reviewsSelectorsForm")
                    let reviews = postFormData("/app/admin/adminReviewsJsLoader.php", form)
                    await showIngredients(reviews)
                    document.querySelector(".modal-wrapper").remove()
                })
    
            }
            else{
                if(document.querySelector("#error")== null){
                    document.querySelector("#reason_warning").insertAdjacentHTML("afterend", "<p id ='error'>Причина предупреждения должна быть не меньше 10 символов</p>")
                }
               
            }
        }
        else{
            postJSON("/app/admin/adminReviewsJsLoader.php", {"review_id": e.target.dataset.reviewId, "warning": document.querySelector("#warning").checked, "reason_warning": null} , "delReview").then(async function(){
                let form = document.querySelector("#reviewsSelectorsForm")
                let reviews = postFormData("/app/admin/adminReviewsJsLoader.php", form)
                await showIngredients(reviews)
                document.querySelector(".modal-wrapper").remove()
            })
        }


    }
})

{/* //             postJSON(
//                 "/app/admin/adminReviewsJsLoader.php",
//                 e.target.dataset.reviewId,
//                 "getUserWarning"
//             ).then(function (value) {
//                 console.log(value);
//                 if (+value.productInBasket.warning == 1) {
//                     document.querySelector(".user_warning_block").insertAdjacentHTML(
//                         "beforeend",
//                         `<h2>Данный ползователь уже имеет предупреждение. заблокировать?                    </h2>
//                     <input type="checkbox" name="block_user" class="block_user" id="warning" data-user-id="${value.productInBasket.id}">

                    
//                     `
//                     );
//                 } else {
//                     document.querySelector(".user_warning_block").insertAdjacentHTML(
//                         "beforeend",
//                         `<h2>Выдать пользователью предупреждение                    </h2>
//                     <input type="checkbox" name="block_user" class="block_user" id="warning" data-user-id="${value.productInBasket.id}">
// `
//                     );
//                 }

//             }); */}