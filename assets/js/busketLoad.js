async function outResult(productId, action) {
  let { productInBasket, allSum, allCount } = await postJSON(
    "/app/tables/busket/save.busket.php",
    productId,
    action
  );
  // console.log(productInBasket);
  //проверим что не удаление
  if (productInBasket != "delete") {
    document.getElementById(
      `product-count-${productId}`
    ).textContent = `Количество: ${productInBasket.count} шт`;
    document.getElementById(
      `product-price-${productId}`
    ).textContent = `Стоимость ${productInBasket.position_price}<span class="small">₽</span>`;
    
  }

  //если корзина пустая надо вывести слова "корзина пустая"
  document.getElementById("obsh").textContent = `Общая сумма ${allSum} рублей`;
  document.getElementById("total-count").textContent = `Количество ${allCount} шт`;
  return productInBasket;
}
async function outResultForRecipes(recipeId, action) {
  let { productInBasket, allSum, allCount } = await postJSON(
    "/app/tables/busket/save.busket.php",
    recipeId,
    action
  );
  // console.log(productInBasket);
  //проверим что не удаление
  console.log(productInBasket);
  if (productInBasket != "delete") {
    document.getElementById(
      `recipe-count-${recipeId}`
    ).textContent = `Количество: ${productInBasket.count} шт`;
    document.getElementById(
      `recipe-price-${recipeId}`
    ).innerHTML= `Стоимость ${productInBasket.price_position}<span class="small">₽</span>`;
    
  }

  //если корзина пустая надо вывести слова "корзина пустая"
  document.getElementById("obsh").textContent = `Общая сумма ${allSum} рублей`;
  document.getElementById("total-count").textContent = `Количество ${allCount} шт`;
  return productInBasket;
}

console.log(document.querySelectorAll(".basket-position").length)
if (document.querySelectorAll(".basket-position").length == 0) {
  document.querySelector(".products-container").innerHTML = "<div class='basketVoid'><p>Корзина пуста</p></div>"
  document.querySelector(".basket_controls").remove();
}
document.addEventListener("click", async (event) => {
  let e = event;
  if (event.target.classList.contains("minus")) {
    outResult(event.target.dataset.productId, "minus").then(function(value){
      if(value == "delete"){
      event.target.closest(".basket-position").remove();
      }
      if (document.querySelectorAll(".basket-position").length == 0) {
        // document.getElementById("obsh").textContent = `Общая сумма 0 рублей`;
        // document.getElementById("total-count").textContent = `Количество 0 шт`;
        document.querySelector(".products-container").innerHTML = "<div class='basketVoid'><p>Корзина пуста</p></div>"
        document.querySelector(".basket_controls").remove();
      }
    })

  }
  if (event.target.classList.contains("plus")) {
    outResult(event.target.dataset.productId, "add");
  }
  if (event.target.classList.contains("delete")) {
    outResult(event.target.dataset.productId, "del");
    event.target.closest(".basket-position").remove();
    if (document.querySelectorAll(".basket-position").length == 0) {
      // document.getElementById("obsh").textContent = `Общая сумма 0 рублей`;
      // document.getElementById("total-count").textContent = `Количество 0 шт`;
      document.querySelector(".products-container").innerHTML = "<div class='basketVoid'><p>Корзина пуста</p></div>"
      document.querySelector(".basket_controls").remove();
    }
  }
  if (event.target.classList.contains("minusRecipe")) {
    outResultForRecipes(event.target.dataset.productId, "minusRecipe").then(function(value){
      if(value == "delete"){
      event.target.closest(".basket-position").remove();
      }
      if (document.querySelectorAll(".basket-position").length == 0) {
        // document.getElementById("obsh").textContent = `Общая сумма 0 рублей`;
        // document.getElementById("total-count").textContent = `Количество 0 шт`;
        document.querySelector(".products-container").innerHTML = "<div class='basketVoid'><p>Корзина пуста</p></div>"
        document.querySelector(".basket_controls").remove();
      }
    })

  }
  if (event.target.classList.contains("plusRecipe")) {
    outResultForRecipes(event.target.dataset.productId, "addRecipe");
  }
  if (event.target.classList.contains("deleteRecipe")) {
    outResultForRecipes(event.target.dataset.productId, "delRecipe");
    event.target.closest(".basket-position").remove();
    if (document.querySelectorAll(".basket-position").length == 0) {
      // document.getElementById("obsh").textContent = `Общая сумма 0 рублей`;
      // document.getElementById("total-count").textContent = `Количество 0 шт`;
      document.querySelector(".products-container").innerHTML = "<div class='basketVoid'><p>Корзина пуста</p></div>"
      document.querySelector(".basket_controls").remove();
    }
  }
  if (event.target.classList.contains("clear")) {
    postJSON("/app/tables/busket/save.busket.php", 0, "clear")
    document.querySelectorAll(".basket-position").forEach(item => {
      console.log(item)
      item.remove();
    })
    document.getElementById("obsh").textContent = `Общая сумма 0 рублей`;
    document.getElementById("total-count").textContent = `Количество 0 шт`;
    document.querySelector(".products-container").innerHTML = "<div class='basketVoid'><p>Корзина пуста</p></div>"
    document.querySelector(".basket_controls").remove();
  }
});

