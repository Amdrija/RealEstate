<?php
/* @var $agencies array*/
/* @var $streets array */

use Amdrija\RealEstate\Application\Models\Agency;
use Amdrija\RealEstate\Application\Models\User;
use Amdrija\RealEstate\Application\RequestModels\PaginatedResponse;

?>

<h2 class="uk-heading-small uk-margin-top">Agencies</h2>
<table class="uk-table uk-table-hover uk-table-divider">
    <thead>
    <tr>
        <th></th>
        <th>Name</th>
        <th>PIB</th>
        <th>Street</th>
    </tr>
    </thead>
    <tbody>
    <?php /* @var $agency Agency */ ?>
    <?php foreach ($agencies as $agency): ?>
        <tr class="">
            <td><a href="/admin/agencies/delete/<?= $agency->id?>" uk-icon="icon: trash"></td>
            <td><?= $agency->name ?></td>
            <td><?= $agency->pib ?></td>
            <td><?= $streets[$agency->streetId]?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<a href="/admin/agencies/add">
    <div class="uk-card uk-card-hover uk-text-center uk-padding-small uk-text-large">+</div>
</a>
