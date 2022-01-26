<?php /* @var $estate EstateSummary*/

use Amdrija\RealEstate\Application\RequestModels\Estate\EstateSummary; ?>

<a href="/estates/search/<?= $estate->id?>" style="text-decoration: none" uk-toggle="target: #estate-card-<?= $estate->id?>; mode: hover; cls: uk-card-primary">
    <div>
        <div class="uk-card uk-card-default uk-padding-remove-horizontal" id="estate-card-<?= $estate->id?>">
            <div class="">
                <img src="<?= $estate->image?>" alt="" style="object-fit: cover; width: 100%; height: 300px" >
            </div>
            <div>
                <div class="uk-card-body">
                    <div class="uk-flex uk-flex-between">
                        <p class="uk-card-title uk-margin-remove"><?= $estate->name?></p>
                        <div class="uk-label uk-text-large"><?= $estate->price?>€</div>
                    </div>
                    <div class="uk-text-bold"><?= $estate->surface?> m<sup>2</sup></div>
                    <p class="uk-text-meta">Bus lines: <?= $estate->busLines?> | <?= $estate->numberOfRooms?> room<?= $estate->numberOfRooms > 1 ? "s": ""?></p>
                </div>
            </div>
        </div>
    </div>
</a>