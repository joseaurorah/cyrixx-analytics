<?php defined('ALTUMCODE') || die() ?>

<?php ob_start() ?>
<div class="card mb-5">
    <div class="card-body">
        <h2 class="h4"><i class="fa fa-fw fa-fire fa-xs text-muted"></i> <?= l('admin_statistics.websites_heatmaps.header') ?></h2>
        <div class="d-flex flex-column flex-xl-row">
            <div class="mb-2 mb-xl-0 mr-4">
                <span class="font-weight-bold"><?= nr($data->total['websites_heatmaps']) ?></span> <?= l('admin_statistics.websites_heatmaps.chart') ?>
            </div>
        </div>

        <div class="chart-container">
            <canvas id="websites_heatmaps"></canvas>
        </div>
    </div>
</div>

<?php $html = ob_get_clean() ?>

<?php ob_start() ?>
<script>
    'use strict';

    let color = css.getPropertyValue('--primary');
    let color_gradient = null;

    /* Display chart */
    let websites_heatmaps_chart = document.getElementById('websites_heatmaps').getContext('2d');
    color_gradient = websites_heatmaps_chart.createLinearGradient(0, 0, 0, 250);
    color_gradient.addColorStop(0, 'rgba(63, 136, 253, .1)');
    color_gradient.addColorStop(1, 'rgba(63, 136, 253, 0.025)');

    new Chart(websites_heatmaps_chart, {
        type: 'line',
        data: {
            labels: <?= $data->websites_heatmaps_chart['labels'] ?>,
            datasets: [
                {
                    label: <?= json_encode(l('admin_statistics.websites_heatmaps.chart')) ?>,
                    data: <?= $data->websites_heatmaps_chart['websites_heatmaps'] ?? '[]' ?>,
                    backgroundColor: color_gradient,
                    borderColor: color,
                    fill: true
                }
            ]
        },
        options: chart_options
    });
</script>
<?php $javascript = ob_get_clean() ?>

<?php return (object) ['html' => $html, 'javascript' => $javascript] ?>