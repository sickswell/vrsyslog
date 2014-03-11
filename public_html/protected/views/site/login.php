<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->pageTitle=Yii::app()->name . ' - Login';
?>

<?php
echo TbHtml::pageHeader(Yii::app()->name, 'Login');
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); 
echo $form->textFieldControlGroup($model,'username', array('prepend'=>'<i class="icon-user"></i>', 'span' => 3));
echo $form->passwordFieldControlGroup($model,'password',array('hint'=>'', 'prepend'=>'<i class="icon-lock"></i>', 'span' => 3));
echo $form->checkBoxControlGroup($model,'rememberMe');
echo TbHtml::formActions(array(
        TbHtml::submitButton('Login', array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE,)),
        TbHtml::resetButton('Reset', array('size' => TbHtml::BUTTON_SIZE_LARGE,)),
	));
$this->endWidget();
?>