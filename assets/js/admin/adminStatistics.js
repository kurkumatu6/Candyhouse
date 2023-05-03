document.querySelector("#diagrammSelector").addEventListener("change", function(e){
    let container = document.querySelector(".CurrentDiagrammSelectors")
    container.innerHTML = ""
    if(e.currentTarget.value == "none"){
        container.insertAdjacentHTML("beforeend", `<h2>Выберите тип диаграммы</h2>`)
    }
    if(e.currentTarget.value == "productsByTime"){
        container.insertAdjacentHTML("beforeend", `
        <div class="diagramm_tupe_selector_block">
            <h2>Вид диаграммы</h2>
            <select name="" id="diagrammType">
                <option value="curcle">Круговая</option>
                <option value="stolb">Столбчатая</option>
            </select>
        </div>
    <div class="dates_selectors">
        <div id="dateStart_block">
            <h2>Дата начала</h2>
            <input type="date" name="" id="dateStart">
        </div >
        <div id="dateEnd_block">
            <h2>Дата конца</h2>
            <input type="date" name="" id="dateEnd">
        </div>
    </div>

        `)
    }
    if(e.target.value == "countNewclients"){
        container.insertAdjacentHTML("beforeend", `
        <div class="diagramm_tupe_selector_block">
            <h2>Вид диаграммы</h2>
            <select name="" id="diagrammType">
                <option value="graf">График</option>
                <option value="stolb">Столбчатая</option>
            </select>
        </div>

    <div class="dates_selectors">
        <div id="dateStart_block">
            <h2>Дата начала</h2>
            <input type="date" name="" id="dateStart">
        </div>
        <div id="dateEnd_block">
            <h2>Дата конца</h2>
            <input type="date" name="" id="dateEnd">
        </div>
    </div>
        `)

    
    }
    if(e.target.value == "moneyByTime"){
        container.insertAdjacentHTML("beforeend", `
        <div class="diagramm_tupe_selector_block">
            <h2>Вид диаграммы</h2>
            <select name="" id="diagrammType">
                <option value="graf">График</option>
                <option value="stolb">Столбчатая</option>
            </select>
        </div>
    <div class="dates_selectors">
        <div id="dateStart_block">
            <h2>Дата начала</h2>
            <input type="date" name="" id="dateStart">
        </div>
        <div id="dateEnd_block">
            <h2>Дата конца</h2>
            <input type="date" name="" id="dateEnd">
        </div>
    </div>
        `)
    }
    if(e.target.value == "CountProductPopulyarit"){
        container.insertAdjacentHTML("beforeend", `
        <div class="diagramm_tupe_selector_block">
            <h2>Вид диаграммы</h2>
            <select name="" id="diagrammType">
                <option value="graf">График</option>
                <option value="stolb">Столбчатая</option>
            </select>
        </div>
        <div class="towar_selector">
            <h2>Товар</h2>
            <select id="prouctSelector">
            </select>
        </div>

    <div class="dates_selectors">
        <div id="dateStart_block">
            <h2>Дата начала</h2>
            <input type="date" name="" id="dateStart">
        </div>
        <div id="dateEnd_block">
            <h2>Дата конца</h2>
            <input type="date" name="" id="dateEnd">
        </div>
    </div>
        `)
        postJSON("/app/admin/adminStatisticsJsloader.php", "" , "getAllProductsForSelector").then(function(value){
            console.log(value)
            let selector = document.querySelector("#prouctSelector")
            value.productInBasket.forEach(item=>{
                selector.insertAdjacentHTML("beforeend", `<option value="${item.id}">${item.name}</option>`)
            })
        })
    }
})
async function createCurcleDiagramm(values, diagrammName){
    console.log(values)
    chart1 = Highcharts.chart({
        chart: {
            renderTo: 'diagrammContainer',
            type: 'pie'
        },
        title: {
            text: diagrammName,
            
        },
        accessibility: {
            point: {
              valueSuffix: '%'
            }
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y} '
              }
            }
          },
        series:[{
            name: 'Количество',
            colorByPoint: true,
            data:values
        },
    ],
    });
}
async function createStolbDiagramm(values,names, diagrammName ,name){
    console.log(values)
    chart1 = Highcharts.chart({
        chart: {
            renderTo: 'diagrammContainer',
            type: 'column'
        },
        title: {
            text: diagrammName,
            
        },
        // accessibility: {
        //     point: {
        //       valueSuffix: '%'
        //     }
        //   },
        xAxis: {
            categories: names,
            crosshair: true
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y} '
              }
            }
          },
        series:[{
            name: name,
            colorByPoint: true,
            data:values
        },
    ],
    });
}
async function createGraf(values,names, diagrammName, name){
    Highcharts.chart( {
        chart: {
            renderTo: 'diagrammContainer',
            type: 'line'
        },
        title:{
            text: diagrammName   
         },
        xAxis:{
            categories: names,
            crosshair: true
        },
        series: [{
            name: name,
            data: values,

        }]
    });
}
document.querySelector("#diagrammCreate").addEventListener("click", function(e){
    if(document.querySelector("#diagrammSelector").value == "productsByTime"){
        
        let dateStart = document.querySelector("#dateStart").value
        let dateEnd = document.querySelector("#dateEnd").value
        postJSON("/app/admin/adminStatisticsJsloader.php", {"dateStart":dateStart, "dateEnd":dateEnd} , "getCountProductsInOrdersByDates").then(function(value){
            let values = [];
            let names = []
            value.productInBasket.forEach(element => {
                values.push({"name":element.name, "y": +element.data});
                names.push(element.name);
            });

            if(document.querySelector("#diagrammType").value == "curcle"){
                console.log("aaaaa")
                createCurcleDiagramm(values, "Заказанные товары")
            }
            if(document.querySelector("#diagrammType").value == "stolb"){
                createStolbDiagramm(values, names, "Заказанные товары", "Количество")
            }
        })
    }
    if(document.querySelector("#diagrammSelector").value == "countNewclients"){
        let dateStart = document.querySelector("#dateStart").value
        let dateEnd = document.querySelector("#dateEnd").value

        postJSON("/app/admin/adminStatisticsJsloader.php", {"dateStart":dateStart, "dateEnd":dateEnd} , "getDates").then(function (value){
            console.log(value)
            let values = []
            let dates = [];
            value.productInBasket.forEach(element => {
                values.push(+element.count);
                dates.push(element.date_of_registration);
            });
            if(dateStart == ""){
                dateStart = "1970-01-01";
            }
            if(dateEnd == ""){
                dateEnd = `${new Date().getFullYear()}-${new Date().getMonth() <10?"0"+new Date().getMonth():new Date().getMonth()}-${new Date().getDate() <10?"0"+ new Date().getDate():new Date().getDate()}`;
            }
            if(document.querySelector("#diagrammType").value == "graf"){
                createGraf(values, dates, `Количество регистраций за период  \n с ${dateStart} по ${dateEnd}`, "регистраций")
            }
            if(document.querySelector("#diagrammType").value == "stolb"){
                console.log(dateStart)
                createStolbDiagramm(values, dates, `Количество регистраций за период  \n с ${dateStart} по ${dateEnd}`, "регистраций")
            }
        })

    }
    if(document.querySelector("#diagrammSelector").value == "CountProductPopulyarit"){
        let dateStart = document.querySelector("#dateStart").value
        let dateEnd = document.querySelector("#dateEnd").value

        postJSON("/app/admin/adminStatisticsJsloader.php", {"dateStart":dateStart, "dateEnd":dateEnd, "product_id":document.querySelector("#prouctSelector").value} , "getProductPopularity").then(function(value){
            console.log(value)
            let values = []
            let dates = [];
            value.productInBasket.forEach(element => {
                values.push(+element.count);
                dates.push(element.order_date);
            });
            if(dateStart == ""){
                dateStart = "1970-01-01";
            }
            if(dateEnd == ""){
                dateEnd = `${new Date().getFullYear()}-${new Date().getMonth() <10?"0"+new Date().getMonth():new Date().getMonth()}-${new Date().getDate() <10?"0"+ new Date().getDate():new Date().getDate()}`;
            }
            if(document.querySelector("#diagrammType").value == "graf"){
                createGraf(values, dates, `Количество популярость продукта за \n с ${dateStart} по ${dateEnd}`, "Количество заказанных позиций")
            }
            if(document.querySelector("#diagrammType").value == "stolb"){
                console.log(dateStart)
                createStolbDiagramm(values, dates, `Количество популярость продукта за период  \n с ${dateStart} по ${dateEnd}`, "Количество заказанных позиций")
            }
        })
    }
    if(document.querySelector("#diagrammSelector").value == "moneyByTime"){
        let dateStart = document.querySelector("#dateStart").value
        let dateEnd = document.querySelector("#dateEnd").value
        postJSON("/app/admin/adminStatisticsJsloader.php", {"dateStart":dateStart, "dateEnd":dateEnd} , "getMoneuByTime").then(function(value){
            console.log(value)
            let values = []
            let dates = [];
            value.productInBasket.forEach(element => {
                values.push(+element.sum);
                dates.push(element.order_date);
            });
            if(dateStart == ""){
                dateStart = "1970-01-01";
            }
            if(dateEnd == ""){
                dateEnd = `${new Date().getFullYear()}-${new Date().getMonth() <10?"0"+new Date().getMonth():new Date().getMonth()}-${new Date().getDate() <10?"0"+ new Date().getDate():new Date().getDate()}`;
            }
            if(document.querySelector("#diagrammType").value == "graf"){
                createGraf(values, dates, `Количество доход за перод \n с ${dateStart} по ${dateEnd}`, "рублей")
            }
            if(document.querySelector("#diagrammType").value == "stolb"){
                console.log(dateStart)
                createStolbDiagramm(values, dates, `Количество доход за период \n с ${dateStart} по ${dateEnd}`, "рублей")
            }
        })

    }
})