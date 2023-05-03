// let save = 0;
document.addEventListener("click", function(e){
    if(e.target.classList.contains("client_status_change_confirm")){
        postJSON("/app/admin/adminClientsJsLoader.php", {"clientId":e.target.dataset.clientId, "status_id":e.target.dataset.statusId}, "setClientStatus")
        document.querySelector(".modal-wrapper").remove()
    }
    // if(e.target.classList.contains("client_status_change")){
    //     save = e.target.value
    // }
    if(e.target.classList.contains("showClientOrders")){
        // console.log(e.target.dataset.clientId)
        postJSON("/app/admin/adminClientsJsLoader.php", e.target.dataset.clientId, "getAllOrdersByClient").then( function(value){
            
            document.querySelector("body").insertAdjacentHTML("beforeend", `
            <div class="modal-wrapper">
            <div class="modal showOrderModal">

            </div>
            </div>
            `)
            value.productInBasket.forEach(element => {
                            document.querySelector(".modal").insertAdjacentHTML("beforeend",
                `

                <div class="showOrderBlock margin10"> 
                <div class="showOrderHeader">
                <h1>Номер заказа ${element.id}</h1>
                <div class="showOrderMainData">
                <h2>Адрес доставки: ${element.delivery_addres
                }</h2>
                    <h2>Телефон адресата: ${element.addressee_phone
                }</h2>
                <h2>Статус заказа: ${element.status}</h2>
                    <h2>Желаемая дата доставки ${element.date_of_issue_of_order
                }</h2>
                </div>

                <div class="showOrderTextBlock">
                <h2>Текст записки  </h2>

                <p>${element.discription} </p>
                </div>
                </div>

                    <div class="showOrderProductBlock" id="showOrderProductBlock${element.id}">
                    <h2>Товары в заказе</h2>
                        <table id="tableProductsInOrder${element.id}" >
                        <tr>
                            <td>Наименование</td>
                            <td>Категория</td>
                            <td>Цена</td>
                            <td>Количество</td>
                            <td>Стоимость</td>
                        </tr>
                        </table>
                    </div>
                    <div class="showOrderRecipesBlock" id="showOrderRecipesBlock${element.id}">
                    <h2 >Рецепты в заказе</h2>
                    <table id="tableRecipesInOrder${element.id}">
                    <tr>
                        <td>Наименование/№</td>
                        <td>Цена</td>
                        <td>Количество</td>
                        <td>Стоимость</td>

                    </tr>
                    </table>
                    </div>
                    <div class="showOrderFooterData">
                    <h2>Дата заказа ${element.order_date}</h2>
                        <h2>Итого по заказу ${element.sum
                } руб</h2>
                        <h2>Количество товаров в заказе ${(element.count == null
                    ? 0
                    : +element.count) +
                (element.countRic == null
                    ? 0
                    : +element.countRic)
                } шт</h2>
                    </div>
                </div>
    

            `
            );

            postJSON(
                "/app/admin/adminOrdersJsLoader.php",
                element.id,
                "getAllProductInOrder"
            ).then(function (valuePr) {
                if(valuePr.productInBasket.length > 0){
                let table = document.querySelector(
                    `#tableProductsInOrder${element.id}>tbody`
                );
                console.log(valuePr.productInBasket.length > 0)

                valuePr.productInBasket.forEach((item) => {
                        // console.log(item);
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
                    document.querySelector(`#showOrderProductBlock${element.id}`).innerHTML = "<h2>В заказе нет товаров</h2>"
                }

            });
            postJSON(
                "/app/admin/adminOrdersJsLoader.php",
                element.id,
                "getAllRecipesInOrder"
            ).then(function (valueRe) {
                if(valueRe.productInBasket.length > 0){
                let table = document.querySelector(
                    `#tableRecipesInOrder${element.id}>tbody`
                );
                console.log(valueRe.productInBasket.length);

                valueRe.productInBasket.forEach((item) => {
                        
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
                    document.querySelector(`#showOrderRecipesBlock${element.id}`).innerHTML = "<h2>В заказе нет рецептов</h2>"
                }

            });

            });
            console.log(document.querySelectorAll(".modal>*").length  == 0)
            if(document.querySelectorAll(".modal>*").length  == 0){
                document.querySelector(".modal").innerHTML = "<h2 class='white'>У этого клиента нет заказов</h2>"
            }
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
        })
    }
})

document.addEventListener("change", function(e){
    if(e.target.classList.contains("client_status_change")){
        document.querySelector("body").insertAdjacentHTML("beforeend", `
        <div class="modal-wrapper">
        <div class="modal changeStatusClientModal">
        <div class=" changeStatusClientBlock">
        <h2 class= "modal_title"></h2>
        <button class="client_status_change_confirm" data-client-id ="${e.target.dataset.clientId}" data-status-id="${e.target.value}">Подтвердить</button>
        </div>

        </div>
        </div>
        `)
        postJSON("/app/admin/adminClientsJsLoader.php", e.target.value, "getStatusNameById").then(function(value){
            console.log(value);
            document.querySelector(".modal_title").textContent = `Изменить статус клиента ${e.target.dataset.clientName} на ${value.productInBasket.status}`
        })
        modal = document.querySelector(".modal-wrapper");
        modal.addEventListener("click", function (event) {
            if (event.target == event.currentTarget) {
                modal.remove();
                location.reload()
                //   showOrders(postJSON("/app/admin/adminOrdersJsLoader.php", document.querySelector("#selectStatus").value, "getOrdersByStatus"), sort)
            }
        });
        document.addEventListener("keyup", function (event) {
            console.log(event.key);
            if (event.key == "Escape") {
                modal.remove();
                location.reload()
                //   showOrders(postJSON("/app/admin/adminOrdersJsLoader.php", document.querySelector("#selectStatus").value, "getOrdersByStatus"), sort)
            }
        });
    }
})