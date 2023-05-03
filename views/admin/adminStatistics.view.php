<?php
        
require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/adminHeader.php";?>
    <main id="adminMain_main">
    <h1 class="title">Статистика</h1>
        <div class="tabelBlock">
            <div class="startStatisticsControls">
                <div id="block_aaaaa">
                <h2>Тип диаграммы</h2>
                <select name="" id="diagrammSelector">
                    <option value="none">none</option>
                    <option value="productsByTime">Заказанные товары</option>
                    <option value="moneyByTime">Доход по заказам с сайта</option>
                    <option value="CountProductPopulyarit">Популярность товара</option>
                    <option value="countNewclients">Количество новых клиентов</option>
                </select>
                </div>

                <div>
                <div class="CurrentDiagrammSelectors">
                    <h2>Выберите тип диаграммы</h2>
                </div>
                
                <div id="diagrammContainer">
                    <h2>Здесь будет диаграмма</h2>
                </div>
                </div>

                <button id="diagrammCreate">Сформировать диаграмму</button>
            </div>
        </div>
    </main>
</body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js" type="text/javascript" defer></script>
<script src="https://code.highcharts.com/highcharts.js" defer></script>
<script src="/assets/js/feach.js"></script>
<script src="/assets/js/admin/adminStatistics.js"></script>
</html>