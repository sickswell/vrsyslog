<?php

class HostsController extends Controller
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
				'actions'=>array('list', 'view'),
				'users'=>array(Yii::app()->params['WEB_user']),
			),
			array('deny',  // deny all other users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Lists all Hosts.
	 */
	public function actionList()
	{
		$model = Hosts::listHosts();

		$this->render('list', array(
			'model'=>$model,
			)
		);
	}

	/**
	 * Displays a particular Host.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($host, $start=false, $end=false)
	{

		if(isset($_GET['reset_button'])) {
			$this->redirect(array('/hosts/view', 'host'=>$host));
		}

		$datefilter=new DatefilterForm;

		if(isset($_GET['daterangepicker'])) {

			if($_GET['daterangepicker']!='') {
				// collects user input data
				$datefilter->daterange=$_GET['daterangepicker'];
	 		
	 			// validates user input 
	 			if($datefilter->validate()) {
	 				$start = ($datefilter->startdateTS ? date("Y-m-d", $datefilter->startdateTS) : false);
	 				$end = ($datefilter->enddateTS ? date("Y-m-d", ($datefilter->enddateTS)) : false); // + (24*60*60)
	 				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_INFO, '<strong>Dataset filtered by date:</strong> '.$start.' - '.$end);

	 				$this->redirect(array('/hosts/view', 'host'=>$host, 'start'=>$start, 'end'=>$end));
	 			} 
 			} else {
 				$this->redirect(array('/hosts/view', 'host'=>$host));
 			}
 		}

 		if ($start and $end) {
 			$datefilter->daterange= $start . ' - ' . $end;
 		}

		$model=Hosts::findByHost($host, $start, $end);
		if (!$model[0]['exists']) {
			throw new CHttpException(404,"The requested HOST (".$model[0]['name'].") does not exist.");
		} else {
			$this->render('view',array(
				'model'=>$model,
				'datefilter'=>$datefilter,
			));
		}
	}

}
