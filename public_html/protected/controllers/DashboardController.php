<?php

class DashboardController extends Controller
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
			array('allow', // allow admin user to perform 'dashboard' actions
				'actions'=>array('dashboard'),
				'users'=>array(Yii::app()->params['WEB_user']),
			),
			array('deny',  // deny all other users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Collects and analyzes data for Dashboard visualization
	 */
	public function actionDashboard()
	{
		$stats = Dashboard::analize();

		$this->render('dashboard', array(
			'stats'=>$stats,
			)
		);
	}
}
