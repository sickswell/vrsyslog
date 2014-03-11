<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<?php Yii::app()->bootstrap->register(); ?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/vrsyslog.css" />
</head>
<body>
	<?php $this->widget('bootstrap.widgets.TbNavbar',array(
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbNav',
            'items'=>array(
            	array('label'=>'Dashboard', 'url'=>array('/dashboard/dashboard'), 'visible'=>!Yii::app()->user->isGuest),
            	array('label'=>'Logs', 'url'=>array('/logs/list'), 'visible'=>!Yii::app()->user->isGuest),
            ),
        ),
        array(
            'class'=>'bootstrap.widgets.TbNav',
            'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(
  			array('label'=>'Logout', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
            ),
        ),),
	)); ?>
	<div class="container-fluid" id="page">
		<?php if(isset($this->breadcrumbs)):
			$this->widget('bootstrap.widgets.TbBreadcrumb', array('links'=>$this->breadcrumbs)); 
		endif ?><!-- breadcrumbs -->
		<?php echo $content; ?>
		<hr/>
		<div id="footer">
			Copyright &copy; <?php echo date('Y'); ?> by SickSwell.<br/>
		</div><!-- footer -->
	</div><!-- page -->
</body>
</html>
