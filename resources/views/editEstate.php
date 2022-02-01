<?php
/**
 * @var $estateTypes array
 * @var $conditionTypes array
 * @var $heatingTypes array
 * @var $streets array
 * @var $busLines array
 * @var $perks array
 * @var $estate EstateForEditing
 */

?>
<div class="uk-margin-auto login-modal uk-margin-top">
    <h1 class="uk-text-center">Add Estate</h1>
    <?php use Amdrija\RealEstate\Application\Models\Agency;
    use Amdrija\RealEstate\Application\Models\BusLine;
    use Amdrija\RealEstate\Application\Models\City;
    use Amdrija\RealEstate\Application\Models\ConditionType;
    use Amdrija\RealEstate\Application\Models\Estate;
    use Amdrija\RealEstate\Application\Models\EstateType;
    use Amdrija\RealEstate\Application\Models\HeatingType;
    use Amdrija\RealEstate\Application\Models\Perk;
    use Amdrija\RealEstate\Application\Models\Street;
    use Amdrija\RealEstate\Application\Models\User;
    use Amdrija\RealEstate\Application\RequestModels\Estate\EstateForEditing;

    if (!empty($error)): ?>
        <div uk-alert class="uk-alert-danger">
            <a class="uk-alert-close" uk-close></a>
            <p id="error"><?= $error ?></p>
        </div>
    <?php endif; ?>
    <div class="center-content uk-margin-large-bottom">
        <form method="post" enctype="multipart/form-data">
            <label class="" for="name-input">Estate name</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <span class="uk-form-icon uk-form-icon" uk-icon="icon: home"></span>
                <input class="uk-input uk-width-1-1" type="text" value="<?= $estate->name?>" placeholder="Name" name="name" id="name-input" required>
            </div>
            <label class="" for="price-input">Price</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <input class="uk-input uk-width-1-1" type="number" value="<?= $estate->price?>" step="1" id="price-input" name="price" required>
            </div>

            <label class="" for="surface-input">Surface</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <input class="uk-input uk-width-1-1" type="number" value="<?= $estate->surface?>" id="surface-input" name="surface" required>
            </div>

            <label class="" for="rooms-input">Number of Rooms</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <input class="uk-input uk-width-1-1" type="number" value="<?= $estate->numberOfRooms?>" step="1" placeholder="First name" id="rooms-input" name="numberOfRooms" required>
            </div>
            <label class="" for="type-input">Type</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <select class="uk-select" required name="typeId" id="type-input">
                    <option value="">Choose type...</option>
                    <?php /*  @var $estateType EstateType */?>
                    <?php foreach ($estateTypes as $estateType): ?>
                        <option value="<?= $estateType->id ?>" <?= $estate->typeId == $estateType->id ? "selected" : ""?>><?= $estateType->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <label class="" for="constructionDate-input">Construction date</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <span class="uk-form-icon uk-form-icon" uk-icon="icon: calendar"></span>
                <input class="uk-input uk-width-1-1" type="date" value="<?= $estate->constructionDate->format("Y-m-d")?>" id="constructionDate-input" name="constructionDate" required>
            </div>
            <label class="" for="condition-input">Condition</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <select class="uk-select" required name="conditionId" id="condition-input">
                    <option value="">Choose condition...</option>
                    <?php /* @var $conditionType ConditionType */?>
                    <?php foreach ($conditionTypes as $conditionType): ?>
                        <option value="<?= $conditionType->id ?>" <?= $estate->conditionId == $conditionType->id ? "selected" : ""?>><?= $conditionType->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <label class="" for="heating-input">Heating</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <select class="uk-select" required name="heatingId" id="heating-input">
                    <option value="">Choose heating...</option>
                    <?php /* @var $heatingType HeatingType */?>
                    <?php foreach ($heatingTypes as $heatingType): ?>
                        <option value="<?= $heatingType->id ?>" <?= $estate->heatingId == $heatingType->id ? "selected" : ""?>><?= $heatingType->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <label class="" for="Perks">Perks</label>
            <fieldset class="uk-fieldset uk-padding-small uk-padding-remove-horizontal uk-margin-bottom uk-grid-small uk-text-left uk-child-width-1-2" uk-grid>
                <input class="uk-checkbox uk-hidden" type="checkbox" name="perks[]" checked value="">
                <?php /* @var $perk Perk */?>
                <?php foreach ($perks as $perk): ?>
                    <label class=""><input class="uk-checkbox" type="checkbox" name="perks[]" value="<?= $perk->id?>" <?= in_Array($perk->id, $estate->perks) ? "checked" : ""?>> <?= $perk->name?></label>
                <?php endforeach; ?>
            </fieldset>

            <label class="" for="floor-input">Floor</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <input class="uk-input uk-width-1-1" type="number" value="<?= $estate->floor?>" step="1" id="lastname-input" name="floor" required>
            </div>
            <label class="" for="totalFloors-input">Total floors</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <input class="uk-input uk-width-1-1" type="number" value="<?= $estate->totalFloors?>" step="1" id="totalFloors-input" name="totalFloors" required>
            </div>

            <label class="" for="description-input">Description</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <textarea class="uk-textarea uk-width-1-1" rows="5" placeholder="Textarea" id="description-input" name="description" required><?= $estate->description?></textarea>
            </div>

            <label class="" for="street-input">Street</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <select class="uk-select" required name="streetId" id="street-input">
                    <option value="">Choose street...</option>
                    <?php /* @var $street Street */?>
                    <?php foreach ($streets as $street): ?>
                        <option value="<?= $street->id ?>" <?= $estate->streetId == $street->id ? "selected" : ""?>><?= $street->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <label class="" for="street-input">Street number</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <input class="uk-input uk-width-1-1" type="number" value="<?= $estate->streetNumber ?>" step="1" min="1" id="street-input" name="streetNumber" required>
            </div>

            <label class="" for="busLines-input">Bus lines</label>
            <div class="uk-inline uk-margin-bottom uk-width-1-1 uk-padding-small uk-padding-remove-horizontal">
                <select class="uk-select" name="busLines[]" id="busLines-input" multiple>
                    <option value="" class="uk-hidden" selected></option>
                    <?php /* @var $busLine BusLine */?>
                    <?php foreach ($busLines as $busLine): ?>
                        <option value="<?= $busLine->name ?>" <?= str_contains($estate->busLines, $busLine->name) ? "selected" : ""?>><?= $busLine->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <label for="image-input">Images</label>
            <div uk-form-custom="target: true">
                <input type="file" name="images[]" multiple accept="image/png, image/jpeg">
                <input class="uk-input uk-form-width-medium" type="text" placeholder="Select file" disabled id="image-input">
            </div>

            <div class="uk-flex uk-flex-between uk-margin-large-top">
                <!-- This is a button toggling the modal -->
                <button class="uk-button uk-button-danger uk-margin-small-right" type="button" uk-toggle="target: #modal-example">Delete</button>
                <a href="/estates/sell/<?= $estate->id?>" class="uk-button uk-button-default uk-margin-small-right">Sell</a>

                <input type="submit" class="uk-button uk-button-primary" value="Edit">
            </div>


            <!-- This is the modal -->
            <div id="modal-example" uk-modal>
                <div class="uk-modal-dialog uk-modal-body">
                    <h2 class="uk-modal-title">Delete estate?</h2>
                    <p>If you delete the esate, you will lose all data.</p>
                    <p class="uk-text-right">
                        <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                        <a href="/estates/delete/<?= $estate->id ?>" class="uk-button uk-button-primary" type="button">Save</a>
                    </p>
                </div>
            </div>
        </form>
    </div>
</div>
