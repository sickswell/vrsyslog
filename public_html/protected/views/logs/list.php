<?php
/* @var $this SystemEventsController */
/* @var $model SystemEvents */
?>

<?php 
/*
Yii::app()->clientScript->registerScript('re-attach-datepicker-events',
	'function re_attach_events() {
		 console.log($(".daterangepicker").remove());
		$("#Logs_ReceivedAt").daterangepicker();
	}'
);
*/
?>


<?php $this->breadcrumbs=array('Logs',);?>

<div id="Logs" class="row-fluid">
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'system-events-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	//'afterAjaxUpdate' => 're_attach_events',
	'type' => TbHtml::GRID_TYPE_STRIPED.' '.TbHtml::GRID_TYPE_HOVER,
	'columns'=>array(
		'ReceivedAt',
		/*
		array(
			'name'=>'ReceivedAt',
			'filter'=> $this->widget('yiiwheels.widgets.daterangepicker.WhDateRangePicker',array(
				'name' => 'Logs[ReceivedAt]',
				'id' => 'Logs_ReceivedAt',
				'callback' => 'js:function(){$.fn.yiiGridView.update("system-events-grid");}',
				'value' => $model->ReceivedAt,
				'pluginOptions' => array(
			        //	'opens' => 'left',
			        	'format' => 'YYYY-MM-DD',
			        	'maxDate' => date("Y-m-d"), // H:i:s
						'ranges' => array(
							'Today' => array(date("Y-m-d"), date("Y-m-d")),
			    	   		'Yesterday' => array(date("Y-m-d",time()-(60*60*24)), date("Y-m-d",time()-(60*60*24))),
			    	   		'Last 7 days' => array(date("Y-m-d",time()-(60*60*24*7)), date("Y-m-d")),
			    	   		'Last 30 days' => array(date("Y-m-d",time()-(60*60*24*30)), date("Y-m-d")),
						),
				),
			), TRUE),
        ),
        */
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
		array(
			'name'=>'FromHost',
			'header'=>'From Host',
			'type'=>'raw',
			'value' =>'TbHtml::link($data->FromHost, array("/hosts/view&host=".$data->FromHost))',
		),
		'Message',
		'SysLogTag',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template' => '{view}',
		),
	),
)); ?>
</div>
