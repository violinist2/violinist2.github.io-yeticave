<?php
$categories = $data[0];
$open_items = $data[1];
?>
<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
        <?php foreach ($categories as $category) { ?>
            <li class="promo__item promo__item--<?=$category[2]; ?>">
                <a class="promo__link" href="/catalog.php?category=<?=$category[0]; ?>"><?=$category[1]; ?></a>
            </li>
        <?php } ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
            <select class="lots__select">
            <option>Все категории</option>
            <?php foreach ($categories as $category) { ?>
                <option><?=$category[1]; ?></option> 
            <?php } ?> 
            </select>
        </div>
        <ul class="lots__list">
        <?php foreach ($open_items as $item) { ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="../<?=$item[3]; ?>" width="350" height="260" alt="<?=$item[1]; ?>">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?=$item[4]; ?></span>
                    <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$item[0]; ?>"><?=$item[1]; ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?=$item[2]; ?><b class="rub">р</b></span>
                        </div>
                        <div class="lot__timer timer">
                            16:54:12
                        </div>
                    </div>
                </div>
            </li>
        <?php } ?>     
        </ul>      
    </section>
</main>