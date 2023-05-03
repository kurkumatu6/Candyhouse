let box = document.querySelector(".recipe_ingr");
let ingredients = document.querySelectorAll(".draggable");
let dragItem = "";
let steps = 1;
document.querySelector(".stepAdd").addEventListener("click", function () {
  steps += 1;
  document.querySelector(".stepAdd").insertAdjacentHTML(
    "beforebegin",
    `

<div class="step_block" data-step-number="${steps}">
                        <h2 class="step_title">Шаг ${steps}</h2>
                        <div class="step_body">
                            <textarea name="step${steps}" class="step" data-step-number="${steps}" cols="30" rows="10"></textarea>
                            <div class="step_img_block">
                                <label for="img${steps}" id="img_title${steps}" class="step_img_title">Добавить картинку</label>
                                <input type="file" class="image_step_add" data-id="${steps}" name="img${steps}" id="img${steps}" style="display: none">
                                <input type="text" name="steps-id[]" value="${steps}" style="display: none">
                                <div class="spec" id="spec${steps}">
                                
                                </div>
                            </div>
                        </div>
    `
  );
});
function dtagStart(event) {
  event.currentTarget.classList.add("drag-start");
  let eventTarget = event.currentTarget;
  dragItem = event.currentTarget;
  // setTimeout(blockDisplayNone, 0, eventTarget)
}
// function blockDisplayNone(item){
//     item.style.display= 'none'
// }
// function blockDisplayStart(item){
//     item.style.display= ''
// }
function dtagEnd() {
  // event.currentTarget.classList.remove("drag-start")
  let eventTarget = event.currentTarget;
  // setTimeout(blockDisplayStart, 0, eventTarget)
}
function dragOver(event) {
  event.preventDefault();
}
function dragEnter(event) {
  event.preventDefault();
  event.currentTarget.classList.add("drag-enter");
}
function dragLeave(event) {
  event.preventDefault();
  event.currentTarget.classList.remove("drag-enter");
}
function dragDrop(event) {
  event.preventDefault();
  event.currentTarget.classList.remove("drag-enter");
  console.log(dragItem);
  if (document.querySelector(`#inner${dragItem.dataset.id}`) == null) {
    document.querySelector(".recipe_ingr").insertAdjacentHTML(
      "afterBegin",
      `
        <div id="inner${dragItem.dataset.id}" class="ingredientInRecipe">
            <h2>${dragItem.dataset.name}</h2>
            <div class="ingredientInRecipe_count_block">
            <input type="number" name="ingr${dragItem.dataset.id}" value="10" min="10" class="ingredientCount" data-ingredient-id="${dragItem.dataset.id}" data-calories="${dragItem.dataset.calories}" data-self-life-days="${dragItem.dataset.selfLifeDays}" data-price="${dragItem.dataset.price}">
            <input type="text" name="self-life-days${dragItem.dataset.id}" value="${dragItem.dataset.selfLifeDays}" style="display: none">
            <input type="text" name="calories${dragItem.dataset.id}" value="${dragItem.dataset.calories}" style="display: none">
            <input type="text" name="price${dragItem.dataset.id}" value="${dragItem.dataset.price}" style="display: none">
            <input type="text" name="ingredient-id[]" value="${dragItem.dataset.id}" style="display: none">
            <h2>грамм</h2>
            <h2 id="sumIngrr${dragItem.dataset.id}">Стоимость 0 руб</h2>
            </div>

            <button class="delIngredient">×</button>
        </div>
        
        `
    );
    sum = 0;
    calories = 0;
    document.querySelectorAll(".ingredientCount").forEach((item) => {
      document.querySelector(
        `#sumIngrr${item.dataset.ingredientId}`
      ).textContent = `Стоимость ${
        (+item.value * +item.dataset.price) / 100
      } руб`;
      sum += (+item.value * +item.dataset.price) / 100;
      calories += (+item.value * +item.dataset.calories) / 100;
    });
    document.querySelector(".price").textContent = `Итого: ${sum} руб`;
    document.querySelector(
      ".calory"
    ).textContent = `Пищевая ценность: ${calories} ккал`;
  }
  document.querySelectorAll(".ingredientCount").forEach((item) => {
    item.addEventListener("change", function (e) {
      if (+e.currentTarget.value < 10) {
        e.currentTarget.value = 10;
      }
      document.querySelector(
        `#sumIngrr${e.currentTarget.dataset.ingredientId}`
      ).textContent = `Стоимость ${
        (+e.currentTarget.value * +e.currentTarget.dataset.price) / 100
      } руб`;
      sum = 0;
      calories = 0;
      document.querySelectorAll(".ingredientCount").forEach((item) => {
        sum += (+item.value * +item.dataset.price) / 100;
        calories += (+item.value * +item.dataset.calories) / 100;
      });
      document.querySelector(".price").textContent = `Итого: ${sum} руб`;
      document.querySelector(
        ".calory"
      ).textContent = `Пищевая ценность: ${calories} ккал`;
    });
  });
}
document.addEventListener("click", function (e) {
  if (e.target.classList.contains("delIngredient")) {
    e.target.closest(".ingredientInRecipe").remove();
  }
  if (e.target.classList.contains("complitRecipe")) {
    if (document.querySelectorAll(".ingredientInRecipe").length > 0) {

      // let sum = 0;
      // let days = 1000000000000;
      // let array = [];
      // document.querySelectorAll(".ingredientCount").forEach((item) => {
      //   sum += (+item.value * +item.dataset.price) / 100;
      //   calories += (+item.value * +item.dataset.calories) / 100;
      //   if (item.dataset.selfLifeDays < days) {
      //     days = item.dataset.selfLifeDays;
      //   }
      //   array.push({
      //     ingredientId: item.dataset.ingredientId,
      //     count: +item.value,
      //   });
      // });
      // let text = [];
      // document.querySelectorAll(".step").forEach((item) => {
      //   text.push({ stepId: item.dataset.stepNumber, discript: item.value });
      // });
      // console.log(text);
      // data = { price: sum, discription: text, selfLifeDays: days, data: array };
      // form = document.querySelector(".discript_block");
      // postFormData("/app/tables/recipes/addRecipe.php", form)
      // console.log(postJSON("/app/tables/recipes/addRecipe.php", data, "addRecipe"));
    }
    else{

    }
  }
});
ingredients.forEach((item) => {
  item.addEventListener("dragstart", dtagStart);
  item.addEventListener("dragend", dtagEnd);
  item.insertAdjacentElement;
  item.addEventListener("dblclick", function(e){
    console.log(e.currentTarget)
    if (document.querySelector(`#inner${e.currentTarget.dataset.id}`) == null) {
      document.querySelector(".recipe_ingr").insertAdjacentHTML(
        "afterBegin",
        `
          <div id="inner${e.currentTarget.dataset.id}" class="ingredientInRecipe">
              <h2>${e.currentTarget.dataset.name}</h2>
              <div class="ingredientInRecipe_count_block">
              <input type="number" name="ingr${e.currentTarget.dataset.id}" value="10" min="10" class="ingredientCount" data-ingredient-id="${e.currentTarget.dataset.id}" data-calories="${e.currentTarget.dataset.calories}" data-self-life-days="${e.currentTarget.dataset.selfLifeDays}" data-price="${e.currentTarget.dataset.price}">
              <input type="text" name="self-life-days${e.currentTarget.dataset.id}" value="${e.currentTarget.dataset.selfLifeDays}" style="display: none">
              <input type="text" name="calories${e.currentTarget.dataset.id}" value="${e.currentTarget.dataset.calories}" style="display: none">
              <input type="text" name="price${e.currentTarget.dataset.id}" value="${e.currentTarget.dataset.price}" style="display: none">
              <input type="text" name="ingredient-id[]" value="${e.currentTarget.dataset.id}" style="display: none">
              <h2>грамм</h2>
              <h2 id="sumIngrr${e.currentTarget.dataset.id}">Стоимость 0 руб</h2>
              </div>
  
              <button class="delIngredient">×</button>
          </div>
          
          `
      );
      sum = 0;
      calories = 0;
      document.querySelectorAll(".ingredientCount").forEach((item) => {
        document.querySelector(
          `#sumIngrr${item.dataset.ingredientId}`
        ).textContent = `Стоимость ${
          (+item.value * +item.dataset.price) / 100
        } руб`;
        sum += (+item.value * +item.dataset.price) / 100;
        calories += (+item.value * +item.dataset.calories) / 100;
      });
      document.querySelector(".price").textContent = `Итого: ${sum} руб`;
      document.querySelector(
        ".calory"
      ).textContent = `Пищевая ценность: ${calories} ккал`;
    }
    document.querySelectorAll(".ingredientCount").forEach((item) => {
      item.addEventListener("change", function (e) {
        if (+e.currentTarget.value < 10) {
          e.currentTarget.value = 10;
        }
        document.querySelector(
          `#sumIngrr${e.currentTarget.dataset.ingredientId}`
        ).textContent = `Стоимость ${
          (+e.currentTarget.value * +e.currentTarget.dataset.price) / 100
        } руб`;
        sum = 0;
        calories = 0;
        document.querySelectorAll(".ingredientCount").forEach((item) => {
          sum += (+item.value * +item.dataset.price) / 100;
          calories += (+item.value * +item.dataset.calories) / 100;
        });
        document.querySelector(".price").textContent = `Итого: ${sum} руб`;
        document.querySelector(
          ".calory"
        ).textContent = `Пищевая ценность: ${calories} ккал`;
      });
    });
  })
});
// события для перетаскиваемого элемента

