<?php

/**
 * This is the model class for "Hosts".
 *
 * The followings are the available columns in table 'SystemEvents':
 * @property string $ID
 * @property string $CustomerID
 * @property string $ReceivedAt
 * @property string $DeviceReportedTime
 * @property integer $Facility
 * @property integer $Priority
 * @property string $FromHost
 * @property string $Message
 * @property integer $NTSeverity
 * @property integer $Importance
 * @property string $EventSource
 * @property string $EventUser
 * @property integer $EventCategory
 * @property integer $EventID
 * @property string $EventBinaryData
 * @property integer $MaxAvailable
 * @property integer $CurrUsage
 * @property integer $MinUsage
 * @property integer $MaxUsage
 * @property integer $InfoUnitID
 * @property string $SysLogTag
 * @property string $EventLogType
 * @property string $GenericFileName
 * @property integer $SystemID
 */
class Hosts
{
	public function listHosts()
	{
		$tbl_logs = Yii::app()->params['TBL_name'];

		$stats = array();		

		$stats['date'] = date(DATE_RFC822);
		//$stats['totalLogs'] = Logs::model()->count();

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
            ->from($tbl_logs)
            ->queryAll();

		return $stats;
	}

	public function findByHost($host, $start=false, $end=false)
	{
		$tbl_logs = Yii::app()->params['TBL_name'];

		$model = array();

		$my_sql = "SELECT EXISTS(SELECT 1 FROM $tbl_logs WHERE FromHost='$host' LIMIT 1) as 'exists'";
		$model = Yii::app()->db->createCommand($my_sql)->queryAll();
		
		$model[0]['name'] = $host;

		if ($model[0]['exists']) {

			if ($start and $end) {
				$daterange = "and (ReceivedAt BETWEEN '$start' AND '$end 23:59:59')";
				if ($start != $end) {
					$model[0]['daterange'] = $start.' - '.$end;
				} else {
					$model[0]['daterange'] = $start;
				}
			} else {
				$daterange = '';
				$model[0]['daterange'] = 'TOTAL';
			}


			$my_sql = "SELECT count(*) as total
						FROM $tbl_logs
						WHERE FromHost='$host'$daterange";
			$my_sql = Yii::app()->db->createCommand($my_sql)->queryAll();
			$model[0]['total'] = $my_sql[0]['total'];

			$my_sql = "SELECT
							SUM(Priority = 0) as '0',
							SUM(Priority = 1) as '1',
							SUM(Priority = 2) as '2',
							SUM(Priority = 3) as '3',
							SUM(Priority = 4) as '4',
							SUM(Priority = 5) as '5',
							SUM(Priority = 6) as '6',
							SUM(Priority = 7) as '7'
	    				FROM $tbl_logs
	    				WHERE FromHost='$host'$daterange";
			$model['host_severities_table'] = Yii::app()->db->createCommand($my_sql)->queryAll();

			$my_sql = "SELECT count(*) as value, Facility
						FROM $tbl_logs
						WHERE FromHost='$host'$daterange
	    				GROUP BY Facility
						ORDER BY value DESC";						
			$model['host_facilities'] = Yii::app()->db->createCommand($my_sql)->queryAll();
			foreach ($model['host_facilities'] as &$value) {
					$value['label'] = Helpers::getFacility($value['Facility']);
				}
			unset($value);

			$my_sql = "SELECT count(*) as value, Priority as label
						FROM $tbl_logs
						WHERE FromHost='$host'$daterange
						GROUP BY label";

			$model['host_severities'] = Yii::app()->db->createCommand($my_sql)->queryAll();
			
			$model['severity_colors'] = array();
			foreach ($model['host_severities'] as &$value) {
				$value['color'] = Helpers::getSeverityColor($value['label']);
				array_push($model['severity_colors'], Helpers::getMorrisColors($value['label']));
				$value['label'] = Helpers::getSeverity($value['label']);			
			}
			unset($value);

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
							WHERE FromHost='$host'$daterange
							GROUP BY logdate
							ORDER BY logdate DESC
						) tmp ORDER BY logdate ASC";
			$model['severities_daily'] = Yii::app()->db->createCommand($my_sql)->queryAll();

			$my_sql = "SELECT *
					FROM (SELECT
							DATE(ReceivedAt) AS logdate,
							COUNT(*)Total,
							SUM(Facility = 0)".Helpers::getFacility(0).",
							SUM(Facility = 1)".Helpers::getFacility(1).",
							SUM(Facility = 2)".Helpers::getFacility(2).",
							SUM(Facility = 3)".Helpers::getFacility(3).",
							SUM(Facility = 4)".Helpers::getFacility(4).",
							SUM(Facility = 5)".Helpers::getFacility(5).",
							SUM(Facility = 6)".Helpers::getFacility(6).",
							SUM(Facility = 7)".Helpers::getFacility(7).",
							SUM(Facility = 8)".Helpers::getFacility(8).",
							SUM(Facility = 9)".Helpers::getFacility(9).",
							SUM(Facility = 10)".Helpers::getFacility(10).",
							SUM(Facility = 11)".Helpers::getFacility(11).",
							SUM(Facility = 12)".Helpers::getFacility(12).",
							SUM(Facility = 13)".Helpers::getFacility(13).",
							SUM(Facility = 14)".Helpers::getFacility(14).",
							SUM(Facility = 15)".Helpers::getFacility(15).",
							SUM(Facility = 16)".Helpers::getFacility(16).",
							SUM(Facility = 17)".Helpers::getFacility(17).",
							SUM(Facility = 18)".Helpers::getFacility(18).",
							SUM(Facility = 19)".Helpers::getFacility(19).",
							SUM(Facility = 20)".Helpers::getFacility(20).",
							SUM(Facility = 21)".Helpers::getFacility(21).",
							SUM(Facility = 22)".Helpers::getFacility(22).",
							SUM(Facility = 23)".Helpers::getFacility(23)."
							FROM $tbl_logs
						WHERE FromHost='$host'$daterange
						GROUP BY logdate
						ORDER BY logdate DESC
					) tmp ORDER BY logdate ASC";
			$model['facilities_daily'] = Yii::app()->db->createCommand($my_sql)->queryAll();
		}

		return $model;
	}

}
