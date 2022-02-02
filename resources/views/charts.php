<?php
/**
  * @var User $user
  * @var Stats $stats
 * @var array $microLocations
  * */

use Amdrija\RealEstate\Application\Models\MicroLocation;
use Amdrija\RealEstate\Application\Models\Stats;
use Amdrija\RealEstate\Application\Models\User;

?>

<?php if(is_null($user->agencyId)):?>
    <form name="getStats" action="" method="GET" class="uk-padding uk-padding-remove-horizontal">
        <label class="" for="microLocation-input">Micro location</label>
        <div class="uk-width-small">
            <select class="uk-select" required name="microLocationId" id="microLocation-input">
                <option value="">Choose micro location...</option>
                <?php /* @var $microLocation MicroLocation */?>
                <?php foreach ($microLocations as $microLocation): ?>
                    <option value="<?= $microLocation->id ?>" <?= isset($_GET['microLocationId']) && $microLocation->id == $_GET['microLocationId']? "selected" : ""?>><?= $microLocation->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="uk-margin-top">
            <input type="submit" id="get-stats-button" class="uk-button uk-button-primary" value="Get Stats">
        </div>
    </form>
<?php endif;?>

<?php if(isset($error)): ?>
    <div uk-alert class="uk-alert-danger">
        <a class="uk-alert-close" uk-close></a>
        <p id="error"><?= $error ?></p>
    </div>
<?php else: ?>
    <div class="uk-width-1-2@s uk-margin-auto">
        <canvas class="uk-height-small uk-width-small" id="myChart" width="100" height="100"></canvas>
    </div>

    <script src="/js/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($stats->labels)?>,
                datasets: [{
                    label: 'Estates sold',
                    data: <?= json_encode($stats->values)?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
<?php endif;?>

