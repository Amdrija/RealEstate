<?php
/* @var $streets array
 * @var $microLocations array
 */

use Amdrija\RealEstate\Application\Models\Agency;
use Amdrija\RealEstate\Application\Models\Street;
use Amdrija\RealEstate\Application\Models\User;
use Amdrija\RealEstate\Application\RequestModels\PaginatedResponse;

?>

<h2 class="uk-heading-small uk-margin-top">Streets</h2>
<table class="uk-table uk-table-hover uk-table-divider">
    <thead>
    <tr>
        <th></th>
        <th>Name</th>
        <th>MicroLocation</th>
    </tr>
    </thead>
    <tbody>
    <?php /* @var $street Street */ ?>
    <?php foreach ($streets as $street): ?>
        <tr class="">
            <td><a href="/admin/streets/delete/<?= $street->id?>" uk-icon="icon: trash"></td>
            <td><?= $street->name ?></td>
            <td><?= $microLocations[$street->microLocationId]?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<a href="/admin/streets/add">
    <div class="uk-card uk-card-hover uk-text-center uk-padding-small uk-text-large">+</div>
</a>
