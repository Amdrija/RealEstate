<?php
/**
 * @var $estate EstateForSearchResult
 */

use Amdrija\RealEstate\Application\RequestModels\Estate\EstateForSearchResult; ?>

<a href="/estates/edit/<?= $estate->id ?>" style="text-decoration: none" uk-toggle="target: #estate-card-<?= $estate->id?>; mode: hover; cls: uk-card-primary">
    <div>
        <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin" id="estate-card-<?= $estate->id?>" uk-grid>
            <div class="uk-card-media-left uk-cover-container">
                <div class="">
                    <img src="<?= $estate->image?>" alt="" style="object-fit: cover; width: 100%; height: 300px" >
                </div>
            </div>
            <div>
                <div class="uk-card-body">
                    <div class="uk-flex uk-flex-between uk-flex-top">
                        <p class="uk-card-title uk-margin-remove"><?= $estate->name?></p>
                        <span class="uk-label uk-text-large <?= $estate->averagePrice != 0 ? ($estate->isPriceLessThanAverage() ? "uk-label-success" : "uk-label-danger") : "uk-label"?>"><?= $estate->price?>€</span>
                    </div>
                    <div class="uk-text-bold"><?= $estate->surface?> m<sup>2</sup> | <?= $estate->numberOfRooms?> room<?= $estate->numberOfRooms > 1 ? "s": ""?></div>
                    <p class="uk-text-meta"><?= $estate->cityName?> | <?= $estate->municipalityName ?> | <?= $estate->microLocationName?></p>
                    <p><?= substr($estate->description, 0, 100) . "..."?></p>
                </div>
            </div>
        </div>
    </div>
</a>