<?php
/* @var $this SiteController */
$this->pageTitle=Yii::app()->name;
?>

<div class="row-fluid">
<?php
$button='';
if(Yii::app()->user->isGuest) {
	$button=
		TbHtml::linkButton('Login', array(
			'color' => TbHtml::BUTTON_COLOR_INFO,
			'size' => TbHtml::BUTTON_SIZE_LARGE,
			'url' => array('/site/login')
			));
	}

$this->widget('bootstrap.widgets.TbHeroUnit',array(
    'heading'=> CHtml::encode(Yii::app()->name),
    'content' => '<p>Visual interface for Rocket-fast SYStem for LOG processing</p>'.$button
)); 
 ?>


<?php if(!Yii::app()->user->isGuest) { ?>

<p>You may configure this application by editing the following file(s):</p>
<ul>
	<li>Main configuration: <code><?php echo YiiBase::getPathOfAlias('application').'/vrsyslog.ini'; ?></code></li>
</ul>

<?php }?>

<p>For more details about this application, please visit the <a href="http://codermaverick.github.io/vrsyslog/">repository</a> page.</p>
</div>