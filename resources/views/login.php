<div class="uk-margin-auto login-modal uk-margin-xlarge-top">
    <h1 class="uk-text-center">Welcome</h1>
    <?php if (!empty($error)): ?>
        <div class="alert-container">
            <div class="alert-message"><?= $error ?></div>
            <div class="alert-button">×</div>
        </div>
    <?php endif; ?>
    <div class="center-content">
        <form method="post">
            <label class="" for="username-input">Username</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <span class="uk-form-icon" uk-icon="icon: user"></span>
                <input class="uk-input uk-width-1-1" type="text" placeholder="Username" name="username" id="username-input" required>
            </div>
            <label class="" for="password-input">Password</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <span class="uk-form-icon uk-form-icon" uk-icon="icon: lock"></span>
                <input class="uk-input uk-width-1-1" type="password" placeholder="Password" name="password" id="password-input" required>
            </div>

            <div class="uk-margin-bottom uk-grid-small uk-child-width-auto uk-grid">
                <label><input class="uk-checkbox" type="checkbox" name="keepMeLoggedIn" id="keep-me-logged-in"> Remember me</label>
            </div>

            <input type="submit" class="uk-button uk-button-primary" value="Login">
        </form>
    </div>
</div>