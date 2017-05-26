<?php
$categories = $data[0];
$bets = $data[1];
$userdata = $data[2];
$item_data = $data[3];
$cost = $data[4];
$id = $data[5]; 
?>
<main>
    <nav class="nav">
        <ul class="nav__list container">
        <?php foreach ($categories as $category) { ?>
            <li class="nav__item">
                <a href="/catalog.php?category=<?=$category[0]; ?>"><?=$category[1]; ?></a>
            </li>
        <?php } ?>
        </ul>
    </nav>
    <section class="lot-item container">
        <h2><?=protect_code($item_data[0]); ?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="<?=protect_code($item_data[2]); ?>" width="730" height="548" alt="<?=protect_code($item_data[0]); ?>">
                </div>
                <p class="lot-item__category">Категория: <span><?=protect_code($item_data[3]); ?></span></p>
                <p class="lot-item__description"><?=protect_code($item_data[1]); ?></p>
            </div>
            <div class="lot-item__right">
                <?php if (!empty($userdata) && (time()<convert_time_unix($item_data[7]))) { ?>
                <div class="lot-item__state">
                    <div class="lot-item__timer timer">
                        10:54:12
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?=$cost[0]; ?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span><?=$cost[1]; ?> р</span>
                        </div>
                    </div>
                    <?php if($userdata['auth_user_id']!==protect_code($item_data[5])) { ?>
                    <form class="lot-item__form" action="lot.php?id=<?=$id; ?>" method="post">
                        <p class="lot-item__form-item">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="number" name="cost" placeholder="<?=$cost[1]; ?>" required>
                        </p>
                        <button type="submit" class="button" name="form-sent" value="1">Сделать ставку</button>
                    </form>
                    <?php } else { ?>
                        <p>Это ваше объявление. Сделать ставку нельзя.</p>
                    <?php } ?>
                </div>
                <?php } ?>
                <div class="history">
                    <h3>История ставок (<span><?=count($bets); ?></span>)</h3>
                    <?php foreach ($bets as $bet) { ?>
                    <table class="history__list">
                        <tr class="history__item">
                            <td class="history__name"><?=protect_code($bet[0]); ?></td>
                            <td class="history__price"><?=protect_code($bet[1]); ?> р</td>
                            <td class="history__time"><?=convert_time($bet[2]); ?></td>
                        </tr>                      
                    <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>