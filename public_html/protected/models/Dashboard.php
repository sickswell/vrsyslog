<?php

/**
 * This is the model class for "Dashboard".
 */
class Dashboard //extends CFormModel
{
	/**
	 * Collects and analyzes data for Dashboard visualization
	 */
	public function analize()
	{
		$tbl_logs = Yii::app()->params['TBL_name'];

		$stats = array();

		$stats['date'] = date(DATE_RFC822);
		$stats['totalLogs'] = Logs::model()->count();
	
		$stats['logs_facilities'] = Yii::app()->db->createCommand()
            ->select('count(*) as value, Facility as label')
            ->from($tbl_logs)
            ->group('label')
            ->queryAll();
		foreach ($stats['logs_facilities'] as &$value) {
			$value['label'] = Helpers::getFacility($value['label']);
		}
		unset($value);

 		$stats['severity_colors'] = array();
        $stats['logs_severities'] = Yii::app()->db->createCommand()
            ->select('count(*) as value, Priority as label')
            ->from(Logs::model()->tableName())
            ->group('label')
            ->queryAll();
		foreach ($stats['logs_severities'] as &$value) {
			$value['color'] = Helpers::getSeverityColor($value['label']);
			array_push($stats['severity_colors'], Helpers::getMorrisColors($value['label']));
			$value['label'] = Helpers::getSeverity($value['label']);			
		}
		unset($value);

		$stats['logs_severities_table'] = Yii::app()->db->createCommand()
            ->select("SUM(Priority = 0) as '0',
    				SUM(Priority = 1) as '1',
    				SUM(Priority = 2) as '2',
    				SUM(Priority = 3) as '3',
    				SUM(Priority = 4) as '4',
    				SUM(Priority = 5) as '5',
    				SUM(Priority = 6) as '6',
    				SUM(Priority = 7) as '7'")
            ->from(Logs::model()->tableName())
            ->queryAll();

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
		$stats['logs_daily'] = Yii::app()->db->createCommand($my_sql)->queryAll();

		$stats['hosts_table'] = Yii::app()->db->createCommand()
            ->select("FromHost, count(*) as Total,
					SUM(Priority = 0) as '0',
    				SUM(Priority = 1) as '1',
    				SUM(Priority = 2) as '2',
    				SUM(Priority = 3) as '3',
    				SUM(Priority = 4) as '4',
    				SUM(Priority = 5) as '5',
    				SUM(Priority = 6) as '6',
    				SUM(Priority = 7) as '7'
            	")
			//->where('FromHost=:FromHost', array(':FromHost'=>'Test_host'))
			->group('FromHost')
			->order('Total DESC')
			->limit(8)
            ->from($tbl_logs)
            ->queryAll();

		return $stats;
	}

}
