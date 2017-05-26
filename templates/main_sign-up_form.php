<?php
$categories = $data[0];
$form_errors = $data[1];
$form_olddata = $data[2];
?>
<main>
  <?php if (!empty($form_errors['mysql'])) echo '<p>'.$form_errors['mysql'].'</p>'; ?>
  <nav class="nav">
    <ul class="nav__list container">
      <?php foreach ($categories as $category) { ?>
        <li class="nav__item">
          <a href="/catalog.php?category=<?=$category[0]; ?>"><?=$category[1]; ?></a>
        </li>
      <?php } ?>
    </ul>
  </nav>
  <form class="form container<?php if (!empty($form_errors)) echo ' form--invalid'; ?>" action="sign-up.php" method="post" enctype="multipart/form-data">
    <h2>Регистрация нового аккаунта</h2>
    <div class="form__item<?php if (!empty($form_errors['email'])) echo ' form__item--invalid'; ?>">
      <label for="email">E-mail*</label>
      <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?php if (!empty($form_olddata['email'])) echo $form_olddata['email']; ?>" required>
      <span class="form__error"><?php if (!empty($form_errors['email'])) echo $form_errors['email']; ?></span>
    </div>
    <div class="form__item<?php if (!empty($form_errors['password'])) echo ' form__item--invalid'; ?>">
      <label for="password">Пароль*</label>
      <input id="password" type="text" name="password" placeholder="Введите пароль" value="<?php if (!empty($form_olddata['password'])) echo $form_olddata['password']; ?>" required>
      <span class="form__error"><?php if (!empty($form_errors['password'])) echo $form_errors['password']; ?></span>
    </div>
    <div class="form__item<?php if (!empty($form_errors['name'])) echo ' form__item--invalid'; ?>">
      <label for="name">Имя*</label>
      <input id="name" type="text" name="name" placeholder="Введите имя" value="<?php if (!empty($form_olddata['name'])) echo $form_olddata['name']; ?>" required>
      <span class="form__error"><?php if (!empty($form_errors['name'])) echo $form_errors['name']; ?></span>
    </div>
    <div class="form__item<?php if (!empty($form_errors['message'])) echo ' form__item--invalid'; ?>">
      <label for="message">Контактные данные*</label>
      <textarea id="message" name="message" placeholder="Напишите как с вами связаться" required><?php if (!empty($form_olddata['message'])) echo $form_olddata['message']; ?></textarea>
      <span class="form__error"><?php if (!empty($form_errors['message'])) echo $form_errors['message']; ?></span>
    </div>
    <div class="form__item form__item--file form__item--last<?php if (!empty($form_errors['file'])) echo ' form__item--invalid'; ?>">
      <label>Изображение</label>
      <div class="preview">
        <button class="preview__remove" type="button">x</button>
        <div class="preview__img">
          <img src="../img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
        </div>
      </div>
      <div class="form__input-file">
        <input class="visually-hidden" type="file" name="avatar" id="photo2" value="">
        <label for="photo2">
          <span>+ Добавить</span>
        </label>
      </div>
      <span class="form__error"><?php if (!empty($form_errors['file'])) echo $form_errors['file']; ?></span>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button" name="form-sent" value="1">Зарегистрироваться</button>
    <a class="text-link" href="login.php">Уже есть аккаунт</a>
  </form>
</main>