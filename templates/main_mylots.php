<?php
$mybets = $data[0];
$categories = $data[1];
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
  <section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
    <?php
      if (!empty($mybets)) { // если ставок нет, будет отображаться пустая страница
        foreach ($mybets as $bet_data) {
    ?>
      <tr class="rates__item">
        <td class="rates__info">
          <div class="rates__img">
            <img src="../<?=protect_code($bet_data[2]); ?>" width="54" height="40" alt="<?=protect_code($bet_data[1]); ?>">
          </div>
          <h3 class="rates__title"><a href="/lot.php?id=<?=protect_code($bet_data[0]); ?>"><?=protect_code($bet_data[1]); ?></a></h3>
        </td>
        <td class="rates__category">
          <?=protect_code($bet_data[5]); ?>
        </td>
        <td class="rates__timer">
          <div class="timer timer--finishing">07:13:34</div>
        </td>
        <td class="rates__price">
          <?=protect_code($bet_data[3]); ?> р
        </td>
        <td class="rates__time">
          <?=convert_time($bet_data[4]); ?>
        </td>
      </tr>
    <?php   }
    }
    ?>
    </table>
  </section>
</main>