<?php
        
require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/adminHeader.php";?>
    <main id="adminMain_main">
        <h1 class="title">Клиенты</h1>
        <div class="tabelBlock">
            <table id="clientsTable">
                <tr>
                    <td class="people_email_td">Email</td>
                    <td class="people_status_td">Статус</td>
                    <td class="people_phone_td">Телефон</td>
                    <td class="people_warning_td">Предупреждение</td>
                    <td >Кол-во заказов</td>
                    <td class="people_buttons_td"></td>
                </tr>
                <?php foreach($clients as $client):?>
                <tr>
                <td class="people_email_td"><?= $client->email?></td>
                    <td class="people_status_td">
                        <select name="" class="client_status_change" id="" data-client-id="<?=$client->id?>" data-client-name="<?= $client->email?>" >
                            <?php foreach($statusesOfClients as $status):?>
                                <option class="optionBy<?=$client->id?>" value="<?= $status->id?>" <?= $client->status_of_client_id == $status->id?"selected":""?>><?= $status->status?></option>
                            <?php endforeach?>
                        </select>
                        
                    </td>
                    <td><?= $client->phone?></td>
                    <td><?=$client->warning?"да":"нет"?></td>
                    <td><?= $client->orderCount?></td>
                    <td class="people_buttons_td"><button class="showClientOrders" data-client-id="<?=$client->id?>">Просмотр заказов клиента</button></td>
                </tr>

                <?php endforeach?>
            </table>
        </div>
    </main>
</body>
<script src="/assets/js/feach.js"></script>
<script src="/assets/js/admin/adminClients.js"></script>
</html>