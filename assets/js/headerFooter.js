let trydisel= true
if(document.documentElement.clientWidth < 720 && trydisel){
 trydisel= false
        document.querySelector("header").classList.add("small_header")
        
        document.querySelector("#logo").id ="small_logo"
        document.querySelector(".buttons").classList.add("small_buttons")
        document.querySelector(".buttons").classList.add("openflex")
        document.querySelector(".nav_logo").classList.add("small_nav_logo")
        document.querySelector(".nav_logo").classList.remove("nav_logo")
        document.querySelector(".buttons").classList.remove("buttons")
        if(document.querySelector("header>.header_comand_block_open_close") == null){
            document.querySelector("header").insertAdjacentHTML("beforeend", `<button class="header_comand_block_open_close">↓</button>`)
        }
document.querySelector("footer").classList.add("bottom")
}
window.addEventListener('resize', function(){
    if(document.documentElement.clientWidth < 720 && trydisel){
        trydisel= false
        document.querySelector("header").classList.add("small_header")
        
        document.querySelector("#logo").id ="small_logo"
        document.querySelector(".buttons").classList.add("small_buttons")
        document.querySelector(".buttons").classList.add("openflex")
        document.querySelector(".nav_logo").classList.add("small_nav_logo")
        document.querySelector(".nav_logo").classList.remove("nav_logo")
        document.querySelector(".buttons").classList.remove("buttons")
        if(document.querySelector("header>.header_comand_block_open_close") == null){
            document.querySelector("header").insertAdjacentHTML("beforeend", `<button class="header_comand_block_open_close">↓</button>`)
        }
        
    }
    if(document.documentElement.clientWidth > 720 && !trydisel){
        trydisel= true
        document.querySelector("header").classList.remove("small_header")
    
        document.querySelector("#small_logo").id ="logo"
        document.querySelector(".small_nav_logo").classList.add("nav_logo")
        document.querySelector(".small_buttons").classList.remove("close")
        document.querySelector(".small_buttons").classList.add("buttons")

        document.querySelector(".small_buttons").classList.remove("small_buttons")
        document.querySelector(".buttons").classList.remove("openflex")
        document.querySelector(".small_nav_logo").classList.remove("small_nav_logo")
        document.querySelector("header>.header_comand_block_open_close").remove()
        document.querySelector("#catalog").style.display = "block"
        document.querySelector("#constructor").style.display = "block"
        document.querySelector("#about").style.display = "block"
    }
})
document.addEventListener("click", function(e){
    if(e.target.classList.contains("header_comand_block_open_close")){
        
        let glossary = document.querySelector(".small_buttons")
        // console.log(document.querySelector(".buttons").classList.contains("small_buttons") )
        if(glossary.classList.contains("openflex")  ){
            e.target.textContent = "↑"
            glossary.classList.remove("openflex")
            glossary.classList.add("close")
            document.querySelector("#catalog").style.display = "none"
            document.querySelector("#constructor").style.display = "none"
            document.querySelector("#about").style.display = "none"
            
        }
        else if(glossary.classList.contains("close") ){
            e.target.textContent = "↓"
            glossary.classList.add("openflex")
            glossary.classList.remove("close")
            document.querySelector("#catalog").style.display = "block"
            document.querySelector("#constructor").style.display = "block"
            document.querySelector("#about").style.display = "block"
        }
    }
})