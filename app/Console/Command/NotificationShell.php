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
App::uses('CakeEmail', 'Network/Email');

class NotificationShell extends AppShell
{
	public $uses = array('Order', 'Configuration');

	public function main()
	{
		$result = $this->Order->find('all', array('conditions' => array('order_at >' => date('Y-m-d H:i:s', strtotime("5 minutes ago")), 'request_by' => 'publicform')));
		if(count($result) > 0)
			$this->sendNotification(count($result));
	}

	public function peb()
	{
		$result = $this->Order->find('all', array('conditions' => array('renew_at' => date('Y-m-d'), 'Status.special' => 'peb')));
		if(count($result) > 0)
			$this->sendPebNotification($result);		
	}

	private function sendNotification($nbNewOrders)
	{
		$config = $this->Configuration->find('first', array('fields' => array('library_email')));
		if(!empty($config['Configuration']['library_email']))
		{
			$email = new CakeEmail('default');
			$email->from(array('notification@openillink.org' => 'Notifications Openillink'))
				->to($config['Configuration']['library_email'])
				->subject(__('Nouvelle(s) demande de document'))
				->send(__("Vous avez %s nouvelle(s) demandes de documents sur OpenIllink.", $nbNewOrders));
		}
	}

	private function sendPebNotification($pendingPeb)
	{
		$config = $this->Configuration->find('first', array('fields' => array('library_email')));
		if(!empty($config['Configuration']['library_email']))
		{
			$email = new CakeEmail('default');
			$email->viewVars(array('pendingPeb' => $pendingPeb));
			$email->from(array('notification@openillink.org' => 'Notifications Openillink'))
				->to($config['Configuration']['library_email'])
				->subject(__('Rappel de PEB'))
				->template('pebNotification', 'default')
				->emailFormat('html')
				->send();
		}
	}
}

?>