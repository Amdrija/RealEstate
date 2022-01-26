<?php
/**
 * @var $estate EstateSingle
 * @var $perks array
  * */

use Amdrija\RealEstate\Application\RequestModels\Estate\EstateSingle; ?>

<div class="uk-margin-large-top">
<h1><?= $estate->name?>
    <div class="uk-label uk-text-large"><?= $estate->price?>€</div></h1>
    <div class="uk-child-width-1-2@m" uk-grid>
        <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slideshow="animation: pull; autoplay: true">
            <ul class="uk-slideshow-items">
                <?php foreach ($estate->images as $image):?>
                <li>
                    <img src="<?= $image?>" alt="" uk-cover>
                </li>
                <?php endforeach; ?>
            </ul>
            <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
            <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>
        </div>
        <div>
            <p class="uk-text-bold">Type: <?= $estate->type?>  |  Surface: <?= $estate->surface?> m<sup>2</sup>  |  Rooms: <?= $estate->numberOfRooms?></p>
            <hr>
            <div class="uk-child-width-1-2" uk-grid>
                <p>Advertiser: <?= $estate->advertiser->firstName . " " . $estate->advertiser->lastName?></p>
                <p>Floor: <?= $estate->floor?></p>
                <p>Contact: <?= $estate->advertiser->telephone?></p>
                <p>Total floors: <?= $estate->totalFloors?></p>
                <p>Condition: <?= $estate->condition?></p>
                <p>ConstructionDate: <?= $estate->constructionDate->format("M Y")?></p>
                <p>Heating: <?= $estate->heating?></p>
            </div>
        </div>
        <hr>
        <hr>
        <div class="">
            <h2 class="uk-text-lead">Perks</h2>
            <fieldset class="uk-fieldset uk-padding-small uk-padding-remove-horizontal uk-margin-bottom uk-grid-small uk-text-left uk-child-width-1-3" uk-grid>
                <input class="uk-checkbox uk-hidden" type="checkbox" name="perks[]" checked value="">
                <?php /* @var $perk Perk */?>
                <?php foreach ($perks as $perk): ?>
                    <label class=""><input class="uk-checkbox" type="checkbox" <?= in_array($perk->id, $estate->perks) ? "checked" : ""?>> <?= $perk->name?></label>
                <?php endforeach; ?>
            </fieldset>
        </div>
        <div class="">
            <h2 class="uk-text-lead">Description</h2>
            <p><?= $estate->description?></p>
        </div>
    </div>
</div>
