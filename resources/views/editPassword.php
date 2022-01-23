<?php
/* @var $cities array
 * @var $agencies array
 * @var $user User
 */
?>
<div class="uk-margin-auto login-modal uk-margin-top">
    <h1 class="uk-text-center">Edit Profile</h1>
    <?php use Amdrija\RealEstate\Application\Models\Agency;
    use Amdrija\RealEstate\Application\Models\City;
    use Amdrija\RealEstate\Application\Models\User;

    if (!empty($error)): ?>
        <div uk-alert class="uk-alert-danger">
            <a class="uk-alert-close" uk-close></a>
            <p id="error"><?= $error ?></p>
        </div>
    <?php endif; ?>
    <div class="center-content uk-margin-large-bottom">
        <form method="post">
            <label class="" for="old-password-input">Old password</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <span class="uk-form-icon uk-form-icon" uk-icon="icon: lock"></span>
                <input class="uk-input uk-width-1-1" type="password" placeholder="Old password" id="old-password-input" name="oldPassword" required>
            </div>

            <label class="" for="password-input">New password</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <span class="uk-form-icon uk-form-icon" uk-icon="icon: lock"></span>
                <input class="uk-input uk-width-1-1" type="password" placeholder="New password" id="password-input" name="newPassword" required>
            </div>

            <label class="" for="confirm-password-input">Confirm password</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <span class="uk-form-icon uk-form-icon" uk-icon="icon: lock"></span>
                <input class="uk-input uk-width-1-1" type="password" placeholder="Password" id="confirm-password-input" name="confirmedPassword" required>
            </div>
            <div class="uk-flex uk-flex-right uk-margin-large-top">
                <input type="submit" class="uk-button uk-button-primary" value="Save">
            </div>
        </form>
    </div>
</div>
