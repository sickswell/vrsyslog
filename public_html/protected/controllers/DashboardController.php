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
		$tbl_logs = Logs::model()->tableName();

		$stats['date'] = date(DATE_RFC822);
		$stats['totalLogs'] = Logs::model()->count();
	
		$logs_facilities = Yii::app()->db->createCommand()
            ->select('count(*) as value, Facility as label')
            ->from($tbl_logs)
            ->group('label')
            ->queryAll();
		foreach ($logs_facilities as &$value) {
			$value['label'] = Helpers::getFacility($value['label']);
		}
		unset($value);

 		$severity_colors = array();
        $logs_severities  = Yii::app()->db->createCommand()
            ->select('count(*) as value, Priority as label')
            ->from(Logs::model()->tableName())
            ->group('label')
            ->queryAll();
		foreach ($logs_severities as &$value) {
			$value['color'] = Helpers::getSeverityColor($value['label']);
			array_push($severity_colors, Helpers::getMorrisColors($value['label']));
			$value['label'] = Helpers::getSeverity($value['label']);			
		}
		unset($value);

		$my_sql = "SELECT
    				SUM(Priority = 0) as '0',
    				SUM(Priority = 1) as '1',
    				SUM(Priority = 2) as '2',
    				SUM(Priority = 3) as '3',
    				SUM(Priority = 4) as '4',
    				SUM(Priority = 5) as '5',
    				SUM(Priority = 6) as '6',
    				SUM(Priority = 7) as '7'
					FROM $tbl_logs";
		$logs_severities_table = Yii::app()->db->createCommand($my_sql)->queryAll();

		$my_sql = "SELECT *
				FROM (SELECT
					DATE(ReceivedAt) AS logdate,
					COUNT(*)Total,
    				SUM(Priority = 0)".Helpers::getSeverity(0).",
    				SUM(Priority = 1)".Helpers::getSeverity(1).",
    				SUM(Priority = 2)".Helpers::getSeverity(2).",
    				SUM(Priority = 3)".Helpers::getSeverity(3).",
    				SUM(Priority = 4)".Helpers::getSeverity(4).",
    				SUM(Priority = 5)".Helpers::getSeverity(5).",
    				SUM(Priority = 6)".Helpers::getSeverity(6).",
    				SUM(Priority = 7)".Helpers::getSeverity(7)."
					FROM $tbl_logs
					GROUP BY logdate
					ORDER BY logdate DESC
					LIMIT 10
				) tmp ORDER BY logdate ASC";
		$logs_daily = Yii::app()->db->createCommand($my_sql)->queryAll();

		$this->render('dashboard', array(
			'stats'=>$stats,
			'logs_facilities'=>$logs_facilities,
			'logs_severities'=>$logs_severities,
			'severity_colors'=>$severity_colors,
			'logs_severities_table'=>$logs_severities_table,
			'logs_daily'=>$logs_daily,
			)
		);
	}
}
