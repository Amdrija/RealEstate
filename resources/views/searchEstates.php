<?php
/**
 * @var $cities array
 * @var $conditionTypes array
 * @var $estateTypes array
 * @var $paginatedResponse PaginatedResponse
 * @var $searchEstate SearchEstate
 */
?>

<div class="uk-card uk-card-default uk-card-body uk-margin-large-top">
    <h1 class="uk-heading-small">Advanced Search</h1>
    <form action="" method="get" class=" uk-child-width-1-2@m uk-grid-large" uk-grid>
        <div class="uk-child-width-1-2" uk-grid>
            <div>
                <label class="" for="price-from-input">Price from</label>
                <div class="uk-inline uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                    <input class="uk-input uk-width-1-1" type="number" step="1" id="price-from-input" name="priceFrom"
                        <?= isset($searchEstate) && $searchEstate->priceFrom > 0 ? "value=\"$searchEstate->priceFrom\"" : ""?>>
                </div>
            </div>
            <div>
                <label class="" for="price-up-to-input">Price up to</label>
                <div class="uk-inline uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                    <input class="uk-input uk-width-1-1" type="number" step="1" id="price-up-to-input" name="priceUpTo"
                        <?= isset($searchEstate) && $searchEstate->priceUpTo < PHP_INT_MAX ? "value=\"$searchEstate->priceUpTo\"" : ""?>>
                </div>
            </div>
        </div>
        <div class="uk-child-width-1-2 uk-margin-remove-top" uk-grid>
            <div>
                <label class="" for="surface-from-input">Surface from</label>
                <div class="uk-inline uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                    <input class="uk-input uk-width-1-1" type="number" id="surface-from-input" name="surfaceFrom"
                        <?= isset($searchEstate) && $searchEstate->surfaceFrom > 0 ? "value=\"$searchEstate->surfaceFrom\"" : ""?>>
                </div>
            </div>
            <div>
                <label class="" for="surface-up-to-input">Surface up to</label>
                <div class="uk-inline uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                    <input class="uk-input uk-width-1-1" type="number" step="1" id="surface-up-to-input" name="surfaceUpTo"
                        <?= isset($searchEstate) && $searchEstate->surfaceUpTo < PHP_INT_MAX ? "value=\"$searchEstate->surfaceUpTo\"" : ""?>>
                </div>
            </div>
        </div>
        <div class="uk-child-width-1-2" uk-grid>
            <div>
                <label class="" for="rooms-from-input">Number of rooms from</label>
                <div class="uk-inline uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                    <input class="uk-input uk-width-1-1" type="number" step="1" id="rooms-from-input" name="roomsFrom"
                        <?= isset($searchEstate) && $searchEstate->roomsFrom > 0 ? "value=\"$searchEstate->roomsFrom\"" : ""?>>
                </div>
            </div>
            <div>
                <label class="" for="rooms-up-to-input">Number of rooms up to</label>
                <div class="uk-inline uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                    <input class="uk-input uk-width-1-1" type="number" step="1" id="rooms-up-to-input" name="roomsUpTo"
                        <?= isset($searchEstate) && $searchEstate->roomsUpTo < PHP_INT_MAX ? "value=\"$searchEstate->roomsUpTo\"" : ""?>>
                </div>
            </div>
        </div>
        <div class="uk-child-width-1-2" uk-grid>
            <div class="">
                <label class="" for="year-from-input">Construction year from</label>
                <div class="uk-inline uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                    <input class="uk-input uk-width-1-1" type="number" step="1" id="year-from-input" name="yearFrom"
                        <?= isset($searchEstate) && $searchEstate->yearFrom > 0 ? "value=\"$searchEstate->yearFrom\"" : ""?>>
                </div>
            </div>
            <div>
                <label class="" for="year-up-to-input">Construction year up to</label>
                <div class="uk-inline uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                    <input class="uk-input uk-width-1-1" type="number" step="1" id="year-up-to-input" name="yearUpTo"
                        <?= isset($searchEstate) && $searchEstate->yearUpTo < PHP_INT_MAX ? "value=\"$searchEstate->yearUpTo\"" : ""?>>
                </div>
            </div>
        </div>

        <div class="uk-child-width-1-2" uk-grid>
            <div class="">
                <label class="" for="floor-from-input">Floor from</label>
                <div class="uk-inline uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                    <input class="uk-input uk-width-1-1" type="number" step="1" id="floor-from-input" name="floorFrom"
                        <?= isset($searchEstate) && $searchEstate->floorFrom > 0 ? "value=\"$searchEstate->floorFrom\"" : ""?>>
                </div>
            </div>
            <div>
                <label class="" for="floor-up-to-input">Floor up to</label>
                <div class="uk-inline uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                    <input class="uk-input uk-width-1-1" type="number" step="1" id="floor-up-to-input" name="floorUpTo"
                        <?= isset($searchEstate) && $searchEstate->floorUpTo < PHP_INT_MAX ? "value=\"$searchEstate->floorUpTo\"" : ""?>>
                </div>
            </div>
        </div>

        <div class="uk-child-width-1-2" uk-grid>
            <div class="">
                <label class="" for="location-input">City</label>
                <div class="uk-inline uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                    <select class="uk-select" name="cityId" id="location-input">
                        <option value="" onclick="resetMicroLocation()">Choose city...</option>
                        <?php /* @var $city City */
                        use Amdrija\RealEstate\Application\Models\City;
                        use Amdrija\RealEstate\Application\Models\ConditionType;
                        use Amdrija\RealEstate\Application\Models\EstateType;
                        use Amdrija\RealEstate\Application\Models\MicroLocation;
                        use Amdrija\RealEstate\Application\RequestModels\Estate\SearchEstate;
                        use Amdrija\RealEstate\Application\RequestModels\PaginatedResponse; ?>
                        <?php foreach ($cities as $city): ?>
                            <option value="<?= $city->id ?>" onclick="populateMicroLocations('<?= $city->id ?>')"><?= $city->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="uk-hidden" id="micro-location-container">
                <label class="" for="micro-location-input">Micro-location</label>
                <div class="uk-inline uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                    <select class="uk-select" name="microLocationIds[]" id="micro-location-input" multiple>
                        <option value="">Choose micro-location...</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="uk-child-width-1-2" uk-grid>
            <div>
                <label class="" for="condition-input">Condition</label>
                <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                    <select class="uk-select" name="conditionId" id="condition-input">
                        <option value="">Choose condition...</option>
                        <?php /* @var $conditionType ConditionType */?>
                        <?php foreach ($conditionTypes as $conditionType): ?>
                            <option value="<?= $conditionType->id ?>"><?= $conditionType->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div>
                <label class="" for="type-input">Type</label>
                <div class="uk-inline uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                    <select class="uk-select" name="typeId" id="type-input">
                        <option value="">Choose type...</option>
                        <?php /*  @var $estateType EstateType */?>
                        <?php foreach ($estateTypes as $estateType): ?>
                            <option value="<?= $estateType->id ?>"><?= $estateType->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="uk-child-width-1-2" uk-grid>
            <div>
            </div>
            <div class="uk-flex uk-flex-right uk-margin-large-top">
                <input type="submit" class="uk-button uk-button-primary" value="Search">
            </div>
        </div>
    </form>
