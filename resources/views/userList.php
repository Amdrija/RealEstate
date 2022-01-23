<?php
/* @var $paginatedResponse PaginatedResponse*/

use Amdrija\RealEstate\Application\Models\User;
use Amdrija\RealEstate\Application\RequestModels\PaginatedResponse;

?>

<h2 class="uk-heading-small uk-margin-top">Users</h2>
<table class="uk-table uk-table-hover uk-table-divider">
    <thead>
    <tr>
        <th></th>
        <th>Username</th>
        <th>Email</th>
        <th class="uk-text-center">Verified</th>
        <th class="uk-text-center">Administrator</th>
    </tr>
    </thead>
    <tbody>
    <?php /* @var $user User*/?>
    <?php foreach($paginatedResponse->data as $user):?>
        <tr ondblclick="window.location='/admin/users/<?= $user->id?>'">
            <td><input class="uk-checkbox" type="checkbox"></td>
            <td><?= $user->userName?></td>
            <td><?= $user->email?></td>
            <td class="uk-text-center"><input class="uk-checkbox" type="checkbox" <?= $user->verified ? "checked" : ""?> disabled></td>
            <td class="uk-text-center"><input class="uk-checkbox" type="checkbox" <?= $user->isAdministrator ? "checked" : ""?> disabled></td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>


<?php include __DIR__ . '/../templates/pagination.php' ?>