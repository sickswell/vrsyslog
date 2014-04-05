<?php

class SiteController extends Controller
{
	
	/**
	 * This is the default 'index' action
	 */
	public function actionIndex()
	{	
		$this->render('index');
	}

	/**
	 * Displays the 'logger' test page
	 */
	public function actionLogger()
	{	
		if(Yii::app()->user->isGuest)
		{
			$this->redirect(Yii::app()->homeUrl);
		}
 		
 		$model=new LoggerForm;
 		if(isset($_POST['LoggerForm']))
 		{
 			// collects user input data
 			$model->attributes=$_POST['LoggerForm'];
 			// validates user input and sends the Log message
 			if($model->validate())
 				$syslog = new Syslog($model->facility, $model->severity, $model->hostname);
				$syslog->SetProcess('Logger');
 				$syslog_result = $syslog->Send($model->server, $model->content);
 				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_INFO, '<strong>LOG sent:</strong> ' . $syslog_result);
 		}
 		// displays the logger form
	//	$model->content= "Test message " . date("Y-m-d H:i:s");
		$this->render('logger',array('model'=>$model));	
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if(!Yii::app()->user->isGuest)
		{
			$this->redirect(Yii::app()->homeUrl);
		}
		$model=new LoginForm;
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input
			if($model->validate() && $model->login())
				$this->redirect(array('/dashboard/dashboard'));
		}
		// display the login form
		$this->layout = 'login';
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}