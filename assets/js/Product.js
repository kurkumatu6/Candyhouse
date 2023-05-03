let back = document.querySelector("#back");
let next = document.querySelector("#next");
let nums = 0;
let images =document.querySelectorAll(".productImage");
let countImages = images[0].dataset.count;
let countRewievs = document.querySelectorAll(".rewiev").length;
if(countRewievs == 0){
    document.querySelector(".rewievs").insertAdjacentHTML("afterbegin","<div class='noRewievs'><h2>Отзывов пока что нет закажите! этот товар и будте первыми.</h2></div>")
}
slider(nums)
function slider(num){
    images.forEach(item => {
        if(item.dataset.num != num){
            
            item.style.display = "none"
        }
        else{
            item.style.display = "block"
        }
    })
}
images.forEach(item => {
    item.addEventListener("click", function(){
        nums += 1;
        if(nums> countImages){
            nums = 0;
        }
        slider(nums)
    })
})
document.querySelector("#back").addEventListener("click", function(){
    nums -= 1;
    if(nums< 0){
        nums = countImages;
    }
    console.log(nums)
    slider(nums)
})
next.addEventListener("click", function(){
    nums += 1;
    if(nums> countImages){
        nums = 0;
    }
    slider(nums)
})


document.addEventListener("click", async function(e){
    if(e.target.classList.contains("addProductInBasket")){
        // console.log(111)
        let id = e.target.dataset.productId;
        let res = await postJSON("/app/tables/busket/save.busket.php",id,"add");
        console.log(res);
    }
})