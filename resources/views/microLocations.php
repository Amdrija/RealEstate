<?php
/* @var $microLocations array*/
/* @var $municipalities array */

use Amdrija\RealEstate\Application\Models\Agency;
use Amdrija\RealEstate\Application\Models\MicroLocation;
use Amdrija\RealEstate\Application\Models\User;
use Amdrija\RealEstate\Application\RequestModels\PaginatedResponse;

?>

<h2 class="uk-heading-small uk-margin-top">Micro locations</h2>
<table class="uk-table uk-table-hover uk-table-divider">
    <thead>
    <tr>
        <th></th>
        <th>Name</th>
        <th>Municipality</th>
    </tr>
    </thead>
    <tbody>
    <?php /* @var $microLocation MicroLocation */ ?>
    <?php foreach ($microLocations as $microLocation): ?>
        <tr class="">
            <td><a href="/admin/microLocations/delete/<?= $microLocation->id?>" uk-icon="icon: trash"></td>
            <td><?= $microLocation->name ?></td>
            <td><?= $municipalities[$microLocation->municipalityId]?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<a href="/admin/microLocations/add">
    <div class="uk-card uk-card-hover uk-text-center uk-padding-small uk-text-large">+</div>
</a>
