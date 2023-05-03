<?php
        
require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/adminHeader.php";?>
    <main id="adminMain_main" class="main">
    <h1 class="title">Главная</h1>
        <div class="tabelBlock ">
            <div class='tabelBlock_main'>
                <h2 id="last_orders_title">Последние заказы</h2>
                <table id="ordersTable">
                <tr>
                    <td class="td_id">Номер заказа</td>
                    <td>Адрес доставки</td>
                    <td class="td_phone_order">Телефон адресата</td>
                    <td class="td_count_in_order">Количество товаров в заказе</td>
                    <td class="td_itogo_order" >Итого по заказу</td>
                    <td class="td_status_order">Статус заказа</td>
                    <td class="td_buttons_order" ></td>
                </tr>
                <?php foreach($orders as $order):?>
                <tr>
                <td class="td_id"><?= $order->id?></td>
                    <td><?= $order->delivery_addres?></td>
                    <td class="td_phone_order"><?= $order->addressee_phone?></td>
                    <td class="td_count_in_order"><?=$order->count + $order->countRic?></td>
                    <td class="td_itogo_order"><?=$order->sum?></td>
                    <td class="td_status_order">
                        <select name="statusOfOrder" class="orderStatusBar" id="statusOfOrder<?=$order->id?>" data-order-id="<?=$order->id?>">
                            <?php foreach($ordersStatuses as $status):?>
                            <option value="<?=$status->id?>" <?= $status->id == $order->status_of_order_id?"selected":""?> ><?=$status->status?></option>
                            <?php endforeach?>
                        </select>

                    </td>
                    <td class="td_buttons_order">
                        <button class="showOrderProducts" data-order-id="<?=$order->id?>">Порсмотреть товары в заказе</button>
                    </td>
                </tr>

                <?php endforeach?>
            </table>
            <a class="go_to_orders" href="/app/admin/adminOrders.php">Перейти к всем заказам →</a>
            </div>

            <div class="last_month_orders_block">
                <h2 class="last_month_orders_title">Количество заказов за последний месяц <?=$countOrdersByLastMounth->count?></h2>
                <div id="container1" ></div>
                <div>


                <div id="tt" data-tt='<?=$json?>'></div>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js" type="text/javascript" defer></script>
<script src="https://code.highcharts.com/highcharts.js" defer></script>
<script src="/assets/js/feach.js" defer></script>
<script src="/assets/js/admin/adminMain.js" defer></script>
</html>