// события для целевой области перетаскивания
box.addEventListener("dragover", dragOver); //разрешение на перетаскивание
box.addEventListener("dragenter", dragEnter);
box.addEventListener("dragleave", dragLeave);
box.addEventListener("drop", dragDrop);

document.addEventListener("change", function(e){
  if(e.target.classList.contains("image_step_add")){
    let block = document.querySelector(`#spec${e.target.dataset.id}`)
    // console.log
    block.innerHTML = ""
    console.log(block)
    let file = e.target.files[0]
    let imgURL =URL.createObjectURL(file)
    document.querySelector(`#img_title${e.target.dataset.id}`).textContent = "Изменить картинку"
    block.insertAdjacentHTML("beforeend", `<img class="step_image" id="step_image${e.target.dataset.id}" src="${imgURL}" alt="" />
    <h2 class ="delImageForStep" data-id="${e.target.dataset.id}">Удалить картинку</h2>
    `)
  }
})
document.addEventListener("click", function(e){
  if(e.target.classList.contains("delImageForStep")){
    let input = document.querySelector(`#img${e.target.dataset.id}`)
    input.remove()
    let block = e.target.closest(".step_img_block")

    input = document.querySelector(`#img${e.target.dataset.id}`)
    console.log(block )
    document.querySelector(`#spec${e.target.dataset.id}`).innerHTML ="";
    document.querySelector(`#img_title${e.target.dataset.id}`).remove();
    block.insertAdjacentHTML("afterBegin", `
    <label for="img${e.target.dataset.id}" id="img_title${e.target.dataset.id}" class="step_img_title">Добавить картинку</label>
    <input type="file" class="image_step_add" data-id="${e.target.dataset.id}" name="img${e.target.dataset.id}" id="img${e.target.dataset.id}" style="display: none">`)
    // document.querySelector(`#img_title${e.target.dataset.id}`).textContent = "Добавить картинку"
  }
})

// {/* <div class="step_block" data-step-number="${steps}">
// // <h2>Шаг ${steps}</h2>
// // <textarea name="step${steps}" class="step" data-step-number="${steps}" cols="30" rows="10"></textarea>
// // <input type="file" name="img${steps}" id="">
// // <input type="text" name="steps-id[]" value="${steps}" style="display: none">
// // </div> */