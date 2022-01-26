<?php /**
 * @var $estates array
 * @var $estateTypes array
 * @var $cities array
 */

use Amdrija\RealEstate\Application\Models\City;
use Amdrija\RealEstate\Application\Models\EstateType;

?>
<section class="uk-child-width-1-2@m uk-margin-top uk-margin-bottom uk-grid-match" uk-grid>
    <div class="uk-flex uk-flex-middle">
        <div class="">
            <h1 class="uk-heading-medium">Find your perfect home.</h1>
            <h2 class="uk-text-lead uk-text-muted uk-text-light">Search and buy homes that are perfect for you.</h2>
            <button class="uk-button uk-button-primary">Register</button>
        </div>
    </div>
    <div>
        <div class="uk-card uk-card-default uk-card-body">
            <h2 class="uk-card-title">Search homes</h2>
            <form action="/search" method="GET" uk-grid class="uk-child-width-1-2">
                <div>
                    <label class="" for="type-input">Type</label>
                    <div class="uk-inline uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                        <select class="uk-select" required name="typeId" id="type-input">
                            <option value="">Choose type...</option>
                            <?php /*  @var $estateType EstateType */?>
                            <?php foreach ($estateTypes as $estateType): ?>
                                <option value="<?= $estateType->id ?>"><?= $estateType->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="" for="location-input">Location</label>
                    <div class="uk-inline uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                        <select class="uk-select" required name="streetId" id="location-input">
                            <option value="">Choose city...</option>
                            <?php /* @var $city City */?>
                            <?php foreach ($cities as $city): ?>
                                <option value="<?= $city->id ?>"><?= $city->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="" for="price-input">Price up to</label>
                    <div class="uk-inline uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                        <input class="uk-input uk-width-1-1" type="number" step="1" id="price-input" name="price" required>
                    </div>
                </div>
                <div>
                    <label class="" for="surface-input">Surface from</label>
                    <div class="uk-inline uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                        <input class="uk-input uk-width-1-1" type="number" id="surface-input" name="surface" required>
                    </div>
                </div>
                <div></div>
                <div class="uk-flex uk-flex-right uk-margin-large-top">
                    <input type="submit" class="uk-button uk-button-primary" value="Search">
                </div>
            </form>
        </div>
    </div>
</section>
<h2 class="uk-heading-small">Recently added homes</h2>
<section class="uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-medium uk-margin-large" uk-grid="masonry: true">
    <?php foreach($estates as $estate):?>
        <?php include __DIR__ . '/../templates/estateCard.php'?>
    <?php endforeach;?>
</section>
