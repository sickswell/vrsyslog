<?php
/* @var $this SiteController */
$this->pageTitle=Yii::app()->name;
?>

<div class="row-fluid">
<?php
$button='';
if(Yii::app()->user->isGuest) {
	$button= TbHtml::linkButton('Login', array(
			'color' => TbHtml::BUTTON_COLOR_INFO,
			'size' => TbHtml::BUTTON_SIZE_LARGE,
			'url' => array('/site/login')
	));
}; 

$this->widget('bootstrap.widgets.TbHeroUnit',array(
    'heading'=> CHtml::encode(Yii::app()->name),
    'content' => '<p>Visual interface for Rocket-fast SYStem for LOG processing</p>'.$button
)); 
 ?>

<?php if(!Yii::app()->user->isGuest) { ?>

<h4>Information:</h4>
<dl>
	<dt>Test logs</dt>
	<dd>Use the <?php echo TbHtml::link('logger', array('site/logger')); ?> tool to generate test log messages.</dd>
	<br>
	<dt>Configuration</dt>
	<dd>Configure this application by editing: <?php echo TbHtml::code(YiiBase::getPathOfAlias('application').'/vrsyslog.ini'); ?></dd>
</dl>
<?php }?>

<p>For more details, please visit the <a href="http://sickswell.github.io/vrsyslog/">repository</a> page.</p>
</div>