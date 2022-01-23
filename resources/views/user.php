<?php
/* @var $cities array
 * @var $agencies array
 * @var $user User
*/
?>
<div class="uk-margin-auto login-modal uk-margin-top">
    <h1 class="uk-text-center">Edit User</h1>
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
                <input class="uk-input uk-width-1-1" value="<?= $user->userName ?>" type="text" placeholder="Username" name="userName" id="username-input" required>
            </div>

            <label class="" for="firstname-input">First name</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <input class="uk-input uk-width-1-1" value="<?= $user->firstName?>" type="text" placeholder="First name" id="firstname-input" name="firstName" required>
            </div>
            <label class="" for="lastname-input">Last name</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <input class="uk-input uk-width-1-1" value="<?= $user->lastName ?>" type="text" placeholder="Last name" id="lastname-input" name="lastName" required>
            </div>
            <label class="" for="city-input">City</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <select class="uk-select" required name="cityId" id="city-input">
                    <?php /* @var $city City */?>
                    <?php foreach ($cities as $city): ?>
                        <option value="<?= $city->id ?>" <?= $city->id == $user->cityId ? "selected" : ""?>><?= $city->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <label class="" for="birthdate-input">Birth date</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <span class="uk-form-icon uk-form-icon" uk-icon="icon: calendar"></span>
                <input class="uk-input uk-width-1-1" value="<?= $user->birthDate->format("Y-m-d") ?>" type="date" id="birthdate-input" name="birthDate" required>
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
            <label class="" for="licencenumber-input">Licence number</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <span class="uk-form-icon" uk-icon="icon: user"></span>
                <input class="uk-input uk-width-1-1" value="<?= $user->licenceNumber ?? "" ?>" type="text" placeholder="555333" name="licenceNumber">
            </div>

            <div class="uk-margin-bottom uk-grid-small uk-child-width-auto uk-grid">
                <label><input class="uk-checkbox" type="checkbox" name="verified"  <?= $user->verified ? "checked" : ""?>> Verified</label>
            </div>


            <div class="uk-margin-bottom uk-grid-small uk-child-width-auto uk-grid">
                <label><input class="uk-checkbox" type="checkbox" name="isAdministrator" <?= $user->isAdministrator ? "checked" : ""?>> Administrator</label>
            </div>
            <div class="uk-flex uk-flex-between uk-margin-large-top">
                <button class="uk-button uk-button-danger" id="delete-button">Delete</button>
                <input type="submit" class="uk-button uk-button-primary" value="Edit">
            </div>
        </form>
    </div>
</div>
<script>
    window.addEventListener('DOMContentLoaded', function (){
        document.getElementById('delete-button').addEventListener('click', DeleteUser);
    });

    function DeleteUser(event) {
        event.preventDefault();
        let splittedUri = window.location.href.split("/");
        let userId = splittedUri[splittedUri.length - 1];

        try {
            fetch(window.location.href + '/delete', {
                method: 'POST',
                mode: 'no-cors',
                credentials: 'same-origin',
                body: new FormData(),
                redirect: "follow"
            }).then(response => {
                if (!response.ok) {
                    let errorDiv = document.getElementById("error");
                    errorDiv.innerText = "Error occured.";
                }
                let splittedUrl = window.location.href.split("/");
                window.location.href = splittedUrl.slice(0, splittedUrl.length - 1).join("/");
            });
        } catch (e) {
            console.log(e);
        }
    }
</script>