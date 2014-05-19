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

class AdminController extends AppController
{
	public $uses = array('Configuration');

	/**************************************************************\
	|*                          Actions                           *|
	\**************************************************************/
	public function index()
	{
	}

	public function edit()
	{
		if ($this->request->is(array('post', 'put')))
		{
			$this->Configuration->id = 1;
			if ($this->Configuration->save($this->request->data))
			{
				$this->Session->setFlash(__('Modifications effectuées.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Impossible d\'effectuer les changements.'), 'default', array('class' => 'flash_error'));
		}

		$configuration = $this->Configuration->find('first');

		if (!$this->request->data)
		{
			$this->request->data = $configuration;
		}
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
}