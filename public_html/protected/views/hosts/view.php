<?php $this->pageTitle=Yii::app()->name . ' - ' . $model[0]['name']; ?>

<?php $this->breadcrumbs=array('Hosts'=>array('list'), $model[0]['name']);?>

<div class="page-header row-fluid">

	<div id="title-text" class="span7">
		<h1><?php echo $model[0]['name']; ?> <small><?php echo $model[0]['total']; ?> logs <?php echo $model[0]['daterange']; ?></small></h1>
	</div>

	<div id="date-range" class="span5 text-right">
	<br>
	<?php echo TbHtml::beginFormTb(TbHtml::FORM_LAYOUT_INLINE, '', 'get'); ?>	
	<fieldset>
		<div class="input-append input-prepend">
		<span class="add-on"><icon class="icon-calendar"></icon></span>
			<?php $this->widget(
			    'yiiwheels.widgets.daterangepicker.WhDateRangePicker',
			    array(
			        'name' => 'daterangepicker',
			        'id' => 'daterangepicker',
			        'value' => $datefilter->daterange,
			        'pluginOptions' => array(
			        	'opens' => 'left',
			        	'format' => 'YYYY-MM-DD',
			        	'maxDate' => date("Y-m-d"), // H:i:s
						'ranges' => array(
							'Today' => array(date("Y-m-d"), date("Y-m-d")),
			    	   		'Yesterday' => array(date("Y-m-d",time()-(60*60*24)), date("Y-m-d",time()-(60*60*24))),
			    	   		'Last 7 days' => array(date("Y-m-d",time()-(60*60*24*7)), date("Y-m-d")),
			    	   		'Last 30 days' => array(date("Y-m-d",time()-(60*60*24*30)), date("Y-m-d")),
						),
			        ),
			        'htmlOptions' => array(
			            'placeholder' => $datefilter->getAttributeLabel('daterange'),
			        ),
			    )
			);
			?>
			<?php echo TbHtml::submitButton(TbHtml::icon(TbHtml::ICON_FILTER).' Filter', array('name'=>'filter_button', 'value'=>'filter')); ?>
			<?php echo TbHtml::submitButton(TbHtml::icon(TbHtml::ICON_REMOVE).' Clear', array('name'=>'reset_button', 'value'=>'reset')); ?>
		</div>   		
	</fieldset>
	<?php echo TbHtml::endForm(); ?>
	</div>
</div>
 
<?php echo TbHtml::errorSummary($datefilter); ?>

<?php $this->widget('bootstrap.widgets.TbAlert', array(
		'block'=>false,
	//	'closeText'=>'CLEAR',
		'htmlOptions' => array(
		//	'href' => 'www.google.com',

			),
)); ?>

<div id="host-dashboard" class="row-fluid">
 	<div id="Severity_table" class="span5">
		<table class="table table-bordered table-hover table-striped">
			<tbody>
				<tr>
				 	<td>Logs by <b>Severity</b></td>
				 	<th style="text-align:center">Total</th> 
				</tr>
				<?php foreach ($model['host_severities_table'][0] as $key => $log_severity) { ?>
				<tr>
					<th>
						<?php if ($log_severity > 0) {?>
							<?php echo TbHtml::link(Helpers::getSeverity($key), array("/logs/list&priority=$key&fromhost=".$model[0]['name'].'&receivedat='.$datefilter->daterange));?>
						<?php } else {?>
							<?php echo Helpers::getSeverity($key); ?>
						<?php } ?>
					</th>
      				<td style="text-align:center"><?php echo TbHtml::badge($log_severity, array('color' => Helpers::getSeverityColor($key)));?></td>
    			</tr>
    			<?php } ?>
    		</tbody>
		</table>
	</div>

	<div id="Facility_table" class="span5">
		<table class="table table-bordered table-hover table-striped">
			<tbody>
				<tr>
				 	<td>Logs by <b>Facility</b> (top 8)</td>
				 	<th style="text-align:center">Total</th> 
				</tr>
				<?php for ($i = 0; $i <= 7; $i++) { ?>
				<tr>
		  			<?php if (array_key_exists($i, $model['host_facilities'])) { ?>
  						<?php $log_facility = $model['host_facilities'][$i];?>
						<th><?php echo TbHtml::link($log_facility['label'], array("/logs/list&facility=".$log_facility['Facility']."&fromhost=".$model[0]['name'].'&receivedat='.$datefilter->daterange));?></th>
      					<td style="text-align:center"><?php echo TbHtml::badge($log_facility['value']);?></td>
					<?php } else { ?>
						<th><font color="gray">-</font></th>
      					<td style="text-align:center"><font color="gray">-</font></td>
					<?php } ?>
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

<?php $this->widget('application.extensions.morris.MorrisChartWidget', array(
		'id'      => 'Severities_donut',
		'options' => array(
        	'chartType' => 'Donut',
        	'data'      => $model['host_severities'],
			'colors'=> $model['severity_colors'],
),));?>	

<?php $this->widget('application.extensions.morris.MorrisChartWidget', array(
		'id'      => 'Facilities_donut',
		'options' => array(
			'chartType' => 'Donut',
			'data'      => $model['host_facilities'],
),));?>

<?php echo TbHtml::pageHeader('Severity', 'chart'); ?>
<div id="severity_chart" class="row-fluid" style="height: 400px"></div>

<?php $this->widget('application.extensions.morris.MorrisChartWidget', array(
    	'id'      => 'severity_chart',
    	'options' => array(
        	'chartType' => 'Area',
        	'data'      => $model['severities_daily'],
        	'xkey'      => 'logdate',
        	'ykeys'     => Helpers::getSeverity(),
        	'labels'    => Helpers::getSeverity(),
        	'lineColors'=> Helpers::getMorrisColors(),
        	'xLabels'	=> 'day',
),)); ?>

<?php echo TbHtml::pageHeader('Facility', 'chart'); ?>
<div id="facility_chart" class="row-fluid" style="height: 400px"></div>

<?php $this->widget('application.extensions.morris.MorrisChartWidget', array(
    	'id'      => 'facility_chart',
    	'options' => array(
    		'behaveLikeLine'=> true,
        	'chartType' => 'Area',
        	'data'      => $model['facilities_daily'],
        	'xkey'      => 'logdate',
        	'ykeys'     => Helpers::getFacility(),
        	'labels'    => Helpers::getFacility(),
        //	'lineColors'=> Helpers::getMorrisColors(),
        	'xLabels'	=> 'day',
),)); ?>