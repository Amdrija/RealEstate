<?php
/**
 * @var $favouriteEstates
 */
?>
<main class="uk-margin-large-top uk-margin-large-bottom">
    <h2 class="uk-heading-small">Favourites</h2>
    <?php if(!empty($favouriteEstates)):?>
        <div class="uk-child-width-1-2@m uk-grid-small" uk-grid>
            <?php foreach($favouriteEstates as $estate):?>
                <?php include __DIR__ . '/../templates/estateSearchCard.php'?>
            <?php endforeach;?>
        </div>
    <?php endif;?>
</main>