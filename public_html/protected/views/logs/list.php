<?php
/* @var $this SystemEventsController */
/* @var $model SystemEvents */
?>

<?php $this->breadcrumbs=array('Logs',);?>

<div id="Donuts" class="row-fluid">
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'system-events-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type' => TbHtml::GRID_TYPE_STRIPED.' '.TbHtml::GRID_TYPE_HOVER,
	'columns'=>array(
		'ReceivedAt',
		array(
			'name'=>'Facility',
			'type'=>'raw',
			'value' =>'TbHtml::encode(Helpers::getFacility($data->Facility))',
			'filter'=>Helpers::getFacility(),
		),
		array(
			'name'=>'Priority',
			'header'=>'Severity',
			'type'=>'raw',
			'value' =>'TbHtml::badge(Helpers::getSeverity($data->Priority), array(\'color\' => Helpers::getSeverityColor($data->Priority)))',
			'filter'=>Helpers::getSeverity(),
		),
		'FromHost',
		'Message',
		'SysLogTag',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template' => '{view}',
		),
	),
)); ?>
</div>