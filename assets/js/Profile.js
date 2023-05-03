document.addEventListener("click", function(e){
    if(e.target.classList.contains("addReview")){
        document.querySelector("body").insertAdjacentHTML("beforeend", `
        <div class="modal-wrapper">
          <div class="modal addRewiewModal">
            <form id='addReviewForm' method="POST" >
            
            <label for="">Отзыв</label>
            <textarea name="review" id="reviweText" cols="30" rows="10"></textarea>
            <p class="error" id="rewievError" style="display:none"></p>
            <input type="text" name="product_id" value="${e.target.dataset.productId}" style="display: none">
          </form>
          <button class="addReviewConfirm" name="product_id" value="${e.target.dataset.productId}">Сохранить</button>
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
  if(e.target.classList.contains("addReviewConfirm")){
    
      let text = document.querySelector("#reviweText").value
      let errorBlock = document.querySelector("#rewievError")
      console.log(text.length);
      // if(text.length < 10){
      //   errorBlock.style.display = "block"
      //   errorBlock.textContent = "Отзыв не может содержать мение 10 символов"

      // }
      // else{
        postFormData("/app/tables/reviews/addReview.php", document.querySelector("#addReviewForm")).then(function(value){
          console.log(value)
          if(value.productInBasket != ""){
                    errorBlock.style.display = "block"
              errorBlock.textContent = value.productInBasket
          }
          else{
          
        document.querySelector(".modal-wrapper").remove();
          }
        })

      // }

  }
})