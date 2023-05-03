let photos = document.querySelectorAll('.photos')
let radios = document.querySelectorAll(".photos_radio")
radios.forEach(itemrad => {
    if(itemrad.checked){
        console.log(itemrad)
        photos.forEach(item=>{
            if(item.dataset.id === itemrad.dataset.id){
                item.classList.add("open")
                item.classList.remove("close")
            }
            else{
                item.classList.add("close")
                item.classList.remove("open")
            }
        })
    }
    itemrad.addEventListener("change", function(e){
        photos.forEach(item=>{
            if(item.dataset.id === e.currentTarget.dataset.id){
                item.classList.add("open")
                item.classList.remove("close")
            }
            else{
                item.classList.add("close")
                item.classList.remove("open")
            }
        })
    })

    
})
