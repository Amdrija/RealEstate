<?php
/* @var $streets $array
 */
?>
<div class="uk-margin-auto login-modal uk-margin-top">
    <h1 class="uk-text-center">Add Agency</h1>
    <?php use Amdrija\RealEstate\Application\Models\Agency;
    use Amdrija\RealEstate\Application\Models\City;
    use Amdrija\RealEstate\Application\Models\Street;
    use Amdrija\RealEstate\Application\Models\User;

    if (!empty($error)): ?>
        <div uk-alert class="uk-alert-danger">
            <a class="uk-alert-close" uk-close></a>
            <p id="error"><?= $error ?></p>
        </div>
    <?php endif; ?>
    <div class="center-content uk-margin-large-bottom">
        <form method="post">
            <label class="" for="name-input">Name</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <input class="uk-input uk-width-1-1" type="text" placeholder="Agency name" name="name" id="name-input" required>
            </div>

            <label class="" for="pib-input">Tax number</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <input class="uk-input uk-width-1-1" type="text" maxlengh="11" placeholder="Tax number" id="pib-input" name="pib" required>
            </div>
            <label class="" for="street-input">Street</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <select class="uk-select" required name="streetId" id="street-input">
                    <option value="">Choose street...</option>
                    <?php /* @var $street Street */?>
                    <?php foreach ($streets as $street): ?>
                        <option value="<?= $street->id ?>"><?= $street->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <label class="" for="street-input">Street number</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <input class="uk-input uk-width-1-1" type="number" step="1" min="1" id="street-input" name="streetNumber" required>
            </div>

            <div class="uk-flex uk-flex-right uk-margin-large-top">
                <input type="submit" class="uk-button uk-button-primary" value="Create">
            </div>
        </form>
    </div>
</div>