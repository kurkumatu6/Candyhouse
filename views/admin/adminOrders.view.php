<?php
        
require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/adminHeader.php";?>
    <main id="adminMain_main">
    <h1 class="title">Список заказов</h1>
        <div class="tabelBlock">
        <div class="orderControls">
                <div class="order_select_block">
                <label for="selectStatus" class="white">Категория</label>
                <select name="selectStatus" id="selectStatus">
                    <option value="all">Все</option>
                    <?php foreach($ordersStatuses as $status):?>
                    <option value="<?=$status->id?>" ><?=$status->status?></option>
                    <?php endforeach?>
                </select>
                </div>

                <button id="sort" class="sort order_price_sort_button">Итого по заказу</button>
                <!-- <div>
                 <input type="text" id="serchName">
                <button class="serchConfirm">Поиск</button> 
                </div> -->
                
            </div>
            <table id="ordersTable">
                <tr>
                    <td class="td_id">Номер заказа</td>
                    <td >Адрес доставки</td>
                    <td class="td_phone_order">Телефон адресата</td>
                    <td class="td_count_in_order">Количество товаров в заказе</td>
                    <td class="td_itogo_order">Итого по заказу</td>
                    <td class="td_status_order">Статус заказа</td>
                    <td class="td_buttons_order"></td>
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
                            <option class="optionsStatus<?= $order->id?>" value="<?=$status->id?>" <?= $status->id == $order->status_of_order_id?"selected":""?> ><?=$status->status?></option>
                            <?php endforeach?>
                        </select>

                    </td>
                    <td class="td_buttons_order">
                        <button class="showOrderProducts" data-order-id="<?=$order->id?>">Порсмотреть товары в заказе</button>
                    </td>
                </tr>

                <?php endforeach?>
            </table>
            <!-- <button id="addProduct" class="addProduct">Добавть продукт</button>
            <button id="delMassProduct" class="delMassProduct">Удалить помеченные</button> -->
            <!-- <p><?//$_SESSION["error"]["prodAdd"]??""?></p> -->
        </div>
    </main>
</body>
<script src="/assets/js/feach.js"></script>
<script src="/assets/js/admin/adminOrders.js"></script>
</html>
<!-- <button class="delProduct" data-product-id="<?//$product->id?>">Удалить</button>
                        <button class="changeProduct" data-product-id="<?//$product->id?>">Изменить</button>
                        <input type="checkbox" name="" id="" class="delChecks"   data-product-id="<?//$product->id?>"> -->