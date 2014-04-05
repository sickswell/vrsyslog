<?php
/* @var $this SiteController */
$this->pageTitle=Yii::app()->name . ' - Logger';
?>


<div class="row-fluid">
<?php echo TbHtml::pageHeader('Logger', 'log message generator'); ?>
<?php echo TbHtml::alert(TbHtml::ALERT_COLOR_WARNING, '<strong>WARNING:</strong> UDP syslog reception MUST be enabled in the SysLog Server.'); ?>

<div>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm'); ?>
 
	<?php echo TbHtml::errorSummary($model); ?>

	<?php $this->widget('bootstrap.widgets.TbAlert'); ?>

    <fieldset>

	<?php echo $form->textFieldControlGroup($model, 'hostname',
        array('help' => 'HOST sending the log message.')); ?>

	<?php echo $form->dropDownListControlGroup($model, 'facility', Helpers::getFacility()); ?>

	<?php echo $form->dropDownListControlGroup($model, 'severity', Helpers::getSeverity()); ?>

	<?php echo $form->textFieldControlGroup($model, 'content'); ?>

	<?php echo $form->textFieldControlGroup($model, 'server', array('help' => 'SysLog SERVER receiving the log message.')); ?>

    </fieldset>

	<?php echo TbHtml::formActions(array(
		TbHtml::submitButton('Send log', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
    	TbHtml::resetButton('Reset'),
    )); ?>
 
<?php $this->endWidget(); ?>
</div>

</div>