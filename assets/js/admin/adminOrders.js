let sort = true;
document
    .querySelector("#selectStatus")
    .addEventListener("change", function (e) {
        showOrders(
            postJSON(
                "/app/admin/adminOrdersJsLoader.php",
                e.currentTarget.value,
                "getOrdersByStatus"
            ),
            sort
        );
    });

document.addEventListener("change", async function (e) {
    if(e.target.classList.contains("block_user")){
        if(document.querySelector("#block_user").checked){
            document.querySelector(".user_warning_block").insertAdjacentHTML(
                "beforeend",`<div id="reason_block">
                <h2>Причина предупреждения/блокировки</h2>
                <textarea name="" id="reason_warning" cols="30" rows="10"></textarea>
                </div>`)

        }
        else{
            document.querySelector("#reason_block").remove();
        }
    }
    if (e.target.classList.contains("orderStatusBar")) {
        if (e.target.value == 1) {
            postJSON(
                "/app/admin/adminOrdersJsLoader.php",
                { statusId: e.target.value, orderId: e.target.dataset.orderId },
                "changeStatusOforder"
            );
        }
        if (e.target.value == 3) {
            postJSON(
                "/app/admin/adminOrdersJsLoader.php",
                e.target.dataset.orderId,
                "getOrderById"
            ).then(function (order) {
                document.querySelector("body").insertAdjacentHTML(
                    "beforeend",
                    `
            <div class="modal-wrapper">
              <div class="modal confirmOrderModal">
                <div class=" confirmOrderBlock">

                <h2>Заказ№ ${order.productInBasket.id
                }</h2>

                    <div class="showOrderProductBlock">
                    <h2>Товары в заказе</h2>
                        <table id="tableProductsInOrder${order.productInBasket.id
                    }">
                        <tr>
                            <td>Наименование</td>
                            <td>Категория</td>
                            <td>Цена</td>
                            <td>Количество</td>
                            <td>Стоимость</td>
                            <td>Дата изготовления</td>
                        </tr>
                        </table>
                    </div>
                    <div class="showOrderRecipesBlock">
                    <h2>Рецепты в заказе</h2>
                    <table id="tableRecipesInOrder${order.productInBasket.id}">
                    <tr>
                        <td>Наименование/№</td>
                        <td>Цена</td>
                        <td>Количество</td>
                        <td>Стоимость</td>
                        <td>Дата изготовления</td>
                    </tr>
                    </table>
                    </div>
                    <div class="showOrderFooterData">
                    <h2>Дата заказа ${order.productInBasket.order_date}</h2>
                        <h2>Итого по заказу ${order.productInBasket.sum
                    } руб</h2>
                        <h2>Количество товаров в заказе ${(order.productInBasket.count == null
                        ? 0
                        : +order.productInBasket.count) +
                    (order.productInBasket.countRic == null
                        ? 0
                        : +order.productInBasket.countRic)
                    } шт</h2>
                    </div>
                    <button class="complitStatusConfirm" data-order-id="${order.productInBasket.id}">Подтвердить</button>
                </div>
                </div>
              </div>
            </div>
            `
                );

                postJSON(
                    "/app/admin/adminOrdersJsLoader.php",
                    order.productInBasket.id,
                    "getAllProductInOrder"
                ).then(function (value) {
                    let table = document.querySelector(
                        `#tableProductsInOrder${order.productInBasket.id}>tbody`
                    );
                    if(value.productInBasket.length >0){
                    value.productInBasket.forEach((item) => {
                        console.log(item);
                        table.insertAdjacentHTML(
                            "beforeend",
                            `
                    <tr>
                        <td>${item.name}</td>
                        <td>${item.category}</td>
                        <td>${item.price}</td>
                        <td>${item.count}</td>
                        <td>${item.price * item.count}</td>
                        <td>    
                            <input type="date" name="" class="prodDates" data-prod-id="${item.product_id}" id="date_of_manufacture${item.id}"> 
                        </td>
                    </tr>
                `
                        );
                    });
                }
                else{
                    document.querySelector(".showOrderProductBlock").innerHTML = "<h2>В заказе нет товаров</h2>"
                }
                });
                postJSON(
                    "/app/admin/adminOrdersJsLoader.php",
                    order.productInBasket.id,
                    "getAllRecipesInOrder"
                ).then(function (value) {
                    let table = document.querySelector(
                        `#tableRecipesInOrder${order.productInBasket.id}>tbody`
                    );
                    if(value.productInBasket.length >0){


                    value.productInBasket.forEach((item) => {
                        console.log(item);
                        table.insertAdjacentHTML(
                            "beforeend",
                            `
                    <tr>
                        <td>${item.name != null ? item.name : item.number}</td>
                        <td>${item.price}</td>
                        <td>${item.count}</td>
                        <td>${item.price * item.count}</td>
                        <td>    <input type="date" class="recipeDates" data-ric-id="${item.number}" name="" id="date_of_manufacture${item.number
                            }"> </td>
                    </tr>
                `
                        );
                    });
                }
                else{
                    document.querySelector(".showOrderRecipesBlock").innerHTML = "<h2>В заказе нет рецептов</h2>"
                }
                });
                modal = document.querySelector(".modal-wrapper");
                modal.addEventListener("click", function (event) {
                    if (event.target == event.currentTarget) {
                        modal.remove();
                        postJSON("/app/admin/adminOrdersJsLoader.php", e.target.dataset.orderId, "getOrderById").then(function (value){
                            document.querySelectorAll(`.optionsStatus${e.target.dataset.orderId}`).forEach(item =>{
                                item.selected = item.value == value.productInBasket.status_of_order_id
                            })
                          })
                        //   showOrders(postJSON("/app/admin/adminOrdersJsLoader.php", document.querySelector("#selectStatus").value, "getOrdersByStatus"), sort)
                    }
                });
                document.addEventListener("keyup", function (event) {
                    console.log(event.key);
                    if (event.key == "Escape") {
                        modal.remove();
                        postJSON("/app/admin/adminOrdersJsLoader.php", e.target.dataset.orderId, "getOrderById").then(function (value){
                            document.querySelectorAll(`.optionsStatus${e.target.dataset.orderId}`).forEach(item =>{
                                item.selected = item.value == value.productInBasket.status_of_order_id
                            })
                          })
                        //   showOrders(postJSON("/app/admin/adminOrdersJsLoader.php", document.querySelector("#selectStatus").value, "getOrdersByStatus"), sort)
                    }
                });
            });
            // await showOrders(postJSON("/app/admin/adminOrdersJsLoader.php", document.querySelector("#selectStatus").value, "getOrdersByStatus"))
        }
        if (e.target.value == 2) {
            document.querySelector("body").insertAdjacentHTML(
                "beforeend",
                `
            <div class="modal-wrapper">
              <div class="modal confirmOrderModal">
                <div class=" confirmOrderBlock">
                <div class="showOrderRecipesBlock">
                <h2>Рецепты в заказе</h2>
                <table id="tableRecipesInOrder${e.target.dataset.orderId}">
                <tr>
                    <td>Наименование/№</td>
                    <td>Цена</td>
                    <td>Количество</td>
                    <td>Стоимость</td>
                    <td>Пометка на удаление</td>
                </tr>
                </table>
                </div>
                <div class="reasonCancelBlock">
                <h2>Причина отмены</h2>
                <textarea name="" id="reason_cancellation" cols="30" rows="10"></textarea>
                </div>
                <div class="user_warning_block">
                </div>
                <button data-order-id = "${e.target.dataset.orderId}" class="cancellationConfirm">Подтвердить действия</button>
            </div>
                </div>


              </div>
            </div>
            `
            );
            postJSON(
                "/app/admin/adminOrdersJsLoader.php",
                e.target.dataset.orderId,
                "getUserWarning"
            ).then(function (value) {
                console.log(value);
                if (+value.productInBasket.warning == 1) {
                    document.querySelector(".user_warning_block").insertAdjacentHTML(
                        "beforeend",
                        
                        `
                        <div class="user_warning_block_title">
                        <h2>Данный ползователь уже имеет предупреждение. заблокировать?</h2>
                        <input type="checkbox" name="block_user" class="block_user" id="block_user" data-user-id="${value.productInBasket.id}">
                        </div>

                    
                    `
                    );
                } else {
                    document.querySelector(".user_warning_block").insertAdjacentHTML(
                        "beforeend",
                        `
                        <div class="user_warning_block_title">
                        <h2>Выдать пользователью предупреждение</h2>
                    <input type="checkbox" name="block_user" class="block_user" id="block_user" data-user-id="${value.productInBasket.id}">
                    
                    </div>
                    `
                    
                    );
                }

            });
            postJSON(
                "/app/admin/adminOrdersJsLoader.php",
                e.target.dataset.orderId,
                "getAllRecipesInOrder"
            ).then(function (value) {
                let table = document.querySelector(
                    `#tableRecipesInOrder${e.target.dataset.orderId}>tbody`
                );
                if(value.productInBasket.length >0){
                value.productInBasket.forEach((item) => {
                    console.log(item);
                    table.insertAdjacentHTML(
                        "beforeend",
                        `
                    <tr>
                        <td>${item.name != null ? item.name : item.number}</td>
                        <td>${item.price}</td>
                        <td>${item.count}</td>
                        <td>${item.price * item.count}</td>
                        <td>    
                        <input type="checkbox" name="delRecipeCheck" class="delRecipeCheck"  data-recipe-id="${item.number}">
                        </td>
                    </tr>
                `
                    );
                    
                });
            }
            else{
                document.querySelector(".showOrderRecipesBlock").innerHTML = "<h2>В заказе нет рецептов</h2>"
            }
                
            });
            modal = document.querySelector(".modal-wrapper");
            modal.addEventListener("click", function (event) {
                if (event.target == event.currentTarget) {
                    modal.remove();

                      postJSON("/app/admin/adminOrdersJsLoader.php", e.target.dataset.orderId, "getOrderById").then(function (value){
                        document.querySelectorAll(`.optionsStatus${e.target.dataset.orderId}`).forEach(item =>{
                            item.selected = item.value == value.productInBasket.status_of_order_id
                        })
                      })
                }
            });
            document.addEventListener("keyup", function (event) {
                console.log(event.key);
                if (event.key == "Escape") {
                    modal.remove();

                    postJSON("/app/admin/adminOrdersJsLoader.php", e.target.dataset.orderId, "getOrderById").then(function (value){
                        document.querySelectorAll(`.optionsStatus${e.target.dataset.orderId}`).forEach(item =>{
                            item.selected = item.value == value.productInBasket.status_of_order_id
                        })
                      })
                }
            });

            // await showOrders(postJSON("/app/admin/adminOrdersJsLoader.php", document.querySelector("#selectStatus").value, "getOrdersByStatus"))
        }
    }

});
async function showOrders(orders, sort = true) {
    // orders = showOrders(postJSON("/app/admin/adminOrdersJsLoader.php", document.querySelector("#selectStatus").value, "getOrdersByStatus"))
    let table = document.querySelector("#ordersTable>tbody");
    table.innerHTML = `                <tr>
    <td class="td_id">Номер заказа</td>
    <td>Адрес доставки</td>
    <td class="td_phone_order">Телефон адресата</td>
    <td class="td_count_in_order">Количество товаров в заказе</td>
    <td class="td_itogo_order">Итого по заказу</td>
    <td class="td_status_order">Статус заказа</td>
    <td class="td_buttons_order"></td>
</tr>`;

    orders.then(async function (value) {
        arr = value.productInBasket;
        if (sort) {
            arr.sort((a, b) => +a.price_order - +b.price_order);
            document.querySelector("#sort").textContent = "Итого по заказу ↑";
        } else {
            arr.sort((a, b) => +b.price_order - +a.price_order);
            document.querySelector("#sort").textContent = "Итого по заказу ↓";
        }

        arr.forEach((element) => {
            console.log(element.countRic == null ? 0 : +element.countRic);
            table.insertAdjacentHTML(
                "beforeend",
                `
            <tr>
            <td class="td_id">${element.id}</td>
                <td>${element.delivery_addres}</td>
                <td class="td_phone_order">${element.addressee_phone}</td>
                <td class="td_count_in_order">${(element.count == null ? 0 : +element.count) +
                (element.countRic == null ? 0 : +element.countRic)
                }</td>
                <td class="td_itogo_order">${element.sum}</td>
                <td class="td_status_order">
                    <select name="statusOfOrder" class="orderStatusBar" id="statusOfOrder${element.id
                }" data-order-id="${element.id}">
                    </select>

                </td>
                <td class="td_buttons_order">
                    <button class="showOrderProducts" data-order-id="${element.id
                }">Порсмотреть товары в заказе</button>
                </td>
            </tr>
            `
            );
            postJSON(
                "/app/admin/adminOrdersJsLoader.php",
                "",
                "getAllStatusesOfOrder"
            ).then(function (value) {
                let select = document.querySelector(`#statusOfOrder${element.id}`);
                value.productInBasket.forEach((item) => {
                    select.insertAdjacentHTML(
                        "beforeend",
                        `<option class="optionsStatus${element.id}" ${item.id == element.status_of_order_id ? "selected" : ""
                        } value="${item.id}">${item.status}</option>`
                    );
                });
            });
        });
    });
}

