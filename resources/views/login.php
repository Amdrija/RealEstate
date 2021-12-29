<div class="uk-margin-auto login-modal uk-margin-xlarge-top">
    <h1 class="uk-text-center">Dobrodošli</h1>
    <?php if (!empty($error)): ?>
        <div class="alert-container">
            <div class="alert-message"><?= $error ?></div>
            <div class="alert-button">×</div>
        </div>
    <?php endif; ?>
    <div class="center-content">
        <form method="post">
            <div class="uk-inline uk-margin-top uk-width-1-1">
                <span class="uk-form-icon" uk-icon="icon: user"></span>
                <input class="uk-input uk-width-1-1" type="text" placeholder="Korisničko ime" name="username" required>
            </div>
            <div class="uk-inline uk-margin-top uk-width-1-1">
                <span class="uk-form-icon uk-form-icon" uk-icon="icon: lock"></span>
                <input class="uk-input uk-width-1-1" type="password" placeholder="Lozinka" name="password" required>
            </div>

            <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                <label><input class="uk-checkbox" type="checkbox" name="keepMeLoggedIn" id="keep-me-logged-in"> Zapamti me</label>
            </div>

            <input type="submit" class="uk-button uk-button-primary" value="Login">
        </form>
    </div>
</div>