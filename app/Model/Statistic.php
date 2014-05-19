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

class Statistic extends AppModel
{
	public function getAverageResponseTime($from, $to)
	{
		$query = "SELECT COALESCE(SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(orders.sent_at, orders.order_at)))), 0)
					FROM `orders`
					WHERE `orders`.`sent_at` IS NOT NULL AND orders.sent_at BETWEEN '$from' AND '$to'";
		$result = $this->query($query);
		return array_pop($result[0][0]);
	}

	public function nbOrderByServiceAndOrigin($origins, $services, $from, $to)
	{
		$headers = array(__('Provenance'));
		$result = array();
		foreach ($origins as $originId => $originName)
		{
			$nbOrderForOrigin = $this->getNbOrderForOriginId($originId, $from, $to);
			$sum = 0;
			foreach ($nbOrderForOrigin as $valueForService)
			{
				$sum += $valueForService;
			}
			$nbOrderForOrigin[] = $sum;
			$result[] = array($originName) + $nbOrderForOrigin;
		}

		$result[] = array(__('Total par service')) + $this->getTotalPerService($from, $to);

		$this->Order = ClassRegistry::init('Order');
		$total = $this->Order->find('count', array('conditions' => array("DATE(Order.order_at) BETWEEN ? AND ?" => array($from, $to), 'Order.library_id' => AuthComponent::user('library_id'))));
		$result[] = array(__('Total du mois'), $total);

		foreach ($services as $service)
		{
			$name = "";
			if(!empty($service['Service']['department']))
				$name = '(' . $service['Service']['department'];
			if(!empty($service['Service']['faculty']))
			{
				$name .= (empty($name)? "(" : " / ") . $service['Service']['faculty'];
			}
			if(!empty($name))
				$name .= ')';
			
			$name = $service['Service']['name'] . $name;

			$headers[] = $name;
		}
		$headers[] = __('Total par provenance');

		return array($headers, $result);
	}

	private function getNbOrderForOriginId($originId, $from, $to)
	{
		$userLibrary = AuthComponent::user('library_id');
		$query = "SELECT services.id, Count(orders.id) as nb_order 
					FROM orders RIGHT JOIN services ON orders.service_id=services.id and orders.origin_id='".$originId."' and orders.library_id=".$userLibrary.
					" and DATE(orders.order_at) BETWEEN '$from' AND '$to' GROUP BY services.id";
		$result = $this->query($query);
		return $this->flatNbOrderForOriginId($result);
	}

	private function getTotalPerService($from, $to)
	{
		$userLibrary = AuthComponent::user('library_id');
		$query = "SELECT services.id, Count(orders.id) as nb_order 
					FROM orders RIGHT JOIN services ON orders.service_id=services.id and orders.library_id=".$userLibrary.
					" and DATE(orders.order_at) BETWEEN '$from' AND '$to' GROUP BY services.id";
		$result = $this->query($query);
		return $this->flatNbOrderForOriginId($result);
	}

	private function flatNbOrderForOriginId($result)
	{
		$flat_array = array();
		foreach ($result as $serviceRow)
		{
			$flat_array[$serviceRow['services']['id']] = $serviceRow['0']['nb_order'];
		}

		return $flat_array;
	}
}
?>