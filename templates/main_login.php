<?php
$categories = $data[0];
$data = $data[1];
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
  <form class="form container<?php if ($data['form-sent']==true) echo ' form--invalid'; ?>" action="login.php" method="post">
    <h2>Вход</h2>
    <?php if (protect_code($_SESSION['user']['new'])==TRUE) echo '<p>Теперь вы можете войти, используя свой email и пароль.</p>'; ?>
    <div class="form__item<?php if ($data['form-sent']==true and $data['email']=="") echo ' form__item--invalid'; ?>">
      <label for="email">E-mail*</label>
      <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=$data['email']; ?>" required>
      <span class="form__error">Введите e-mail</span>
    </div>
    <div class="form__item form__item--last<?php if ($data['form-sent']==true and ($data['password']=="" || $data['password_incorrect']==true)) echo ' form__item--invalid'; ?>">
      <label for="password">Пароль*</label>
      <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?=$data['password']; ?>" required>
      <span class="form__error"><?php if ($data['form-sent']==true and $data['password']=="") {
          echo 'Введите пароль';
        } elseif ($data['form-sent']==true and $data['password_incorrect']==true)  {
          echo 'Вы ввели неверный пароль';  
        } ; ?></span>
    </div>
    <button type="submit" class="button" name="form-sent" value="1">Войти</button>
  </form>
</main>