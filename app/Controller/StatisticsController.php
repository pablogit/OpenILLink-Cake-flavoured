<?php
// ***************************************************************************
// ***************************************************************************
// ***************************************************************************
// OpenIllink is a web based library system designed to manage 
// ILL, document delivery and OpenURL links
// 
// Copyright (C) 2014, Cyril Sester
// 
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
// 
// ***************************************************************************
// ***************************************************************************
// ***************************************************************************

class StatisticsController extends AppController
{
	public $uses = array('Statistic', 'Order', 'Origin', 'Service');
	public $components = array('CsvView.CsvView');

	/**************************************************************\
	|*                          Actions                           *|
	\**************************************************************/
	public function index()
	{
		$predefined_stats = array('pre_1' => __('Nombre de commande par service pour chaque provenance'), 'pre_2' => __('Temps moyen de traitement'));
		$personnalized_stats = array();//$this->Statistic->find('list', array('fields' => array('Statistic.id', 'Statistic.name')));

		$this->set('statOptions', array(__('Statistiques prédéfinies') => $predefined_stats, __('Statistiques personnalisées') => $personnalized_stats));

		$this->set('defaultFromDate', date('Y-m-d', strtotime('first day of this month', strtotime('yesterday'))));
		$this->set('defaultToDate', date('Y-m-d', strtotime('yesterday')));
	}

	public function generateFromSaved()
	{
		switch ($this->request->data['Statistics']['statName'])
		{
			case 'pre_1':
				$this->statServicePerOrigin();
				break;
			case 'pre_2':
				$this->statAverageResponseTime();
				break;
			default:
				# code...
				break;
		}
	}

	public function generateFromForm()
	{
		$fields = $this->request->data['Statistics']['fields'];
		$is_count = $this->request->data['Statistics']['is_count'];
		for($i = 0; $i < count($fields); $i++)
		{
			if($is_count[$i] === '1')
			{
				$name = str_replace(".", "", $fields[$i]);
				$fields[$i] = 'Count(' . $fields[$i] . ') AS nb_'.$name;
			}
		}

		$groupbys = $this->request->data['Statistics']['groupby'];

		$i = 0;
		while($i < count($groupbys))
		{
			if(empty($groupbys[$i]))
			{
				unset($groupbys[$i]);
				continue;
			}
			$i++;
		}

		$conditionsFields = $this->request->data['Statistics']['conditions'];
		$conditionsOperators = $this->request->data['Statistics']['operators'];
		$conditionsComparators = $this->request->data['Statistics']['comparators'];
		$where = array();

		for($i = 0; $i < count($conditionsFields); $i++)
		{
			if(!empty($conditionsFields[$i]) && !empty($conditionsComparators[$i]))
			{
				$operator = "";
				switch ($conditionsOperators[$i])
				{
					case 'different':
						$operator = " !=";
						break;
					case 'bigger':
						$operator = " >";
						break;
					case 'smaller':
						$operator = " <";
						break;
					default:
						$operator = "";
						break;
				}
				$where[$conditionsFields[$i].$operator] = $conditionsComparators[$i];
			}
		}

		$options = array('fields' => $fields);
		if(!empty($groupbys)) $options['group'] = $groupbys;
		if(!empty($where)) $options['conditions'] = $where;

		$results = $this->Order->find('all', $options);
		foreach ($results as $index => &$row)
		{
			$i = 0;
			while(isset($row[$i]))
			{
				$row['F'.$i] = $row[$i];

				$i++;
			}
		}
		unset($row);

		$this->CsvView->quickExport($results);
	}
	/**************************************************************\
	|*                       Authorization                        *|
	\**************************************************************/
	public function isAuthorized($user = null)
	{
		$admin_level = $this->Auth->user('admin_level');
		if($admin_level == '1' || $admin_level == '2' || $admin_level =='3')
		{
			if($this->action === 'edit')
			{
				return ($admin_level == '1');
			}
			else
				return true;
		}

		// Default deny
		return false;
	}

	/**************************************************************\
	|*                      Private methods                       *|
	\**************************************************************/
	private function statServicePerOrigin()
	{
		$origins = $this->Origin->find('list', array('fields' => array('Origin.id', 'Origin.name')));
		$services = $this->Service->find('all', array('fields' => array('Service.id', 'Service.name', 'Service.department', 'Service.faculty')));

		$from = $this->request->data['Statistics']['fromDate'];
		$to = date('Y-m-d', strtotime('last day of this month', strtotime($from)));
		$finalTo = $this->request->data['Statistics']['toDate'];
		$results = array();
		do
		{
			list($_header, $result) = $this->Statistic->nbOrderByServiceAndOrigin($origins, $services, $from, $to);
			array_push($results, array());
			array_push($results, array(__('Statistiques du %s au %s', $from, $to)));
			array_push($results, array('') + $_header);
			foreach ($result as $res)
			{
				array_push($results, $res);
			}

			$from = date('Y-m-d', strtotime('tomorrow', strtotime($to)));
			$to = date('Y-m-d', strtotime('last day of this month', strtotime($from)));
			if(strtotime($to) > strtotime($finalTo))
				$to = $finalTo;
		}
		while(strtotime($from) < strtotime($finalTo));
		$_serialize = 'results';

		$this->viewClass = 'CsvView.Csv';
		$this->set(compact('results', '_serialize'));
	}

	private function statAverageResponseTime()
	{

		$from = $this->request->data['Statistics']['fromDate'];
		$to = date('Y-m-d', strtotime('last day of this month', strtotime($from)));
		$finalTo = $this->request->data['Statistics']['toDate'];
		$results = array();
		do
		{
			$avgTimeForPeriod = $this->Statistic->getAverageResponseTime($from, $to);
			array_push($results, array(__('Temps moyen de traitement du %s au %s', $from, $to), $avgTimeForPeriod));

			$from = date('Y-m-d', strtotime('tomorrow', strtotime($to)));
			$to = date('Y-m-d', strtotime('last day of this month', strtotime($from)));
			if(strtotime($to) > strtotime($finalTo))
				$to = $finalTo;
		}
		while(strtotime($from) < strtotime($finalTo));

		$avgTimeForAllPeriod = $this->Statistic->getAverageResponseTime($this->request->data['Statistics']['fromDate'], $finalTo);
		array_push($results, array(__('Temps moyen de traitement pour toute la période'), $avgTimeForAllPeriod));

		$_serialize = 'results';

		$this->viewClass = 'CsvView.Csv';
		$this->set(compact('results', '_serialize'));
	}
}