</div>

<main class="uk-margin-large-top uk-margin-large-bottom">
    <h2 class="uk-heading-small">Search Results</h2>
    <?php if(isset($paginatedResponse)):?>
        <div class="uk-child-width-1-2@m uk-grid-small" uk-grid>
            <?php foreach($paginatedResponse->data as $estate):?>
                <?php include __DIR__ . '/../templates/estateSearchCard.php'?>
            <?php endforeach;?>
        </div>
        <?php include __DIR__ . '/../templates/pagination.php'?>
    <?php endif;?>

</main>

<script>
    const microLocationSelect = document.getElementById('micro-location-input');
    const microLocationContainer = document.getElementById('micro-location-container');

    function resetMicroLocation() {
        microLocationSelect.value = "";
        microLocationContainer.classList.add('uk-hidden');
    }

    async function populateMicroLocations(cityId){
        console.log(cityId);
        if(cityId) {
            let response = await fetch(window.location.origin + `/microLocations?cityId=${cityId}`, {
                method: 'GET'
            });

            if (response.ok) {
                microLocationContainer.classList.remove('uk-hidden');
                let microLocations = await response.json();

                for (let microLocation of microLocations) {
                    let option = document.createElement('option');
                    option.value = microLocation.id;
                    option.text = microLocation.name;
                    microLocationSelect.appendChild(option);
                }
            }
        }
    }
</script>