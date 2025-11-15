<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>

<main>
    <div class="language-switcher-login">
        <select id="languageSelector">
            <option value="es">🇪🇸 ES</option>
            <option value="en">🇺🇸 EN</option>
            <option value="pt">🇧🇷 PT</option>
        </select>
    </div>
    <section class="login-body">
        <div class="wrapper-login">
            <form action="index.php?route=Auth/Login" method="post">
                <?= Csrf::input(); ?>
                <h1><?= I18n::t('auth.welcome'); ?></h1>

                <div class="input-box">
                    <input type="email" name="email" id="email" placeholder="<?= I18n::t('auth.login.email'); ?>" required>
                    <i class='bx bx-user'></i> 
                </div>

                <div class="input-box">
                    <input type="password" name="password" id="password" placeholder="<?= I18n::t('auth.login.password'); ?>" autocomplete="off" required>
                    <i class='bx bx-lock'></i> 
                </div>

                <div class="remember-forgot">
                    <label><input type="checkbox" name="remember" value="1"> <?= I18n::t('auth.login.remember'); ?></label>
                    <a href="index.php?route=Auth/Forgot"><?= I18n::t('auth.login.forgot'); ?></a>
                </div>

                <button type="submit" class="btn-login"><?= I18n::t('auth.login.submit'); ?></button>

                <div class="register-link">
                    <p><?= I18n::t('auth.login.no.account'); ?> <a href="index.php?route=Register/Register"><?= I18n::t('auth.login.register.link'); ?></a></p>
                </div>
            </form>
        </div>
    </section>
</main>
<script>
document.getElementById("languageSelector").addEventListener("change", function () {
    // Este evento solo cambia el idioma en el front-end por ahora
    console.log("Idioma seleccionado:", this.value);
});
</script>
