<?php

class LogsController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'list' and 'view' actions
				'actions'=>array('list','view'),
				'users'=>array(Yii::app()->params['WEB_user']),
			),
			array('deny',  // deny all other users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular Log.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model=Logs::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		} else {
			$this->render('view',array(
				'model'=>$model,
			));
		}
	}

	/**
	 * Lists all Logs.
	 */
	public function actionList()
	{
		$model=new Logs('search');
		$model->unsetAttributes();

		if(isset($_GET['priority']))
			$model->Priority=(int)$_GET['priority'];

		if (isset($_GET['Logs'])) {
			$model->attributes=$_GET['Logs'];
		}

		$model->dbCriteria->order='ReceivedAt DESC';
		$this->render('list',array(
			'model'=>$model,
		));
	}

}