document.addEventListener("click", async function (e) {
    if(e.target.classList.contains("complitStatusConfirm")){
        let prodDates = []
        let recipeDates = []
        let countNull = 0;
        document.querySelectorAll(".prodDates").forEach(item =>{
            console.log(item.value)
            if(item.value == ""){
                countNull+=1

            }
            prodDates.push({"date": item.value, "idProd":item.dataset.prodId , "orderId":e.target.dataset.orderId})
        })
        document.querySelectorAll(".recipeDates").forEach(item =>{
            if(item.value == ""){
                countNull+=1
            }
            recipeDates.push({"date": item.value, "idRic":item.dataset.ricId, "orderId":e.target.dataset.orderId})
        })
        console.log(countNull)
        if(countNull == 0){
            if(document.querySelector(".error") != null){
                document.querySelector(".error").remove();
            }

            postJSON("/app/admin/adminOrdersJsLoader.php", {"recipeDates":recipeDates, "prodDates":prodDates, "orderId":e.target.dataset.orderId}, "setDateOfManufacture")
            //await showOrders(postJSON("/app/admin/adminOrdersJsLoader.php", document.querySelector("#selectStatus").value, "getOrdersByStatus"), sort)
            document.querySelector(".modal-wrapper").remove()
        }
        else{
            if(document.querySelector(".error") == null){
                e.target.insertAdjacentHTML("afterend", '<p class="error recipeError">Все даты должны быть заполнены </p>')
            }
        }
    }
    if(e.target.classList.contains("cancellationConfirm")){
        let reasonWarning= ""
        let reasonCancellation = document.querySelector("#reason_cancellation").value
        console.log(reasonCancellation.length)
        if(reasonCancellation.length <10){
            if(document.querySelector(".reason_cancellation_error") == null){
                document.querySelector("#reason_cancellation").insertAdjacentHTML("afterend", "<p class='error reason_cancellation_error'>Причина отмены заказа не должна быть мение 10 символов</p>")
            }

        }
        else{
            if(document.querySelector(".reason_cancellation_error") != null){
            document.querySelector(".reason_cancellation_error").remove()
            }
        }
        if(document.querySelector("#reason_warning") != null){
           reasonWarning=  document.querySelector("#reason_warning").value
        
            if(reasonWarning.length <10){
                if(document.querySelector(".reason_warning_error") == null){
                    document.querySelector("#reason_warning").insertAdjacentHTML("afterend", "<p class='error reason_warning_error'>Причина предупреждения/блокировки не должна быть мение 10 символов</p>")
                }

            }
            else{
                if(document.querySelector(".reason_warning_error") != null){
                    document.querySelector(".reason_warning_error").remove()
                }
            }
        }
        if(document.querySelectorAll(".error").length == 0){
            let delRecipesIds = [];
            document.querySelectorAll(".delRecipeCheck").forEach(item =>{
                if(item.checked){
                    delRecipesIds.push(item.dataset.recipeId)
                }
            })
            postJSON("/app/admin/adminOrdersJsLoader.php",{"orderId":e.target.dataset.orderId, "statusId": 2, "user_id":document.querySelector("#block_user").dataset.userId, "warning":document.querySelector("#block_user").checked,"reason_warning":reasonWarning, "recipesIds":delRecipesIds, "reason_cancellation": reasonCancellation},"censelOrderConfirm")
            //await showOrders(postJSON("/app/admin/adminOrdersJsLoader.php", document.querySelector("#selectStatus").value, "getOrdersByStatus"), sort)
            document.querySelector(".modal-wrapper").remove()
        }

    }
    if (e.target.classList.contains("showOrderProducts")) {
        postJSON(
            "/app/admin/adminOrdersJsLoader.php",
            e.target.dataset.orderId,
            "getOrderById"
        ).then(function (order) {
            // console.log(value)
            document.querySelector("body").insertAdjacentHTML(
                "beforeend",
                `
                <div class="modal-wrapper">
                <div class="modal showOrderModal">
                  <div class="showOrderBlock">
                    <div class="showOrderHeader">
                    
                        <h1>Номер заказа ${order.productInBasket.id}</h1>
                        <div class="showOrderMainData">
                            <h2>Адрес доставки: ${order.productInBasket.delivery_addres }</h2>
                            <h2>Телефон адресата: ${order.productInBasket.addressee_phone }</h2>
                            <h2>Статус заказа: ${order.productInBasket.status}</h2>
                            <h2>Желаемая дата доставки ${order.productInBasket.date_of_issue_of_order }</h2>
                        </div>

                        <div class="showOrderTextBlock">
                        <h2>Текст записки</h2>
              
                        <p>${order.productInBasket.discription}</p>
                        </div>
                    </div>

                    <div class="showOrderProductBlock">
                      <h2>Товары в заказе</h2>
                      <table
                        id="tableProductsInOrder${order.productInBasket.id
                    }"
                      >
                        <tr>
                          <td>Наименование</td>
                          <td>Категория</td>
                          <td>Цена</td>
                          <td>Количество</td>
                          <td>Стоимость</td>
                        </tr>
                      </table>
                    </div>
                    <div class="showOrderRecipesBlock">
                      <h2>Рецепты в заказе</h2>
                      <table id="tableRecipesInOrder${order.productInBasket.id}">
                        <tr>
                          <td>Наименование/№</td>
                          <td>Цена</td>
                          <td>Количество</td>
                          <td>Стоимость</td>
                        </tr>
                      </table>
                    </div>
                    <div class="showOrderFooterData">
                      <h2>Дата заказа ${order.productInBasket.order_date}</h2>
                      <h2>Итого по заказу ${order.productInBasket.sum } руб</h2>
                      <h2>
                        Количество товаров в заказе ${(order.productInBasket.count == null ? 0
                        : +order.productInBasket.count) + (order.productInBasket.countRic ==
                        null ? 0 : +order.productInBasket.countRic) } шт
                      </h2>
                    </div>
                  </div>
                </div>
              </div>
            `
            );

            postJSON(
                "/app/admin/adminOrdersJsLoader.php",
                order.productInBasket.id,
                "getAllProductInOrder"
            ).then(function (value) {
                let table = document.querySelector(
                    `#tableProductsInOrder${order.productInBasket.id}>tbody`
                );
                if(value.productInBasket.length >0){
                value.productInBasket.forEach((item) => {
                    console.log(item);
                    table.insertAdjacentHTML(
                        "beforeend",
                        `
                        <tr>
                            <td>${item.name}</td>
                            <td>${item.category}</td>
                            <td>${item.price}</td>
                            <td>${item.count}</td>
                            <td>${item.price * item.count}</td>
                        </tr>
                    `
                    );
                });
            }
            else{
                document.querySelector(".showOrderProductBlock").innerHTML = "<h2>В заказе нет товаров</h2>"
            }
            });
            postJSON(
                "/app/admin/adminOrdersJsLoader.php",
                order.productInBasket.id,
                "getAllRecipesInOrder"
            ).then(function (value) {
                let table = document.querySelector(
                    `#tableRecipesInOrder${order.productInBasket.id}>tbody`
                );
                if(value.productInBasket.length >0){
                    value.productInBasket.forEach((item) => {
                        console.log(item);
                        table.insertAdjacentHTML(
                            "beforeend",
                            `
                            <tr>
                                <td>${item.name != null ? item.name : item.number
                            }</td>
                                <td>${item.price}</td>
                                <td>${item.count}</td>
                                <td>${item.price * item.count}</td>
    
                            </tr>
                        `
                        );
                    });
                }
                else{
                    document.querySelector(".showOrderRecipesBlock").innerHTML = "<h2>В заказе нет рецептов</h2>"
                }

            });
            modal = document.querySelector(".modal-wrapper");
            modal.addEventListener("click", function (e) {
                if (e.target == e.currentTarget) {
                    modal.remove();
                    //   showOrders(postJSON("/app/admin/adminOrdersJsLoader.php", document.querySelector("#selectStatus").value, "getOrdersByStatus"), sort)
                }
            });
            document.addEventListener("keyup", function (e) {
                console.log(e.key);
                if (e.key == "Escape") {
                    modal.remove();
                    //   showOrders(postJSON("/app/admin/adminOrdersJsLoader.php", document.querySelector("#selectStatus").value, "getOrdersByStatus"), sort)
                }
            });
        });
    }
    if (e.target.classList.contains("sort")) {
        sort = !sort;
        showOrders(
            postJSON(
                "/app/admin/adminOrdersJsLoader.php",
                document.querySelector("#selectStatus").value,
                "getOrdersByStatus"
            ),
            sort
        );
    }
});

{
    /* <div>
    <h2>
    </h2>
    <select name="statusOfOrderInModa" class="orderStatusBar" id="statusOfOrderInModal${order.productInBasket.id}" data-order-id="${order.productInBasket.id}">
    </select>
    </div> */
}

// postJSON("/app/admin/adminOrdersJsLoader.php", "", "getAllStatusesOfOrder").then(function(value){
//     let select = document.querySelector(`#statusOfOrderInModal${order.productInBasket.id}`)
//     console.log(select)
//     value.productInBasket.forEach(item=>{
//         select.insertAdjacentHTML('beforeend', `<option ${item.id == order.productInBasket.status_of_order_id?"selected":""} value="${item.id}">${item.status}</option>`)
//     })

// })