document.addEventListener("click", async function (e) {
  if (e.target.classList.contains("createOrderBtnl")) {
    document.querySelector("body").insertAdjacentHTML("beforeend", `
          <div class="modal-wrapper">
            <div class="modal createOrderModal">
              <form id='createOrderForm' method="POST" action="/app/tables/orders/createOrder.php">
              <label for="">Адрес доставки</label>
              <input type="text" name="adress" id="adress">
              <label for="">Телефон получателя</label>
              <input type="tel" placeholder="+7/8 *** *** ** **" name="phone" id="phone">
              <label for="">Дата доставки заказа</label>
              <input type="date" name="date" id="date">
              <label for="">Текст записки</label>
              <textarea name="text" id="" cols="30" rows="10"></textarea>

            </form>
            <button class="createOrderConfirm">Оформить заказ</button>
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
    let date =document.querySelector("#date")
          // let date = document.querySelector("#date")
          // let now = new Date()
          // console.log(now);
          // now.setDate(now.getDate() + 5);
          // console.log(now);
          // console.log(now.getDay());
          postJSON("/app/tables/busket/save.busket.php","","getMaxPerarationTime").then(function(value){
            let d = new Date();
            console.log(value)
            d.setDate(d.getDate() + value.productInBasket.days+1)
            date.valueAsDate = d;
            console.log(d)
          });

  }

  if (e.target.classList.contains("createOrderConfirm")) {
    
    

    let now = new Date()

    // form.addEventListener("submit", function(){
    let phone = document.querySelector("#phone");
    let adress = document.querySelector("#adress");
    let selectedDate = date.value;
    let error = false;
    console.log(111)
    if (phone.value.length < 10) {
      error = true
      if(document.querySelector("#phoneError")== null){
        phone.insertAdjacentHTML("afterend", '<p class="error" id="phoneError">Телефон не может быть меньше 10 символов</p>')
      }
    }
    else{
      if(document.querySelector("#phoneError")!= null){
        document.querySelector("#phoneError").remove()
      }
    }
    if (adress.value.length < 10) {
      error = true
      if(document.querySelector("#adrError")== null){
        adress.insertAdjacentHTML("afterend", '<p class="error" id="adrError">Адрес не может быть меньше 10 символов</p>')
      }

    }
    else{
      if(document.querySelector("#adrError")!= null){
        document.querySelector("#adrError").remove()
      }
    }
    console.log(new Date(selectedDate))
    postJSON("/app/tables/busket/save.busket.php","","getMaxPerarationTime").then(function(value){
      now.setDate(now.getDate() + value.productInBasket.days)
      if (new Date(selectedDate) <= now) {
        error = true
        // date.insertAdjacentHTML("afterend", '<p class="error">Мы не можем выполнить заказ так быстро. дайте нам хотя бы пару дней</p>')
        if(document.querySelector("#dateError")== null){
          let text = ""
          if(value.productInBasket.days>=5 && value.productInBasket.days <= 15){
              text="дней"
          }
          else{
              if((value.productInBasket.days+1)%10 == 1){
                  text="день"
              }
              if((value.productInBasket.days+1) > 1 && (value.productInBasket.days+1) <= 4){
                  text="дня"
              }
              if((value.productInBasket.days+1) >= 5 || (value.productInBasket.days+1)%10 == 0){
                  text="дней"
              }
          }
          date.insertAdjacentHTML("afterend", `<p class="error" id="dateError">Мы не можем выполнить заказ так быстро. нам нужно минимум ${value.productInBasket.days+1} ${text}</p>`)
        }
      }
      else{
        if(document.querySelector("#dateError")!= null){
          document.querySelector("#dateError").remove()
        }
      }
    });

    if (!error) {
      let form = document.querySelector("#createOrderForm")
        console.log(form);
        let responsr = postFormData("/app/tables/orders/createOrder.php", form) 
        responsr.then(function(value){
          if(value){
            

          }
        })
        document.querySelector(".products-container").innerHTML = "<div class='basketVoid'><p>Корзина пуста</p></div>"
        document.querySelector(".basket_controls").remove();
        document.querySelector(".modal-wrapper").remove();
        console.log(responsr)

// form.submit()
    }

    // })
  }
})
