<?php $this->breadcrumbs=array('Dashboard',);?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.sparkline.min.js'); ?>
<script type="text/javascript">
	$(function() { $('.inlinesparkline').sparkline('html', { enableTagOptions: true } ); });
</script>

<?php echo TbHtml::pageHeader('Summary', $stats['totalLogs'] . ' logs @ '. $stats['date']); ?>

<div id="Summary" class="row-fluid">
	 <div id="Summary_table" class="span4">
		<table class="table table-bordered table-hover table-striped">
			<tbody>
				<tr>
				 	<th>Severity</th>
				 	<th style="text-align:center">Total</th> 
				 	<th style="text-align:center">Trend</th>
				</tr>
				<?php foreach ($logs_severities_table[0] as $key => $log_severity) { ?>
				<tr>
					<th><?php echo TbHtml::link(Helpers::getSeverity($key), $url = array("/logs/list&priority=$key"));?></th>
      				<td style="text-align:center"><?php echo TbHtml::badge($log_severity, array('color' => Helpers::getSeverityColor($key)));?></td>
      				<?php
      					$spark_values = "";
						foreach($logs_daily as $log_day) {
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
	<div id="Donuts" class="row-fluid">
		<div class="span4">
			<div><h5 style="text-align:center">Totals by Severity</h5></div>
			<div id="Severities_donut" style="height: 300px"></div>
		</div>
		<div class="span4">
			<div><h5 style="text-align:center">Totals by Facility</h5></div>
    		<div id="Facilities_donut" style="height: 300px"></div>
    	</div>
	</div>	
</div>

<?php echo TbHtml::pageHeader('Volume', 'last 10 days'); ?>
<div id="Area_chart" class="row-fluid" style="height: 400px"></div>



<?php $this->widget('application.extensions.morris.MorrisChartWidget', array(
		'id'      => 'Severities_donut',
		'options' => array(
        	'chartType' => 'Donut',
        	'data'      => $logs_severities,
			'colors'=> $severity_colors,
),));?>	

<?php $this->widget('application.extensions.morris.MorrisChartWidget', array(
		'id'      => 'Facilities_donut',
		'options' => array(
			'chartType' => 'Donut',
			'data'      => $logs_facilities,
),));?>

<?php $this->widget('application.extensions.morris.MorrisChartWidget', array(
    	'id'      => 'Area_chart',
    	'options' => array(
        	'chartType' => 'Area',
        	'data'      => $logs_daily,
        	'xkey'      => 'logdate',
        	'ykeys'     => Helpers::getSeverity(),
        	'labels'    => Helpers::getSeverity(),
        	'lineColors'=> Helpers::getMorrisColors(),
        	'xLabels'	=> 'day',
),)); ?>