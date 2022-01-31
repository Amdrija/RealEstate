<?php
/* @var $municipalities array
 */
?>
<div class="uk-margin-auto login-modal uk-margin-top">
    <h1 class="uk-text-center">Add Municipality</h1>
    <?php use Amdrija\RealEstate\Application\Models\Agency;
    use Amdrija\RealEstate\Application\Models\City;
    use Amdrija\RealEstate\Application\Models\Municipality;
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
                <input class="uk-input uk-width-1-1" type="text" placeholder="Micro location name" name="name" id="name-input" required>
            </div>

            <label class="" for="municipality-input">Municipality</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <select class="uk-select" required name="municipalityId" id="municipality-input">
                    <option value="">Choose municipality...</option>
                    <?php /* @var $municipality Municipality */?>
                    <?php foreach ($municipalities as $municipality): ?>
                        <option value="<?= $municipality->id ?>"><?= $municipality->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="uk-flex uk-flex-right uk-margin-large-top">
                <input type="submit" class="uk-button uk-button-primary" value="Create">
            </div>
        </form>
    </div>
</div>