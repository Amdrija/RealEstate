<?php
/* @var $cities array
 * @var $agencies array
 * @var $user User
 */
?>
<div class="uk-margin-auto login-modal uk-margin-top">
    <h1 class="uk-text-center">Add User</h1>
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
            <label class="" for="username-input">Username</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <span class="uk-form-icon" uk-icon="icon: user"></span>
                <input class="uk-input uk-width-1-1" type="text" placeholder="Username" name="userName" id="username-input" required>
            </div>
            <label class="" for="password-input">Password</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <span class="uk-form-icon uk-form-icon" uk-icon="icon: lock"></span>
                <input class="uk-input uk-width-1-1" type="password" placeholder="Password" id="password-input" name="password" required>
            </div>

            <label class="" for="confirm-password-input">Confirm password</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <span class="uk-form-icon uk-form-icon" uk-icon="icon: lock"></span>
                <input class="uk-input uk-width-1-1" type="password" placeholder="Password" id="confirm-password-input" name="confirmedPassword" required>
            </div>

            <label class="" for="firstname-input">First name</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <input class="uk-input uk-width-1-1" type="text" placeholder="First name" id="firstname-input" name="firstName" required>
            </div>
            <label class="" for="lastname-input">Last name</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <input class="uk-input uk-width-1-1" type="text" placeholder="Last name" id="lastname-input" name="lastName" required>
            </div>
            <label class="" for="city-input">City</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <select class="uk-select" required name="cityId" id="city-input">
                    <option value="">Choose city...</option>
                    <?php /* @var $city City */?>
                    <?php foreach ($cities as $city): ?>
                        <option value="<?= $city->id ?>"><?= $city->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <label class="" for="birthdate-input">Birth date</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <span class="uk-form-icon uk-form-icon" uk-icon="icon: calendar"></span>
                <input class="uk-input uk-width-1-1" type="date" id="birthdate-input" name="birthDate" required>
            </div>
            <label class="" for="phonenumber-input">Phone number</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <span class="uk-form-icon uk-form-icon" uk-icon="icon: phone"></span>
                <input class="uk-input uk-width-1-1" type="tel" placeholder="+381 69 555 333" name="telephone" required>
            </div>
            <label class="" for="email-input">E-mail</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <span class="uk-form-icon uk-form-icon" uk-icon="icon: mail"></span>
                <input class="uk-input uk-width-1-1" type="email" placeholder="me@example.com" name="email" id="email-input" required>
            </div>


            <label class="" for="agency-input">Agency</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <select class="uk-select" name="agencyId" id="agency-input">
                    <option value="">Choose agency...</option>
                    <?php /* @var $agency Agency */?>
                    <?php foreach ($agencies as $agency): ?>
                        <option value="<?= $agency->id ?>"><?= $agency->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <label class="" for="licencenumber-input">Licence number</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <span class="uk-form-icon" uk-icon="icon: user"></span>
                <input class="uk-input uk-width-1-1" type="text" placeholder="555333" name="licenceNumber">
            </div>

            <div class="uk-margin-bottom uk-grid-small uk-child-width-auto uk-grid">
                <label><input class="uk-checkbox" type="checkbox" name="verified" checked> Verified</label>
            </div>


            <div class="uk-margin-bottom uk-grid-small uk-child-width-auto uk-grid">
                <label><input class="uk-checkbox" type="checkbox" name="isAdministrator"> Administrator</label>
            </div>
            <div class="uk-flex uk-flex-right uk-margin-large-top">
                <input type="submit" class="uk-button uk-button-primary" value="Create">
            </div>
        </form>
    </div>
</div>