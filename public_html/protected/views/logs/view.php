<?php
/* @var $this SystemEventsController */
/* @var $model SystemEvents */
?>

<?php $this->breadcrumbs=array('Logs'=>array('list'),$model->ID,);?>

<?php echo TbHtml::pageHeader('Log # ' . $model->ID, $model->ReceivedAt); ?>

<div id="Donuts" class="row-fluid">
<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'ReceivedAt',
		'DeviceReportedTime',
		array(
			'label'=>'Facility',
			'type'=>'raw',
			'value' => TbHtml::badge(Helpers::getFacility($model->Facility), array('color' => 'info')),
		),		
		array(
			'label'=>'Priority',
			'type'=>'raw',
			'value' => TbHtml::badge(Helpers::getSeverity($model->Priority), array('color' => Helpers::getSeverityColor($model->Priority))),
		),
		'FromHost',
		'Message',
		'SysLogTag',
		'InfoUnitID',
	),
)); ?>
</div>