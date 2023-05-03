

document.addEventListener("DOMContentLoaded", () => {
    let loadCount = 3;
    let page = 1;
    let sort= 0;
    let loader = true;
    let arr =[];
    arr.length
    let productsContainer = document.querySelector(".products-container");
    let categorySelector = document.querySelector("#categorySelector");
    getProductsByCategory(categorySelector.value, sort)

    // document.querySelector("#priceSort").addEventListener("click", async function(){


    // })
    // await getProductsByCategory(categorySelector.value)
    //отрабатываем выбор категории
    // startStr(categoryCheck)
    // categoryCheck.forEach(item => {
    //     item.addEventListener("change", async() => {
    //         //формируем массив из id категорий, взяли колекцию в массив вытащили вкл флажки и забрали включенные
    //         let categoriesChecked = [...categoryCheck].filter(item => item.checked).map(item=>item.value);
    //         //получаем товары выбранной категории
    //         await getProductsByCategory(categoriesChecked);
    //     })
    // });
    // async function startStr(categoryCheck){
    //     let categoriesChecked = [...categoryCheck].filter(item => item.checked).map(item=>item.value);
    //     //получаем товары выбранной категории
    //     await getProductsByCategory(categoriesChecked);
    // }
    categorySelector.addEventListener("change", async function(e){
        // console.log(e)
        loadCount = 3;
        page = 1;
        category = e.currentTarget.value
        await getProductsByCategory(category, sort)
    })
    async function getProductsByCategory(categories , priceSort) {
        //формируем параметр запроса
        // console.log(priceSort)
        let param = new URLSearchParams();
        param.append('categories', JSON.stringify(categories))
        param.append('limit', JSON.stringify(loadCount*page))
        // console.log(param);
        let products = await getData("/app/tables/product/loadProducts.php", param);
        let count = products.length
        if(priceSort === 0){
            document.querySelector("#priceSort").textContent = "Цена "
        }
        else if(priceSort === 1){
            document.querySelector("#priceSort").textContent = "Цена ↑"
            products.sort((a,b) => +a.price - +b.price)
        }
        else{
            document.querySelector("#priceSort").textContent = "Цена ↓"
            products.sort((a,b) => +b.price - +a.price)
        }
        // if(loadCount*page< count){
        //     products = products.slice(0,loadCount*page);
        // }
        // else{
        //     loader = false
        // }

        showProducts(products);
    }

    //вывод карточек по категориям на страницу
    function showProducts(products){
        productsContainer.innerHTML = "";
        // console.log(products)


            products.forEach(product => {
                productsContainer.insertAdjacentHTML("beforeend", getOneCard(product))
            })


        // countProducts.textContent = "Количество товаров по выбраным категориям " +products.length + " шт";
    }

    //формирование одной карточки
    function getOneCard({id, name, image, price}){
        if(image == null){
            image = "placeholder.png"
        }
        return `                

        <div class="product_card_ind">
        <a class="product_for_show_ssl" href="/app/tables/product/product.php?id=${id}">
            <img src="/upload/${image}" alt="">
            <div class="product_content_div">
            <h2 class="name_for_show_product">${name}</h2>
            <h2 class="product_price_show"> ${+price}<span class="small2">₽</span></h2>
            </div>

            </a>
            <button data-product-id="${id}" class ="btn-basket">В корзину</button>
        </div>
`
    }
    // select.addEventListener
    //добавление товара в корзину
    document.addEventListener("click", async(event)=> {
        if(event.target.classList.contains("btn-basket")){
            // console.log(111)
            let id = event.target.dataset.productId;
            let res = await postJSON("/app/tables/busket/save.busket.php",id,"add");
            console.log(res);
        }
    })
    window.addEventListener('scroll', function() {
        Visible (document.querySelector("#pageLoader"), loader);

    });
    function Visible (target, load) {
        // Все позиции элемента
        let targetPosition = {
            top: window.pageYOffset + target.getBoundingClientRect().top,
            left: window.pageXOffset + target.getBoundingClientRect().left,
            right: window.pageXOffset + target.getBoundingClientRect().right,
            bottom: window.pageYOffset + target.getBoundingClientRect().bottom
          },
          // Получаем позиции окна
          windowPosition = {
            top: window.pageYOffset,
            left: window.pageXOffset,
            right: window.pageXOffset + document.documentElement.clientWidth,
            bottom: window.pageYOffset + document.documentElement.clientHeight
          };
      
        if (targetPosition.bottom > windowPosition.top && // Если позиция нижней части элемента больше позиции верхней чайти окна, то элемент виден сверху
          targetPosition.top < windowPosition.bottom && // Если позиция верхней части элемента меньше позиции нижней чайти окна, то элемент виден снизу
          targetPosition.right > windowPosition.left && // Если позиция правой стороны элемента больше позиции левой части окна, то элемент виден слева
          targetPosition.left < windowPosition.right && load) { // Если позиция левой стороны элемента меньше позиции правой чайти окна, то элемент виден справа
          // Если элемент полностью видно, то запускаем следующий код
          page += 1;
          console.log(sort)
          getProductsByCategory(categorySelector.value, sort)
        } else {
        //   // Если элемент не видно, то запускаем этот код
        //   console.clear();
        };
      };
      document.addEventListener("click", async function(e){
        if(e.target.id == "priceSort"){
            sort += 1 
            if(sort > 2){
                sort = 0
            } 
            let category = categorySelector.value
            // let param = new URLSearchParams();
            // param.append('categories', JSON.stringify(category))
            // let products = await getData("/app/tables/product/loadProducts.php", param);
            // console.log(sort)
            getProductsByCategory(document.querySelector("#categorySelector").value, sort)
        }
    })
})

async function getData(route, params = "") {
    if (params != "") {
      route += `?${params}`;
    }
  		console.log(route)
    let response = await fetch(route);
    
    return await response.json();
  }
  
async function postJSON(route, data, action){
    let response = await fetch(route, {
        method: "POST",
        headers: {
          "Content-Type": "application/json;charset=UTF-8", //обязательный заголовок для формата json
        },
        body: JSON.stringify({data,action}),
      });
      return await response.json()
}
async function postFormData(route, form){
    // console.log(FormData(form))
    let response = await fetch(route, {
        method: "POST",
        // headers: {
        //   "Content-Type": "application/json;charset=UTF-8", //обязательный заголовок для формата json
        // },
        body: new FormData(form),
      });
      return await response.json();
}
