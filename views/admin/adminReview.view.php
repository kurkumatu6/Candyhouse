<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/adminHeader.php"; ?>
<main id="adminMain_main">
    <h1 class="title">Отзывы</h1>
    <div class="tabelBlock">
        <div class="productControls review_control">
            <form action="" id="reviewsSelectorsForm">
                <div>
                    <label for="reviewsProduct" class="white">Категория</label>
                    <select name="reviewsProduct" id="reviewsProduct">
                        <option value="all">Все</option>
                        <?php foreach ($products as $product): ?>
                            <option value="<?= $product->id ?>"><?= $product->name ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div>
                    <label for="">Дата начала</label>
                    <input type="date" name="startDate" id="">
                </div>
                <div>
                    <label for="">Дата конца</label>
                    <input type="date" name="endDate" id="">
                </div>
            </form>

        </div>
        <table id="reviewTable">
            <tr>
                <td class="td_review_id">id</td>
                <td>Продукт</td>
                <td>Клиент(email)</td>
                <td>Дата</td>
                <td class="td_review_buttons"></td>
            </tr>
            <?php foreach ($reviews as $review): ?>
                <tr>
                    <td class="td_review_id">
                        <?= $review->id ?>
                    </td>
                    <td>
                        <?= $review->product ?>
                    </td>
                    <td>
                        <?= $review->email ?>
                    </td>
                    <td><?= $review->date_reviews ?></td>
                    <td class="td_review_buttons">
                        <button class="delReview" data-review-id="<?= $review->id ?>">Удалить</button>
                        <button class="showReview" data-review-id="<?= $review->id ?>">Просмотреть</button>

                    </td>
                </tr>

            <?php endforeach ?>
        </table>
    </div>
</main>
</body>
<script src="/assets/js/feach.js"></script>
<script src="/assets/js/admin/adminReviews.js"></script>

</html>