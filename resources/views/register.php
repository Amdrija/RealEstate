<?php
/* @var $cities array*/
/* @var $agencies array*/
?>
<div class="uk-margin-auto login-modal uk-margin-top">
    <h1 class="uk-text-center">Register</h1>
    <?php use Amdrija\RealEstate\Application\Models\Agency;
    use Amdrija\RealEstate\Application\Models\City;

    if (!empty($error)): ?>
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
                <input class="uk-input uk-width-1-1" type="password" placeholder="Password" id="password-input" name="password" required>
            </div>

            <label class="" for="confirm-password-input">Confirm password</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <span class="uk-form-icon uk-form-icon" uk-icon="icon: lock"></span>
                <input class="uk-input uk-width-1-1" type="password" placeholder="Password" id="confirm-password-input" name="confirmedPassword" required>
            </div>

            <label class="" for="firstname-input">First name</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <input class="uk-input uk-width-1-1" type="text" placeholder="First name" id="firstname-input" name="firstname" required>
            </div>
            <label class="" for="lastname-input">Last name</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <input class="uk-input uk-width-1-1" type="text" placeholder="Last name" id="lastname-input" name="lastname" required>
            </div>
            <label class="" for="city-input">City</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <select class="uk-select" required name="cityId" id="city-input">
                    <option value="">Choose city...</option>
                    <?php foreach ($cities as $city) {
                        /* @var $city City*/
                        echo "<option value=\"{$city->id}\">{$city->name}</option>";
                    }?>
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
                <input class="uk-input uk-width-1-1" type="tel" placeholder="+381 69 555 333" name="phoneNumber" required>
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
                    <?php foreach ($agencies as $agency) {
                        /* @var $agency Agency*/
                        echo "<option value=\"{$agency->id}\">{$agency->name}</option>";
                    }?>
                </select>
            </div>
            <label class="" for="licencenumber-input">Licence number</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <span class="uk-form-icon" uk-icon="icon: user"></span>
                <input class="uk-input uk-width-1-1" type="text" placeholder="555333" name="licenceNumber" required>
            </div>

            <input type="submit" class="uk-button uk-button-primary uk-margin-top" value="Registruj se">
        </form>
    </div>
</div>