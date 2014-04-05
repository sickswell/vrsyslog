<?php $this->breadcrumbs=array('Dashboard',);?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.sparkline.min.js'); ?>
<script type="text/javascript">
	$(function() { $('.inlinesparkline').sparkline('html', { enableTagOptions: true } ); });
</script>
<script type="text/javascript">
	$(function() { $('.inlinesparkpie').sparkline('html', { enableTagOptions: true, sliceColors: <?php echo json_encode(Helpers::getMorrisColors());?> } ); });
</script>

<?php echo TbHtml::pageHeader('Summary', $stats['totalLogs'] . ' logs @ '. $stats['date']); ?>

<div id="Summary" class="row-fluid">
	 <div id="Severity_table" class="span5">
		<table class="table table-bordered table-hover table-striped">
			<tbody>
				<tr>
				 	<td>Logs by <b>Severity</b></td>
				 	<th style="text-align:center">Total</th> 
				 	<th style="text-align:center"><?php echo TbHtml::abbr('Trend', 'Trend, last 10 days'); ?></th>
				</tr>
				<?php foreach ($stats['logs_severities_table'][0] as $key => $log_severity) { ?>
				<tr>
					<th><?php echo TbHtml::link(Helpers::getSeverity($key), array("/logs/list&priority=$key"));?></th>
      				<td style="text-align:center"><?php echo TbHtml::badge($log_severity, array('color' => Helpers::getSeverityColor($key)));?></td>
      				<?php
      					$spark_values = "";
						foreach($stats['logs_daily'] as $log_day) {
							$spark_values .= $log_day[Helpers::getSeverity($key)] . ",";
						}
						$spark_values = rtrim($spark_values, ',');
					?>
      				<td style="text-align:center"><span class="inlinesparkline" sparkType="bar" sparkBarColor="<?php echo Helpers::getMorrisColors($key); ?>" values="<?php echo $spark_values; ?>"></span></td>
    			</tr>
    			<?php } ?>
    		</tbody>
		</table>
	</div>

	<div id="Facility_table" class="span5">
		<table class="table table-bordered table-hover table-striped">
			<tbody>
				<tr>
				 	<th>Top active <?php echo TbHtml::link('HOSTS', array('hosts/list')); ?></th>
				 	<th style="text-align:center">Logs</th> 
				 	<th style="text-align:center">Severity %</th>
				</tr>
				<?php foreach ($stats['hosts_table'] as $row) { ?>
				<tr>
					<td><?php echo TbHtml::link($row['FromHost'], array("/hosts/view&host=".$row['FromHost']));?></td>
      				<td style="text-align:center"><?php echo TbHtml::badge($row['Total']);?></td>
      				<?php
      					$spark_values = '';
      					for ($i = 0; $i <= 7; $i++) {
      						$spark_values .= $row[$i] . ",";
      					}
      					$spark_values = rtrim($spark_values, ',');
      				?>
      				<td style="text-align:center"><span class="inlinesparkpie" sparkType="pie" values="<?php echo $spark_values; ?>"></span></td>
    			</tr>
    			<?php } ?>
    		</tbody>
		</table>
	</div>

	<div id="Donuts" class="span2">
		<table class="table table-bordered table-striped">
			<tbody>
			<tr><td>Totals by <b>Severity</b><div id="Severities_donut" style="height: 130px"></div></td></tr>
   			<tr><td>Totals by <b>Facility</b><div id="Facilities_donut" style="height: 130px"></div></td></tr>
   			</tbody>
   		</table>
   	</div>

</div>

<?php echo TbHtml::pageHeader('Volume', 'last 10 days'); ?>
<div id="Area_chart" class="row-fluid" style="height: 400px"></div>

<?php $this->widget('application.extensions.morris.MorrisChartWidget', array(
		'id'      => 'Severities_donut',
		'options' => array(
        	'chartType' => 'Donut',
        	'data'      => $stats['logs_severities'],
			'colors'=> $stats['severity_colors'],
),));?>	

<?php $this->widget('application.extensions.morris.MorrisChartWidget', array(
		'id'      => 'Facilities_donut',
		'options' => array(
			'chartType' => 'Donut',
			'data'      => $stats['logs_facilities'],
),));?>

<?php $this->widget('application.extensions.morris.MorrisChartWidget', array(
    	'id'      => 'Area_chart',
    	'options' => array(
        	'chartType' => 'Area',
        	'data'      => $stats['logs_daily'],
        	'xkey'      => 'logdate',
        	'ykeys'     => Helpers::getSeverity(),
        	'labels'    => Helpers::getSeverity(),
        	'lineColors'=> Helpers::getMorrisColors(),
        	'xLabels'	=> 'day',
),)); ?>
