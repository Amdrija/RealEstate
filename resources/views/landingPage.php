<?php /* @var $estates array*/?>
<h1>Hello</h1>
<div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-medium uk-margin-large" uk-grid="masonry: true">
    <?php foreach($estates as $estate):?>
        <?php include __DIR__ . '/../templates/estateCard.php'?>
    <?php endforeach;?>
</div>
