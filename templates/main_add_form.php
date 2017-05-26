<?php
$categories = $data[0];
$form_errors = $data[1];
$form_olddata = $data[2];
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
  <form class="form form--add-lot container<?php if (!empty($form_errors)) echo ' form--invalid'; ?>" action="add.php" method="post" enctype="multipart/form-data">
    <h2>Добавление лота</h2>
    <div class="form__container-two">
      <div class="form__item<?php if (!empty($form_errors['lot-name'])) echo ' form__item--invalid'; ?>">
        <label for="lot-name">Наименование</label>
        <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?php if (!empty($form_olddata['lot-name'])) echo $form_olddata['lot-name']; ?>" required>
        <span class="form__error"><?php if (!empty($form_errors['lot-name'])) echo $form_errors['lot-name']; ?></span>
      </div>
      <div class="form__item<?php if (!empty($form_errors['category'])) echo ' form__item--invalid'; ?>">
        <label for="category">Категория</label>
        <select id="category" name="category">
          <option value="">Выберите категорию</option>
        <?php foreach ($categories as $category) { ?>
          <option value="<?=$category[0]; ?>"<?php if (!empty($form_errors) && $category[0]==$form_olddata['category']) echo ' selected'; ?>><?=$category[1]; ?></option>  
        <?php } ?>
        </select>
        <span class="form__error"><?php if (!empty($form_errors['category'])) echo $form_errors['category']; ?></span>
      </div>
    </div>
    <div class="form__item form__item--wide<?php if (!empty($form_errors['message'])) echo ' form__item--invalid'; ?>">
      <label for="message">Описание</label>
      <textarea id="message" name="message" placeholder="Напишите описание лота" required><?php if (!empty($form_olddata['message'])) echo $form_olddata['message']; ?></textarea>
      <span class="form__error"><?php if (!empty($form_errors['message'])) echo $form_errors['message']; ?></span>
    </div>
    <div class="form__item form__item--file<?php if (!empty($form_errors['file'])) echo ' form__item--invalid'; ?><?php if (!empty($form_olddata['file'])) echo ' form__item--uploaded'; ?>">
      <label>Изображение</label>
      <div class="preview">
        <button class="preview__remove" type="button">x</button>
        <div class="preview__img">
          <img src="../<?php if (!empty($form_olddata['file'])) echo $form_olddata['file']; ?>" width="113" height="113" alt="Изображение лота">
        </div>
      </div>
      <div class="form__input-file">
        <input class="visually-hidden" type="file" name="photo" id="photo2" value="<?php if (!empty($form_olddata['file'])) echo $form_olddata['file']; ?>">
        <label for="photo2">
          <span>+ Добавить</span>
        </label>
      </div>
      <span class="form__error"><?php if (!empty($form_errors['file'])) echo $form_errors['file']; ?></span>
    </div>
    <div class="form__container-three">
      <div class="form__item form__item--small<?php if (!empty($form_errors['lot-rate'])) echo ' form__item--invalid'; ?>">
        <label for="lot-rate">Начальная цена</label>
        <input id="lot-rate" type="number" name="lot-rate" placeholder="0" value="<?php if (!empty($form_olddata['lot-rate'])) echo $form_olddata['lot-rate']; ?>" required>
        <span class="form__error"><?php if (!empty($form_errors['lot-rate'])) echo $form_errors['lot-rate']; ?></span>
      </div>
      <div class="form__item form__item--small<?php if (!empty($form_errors['lot-step'])) echo ' form__item--invalid'; ?>">
        <label for="lot-step">Шаг ставки</label>
        <input id="lot-step" type="number" name="lot-step" placeholder="0" value="<?php if (!empty($form_olddata['lot-step'])) echo $form_olddata['lot-step']; ?>" required>
        <span class="form__error"><?php if (!empty($form_errors['lot-step'])) echo $form_errors['lot-step']; ?></span>
      </div>
      <div class="form__item<?php if (!empty($form_errors['lot-date'])) echo ' form__item--invalid'; ?>">
        <label for="lot-date">Дата завершения</label>
        <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="20.05.2017" value="<?php if (!empty($form_olddata['lot-date'])) echo $form_olddata['lot-date']; ?>" required>
        <span class="form__error"><?php if (!empty($form_errors['lot-date'])) echo $form_errors['lot-date']; ?></span>
      </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button" name="form-sent" value="1">Добавить лот</button>
  </form>
</main>