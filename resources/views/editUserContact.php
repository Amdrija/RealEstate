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
            <label class="" for="city-input">City</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <select class="uk-select" required name="cityId" id="city-input">
                    <?php /* @var $city City */?>
                    <?php foreach ($cities as $city): ?>
                        <option value="<?= $city->id ?>" <?= $city->id == $user->cityId ? "selected" : ""?>><?= $city->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <label class="" for="phonenumber-input">Phone number</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <span class="uk-form-icon uk-form-icon" uk-icon="icon: phone"></span>
                <input class="uk-input uk-width-1-1" value="<?= $user->telephone?>" type="tel" placeholder="+381 69 555 333" name="telephone" required>
            </div>
            <label class="" for="email-input">E-mail</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <span class="uk-form-icon uk-form-icon" uk-icon="icon: mail"></span>
                <input class="uk-input uk-width-1-1" value="<?= $user->email ?>" type="email" placeholder="me@example.com" name="email" id="email-input" required>
            </div>


            <label class="" for="agency-input">Agency</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <select class="uk-select" name="agencyId" id="agency-input">
                    <option value=""  <?= is_null($user->agencyId) ? "selected" : ""?>>No agency</option>
                    <?php /* @var $agency Agency */?>
                    <?php foreach ($agencies as $agency): ?>
                        <option value="<?= $agency->id ?>" <?= $agency->id == $user->agencyId ? "selected" : ""?>><?= $agency->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="uk-flex uk-flex-between uk-margin-large-top">
                <a class="uk-button uk-button-default" href="/user/edit/password">Change password</a>
                <input type="submit" class="uk-button uk-button-primary" value="Edit">
            </div>
        </form>
    </div>
</div>
