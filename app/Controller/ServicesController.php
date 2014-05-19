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

class ServicesController extends AppController
{
	/**************************************************************\
	|*                          Actions                           *|
	\**************************************************************/
	public function index()
	{
		$this->set('services', $this->Service->find('all', array('order' => array('Service.name', 'Service.department'))));
	}

	public function create()
	{
		if($this->request->is('post'))
		{
			if(!empty($this->request->data['Service']['department_new']))
				$this->request->data['Service']['department'] = $this->request->data['Service']['department_new'];
			if(!empty($this->request->data['Service']['faculty_new']))
				$this->request->data['Service']['faculty'] = $this->request->data['Service']['faculty_new'];

			$this->Service->create();
			if($this->Service->save($this->request->data))
			{
				$this->Session->setFlash(__('Nouveau service créé.'));
				return $this->redirect(array('action' => 'index'));
			}
		}

		$this->setupSelectOptions();
	}

	public function edit($id)
	{
		if (!$id) //No ID specified
			return $this->redirect(array('action' => 'index'));

		$service = $this->Service->findById($id);

		if (!$service) //No service with ID
			return $this->redirect(array('action' => 'index'));

		if ($this->request->is(array('post', 'put')))
		{
			$this->Service->id = $id;
			if(!empty($this->request->data['Service']['department_new']))
				$this->request->data['Service']['department'] = $this->request->data['Service']['department_new'];
			if(!empty($this->request->data['Service']['faculty_new']))
				$this->request->data['Service']['faculty'] = $this->request->data['Service']['faculty_new'];

			if ($this->Service->save($this->request->data))
			{
				$this->Session->setFlash(__('Modifications effectuées.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Impossible d\'effectuer les changements.'), 'default', array('class' => 'flash_error'));
		}

		if (!$this->request->data)
		{
			$this->request->data = $service;
		}
		if(!isset($this->request->data['Service']['id']))
		{
			$this->request->data['Service']['id'] = $id;
		}

		$this->setupSelectOptions();
	}

	public function delete($id)
	{
		if ($this->request->is('get'))
		{
			throw new MethodNotAllowedException();
		}

		$service = $this->Service->findById($id);
		if (!$service)
			return $this->redirect(array('action' => 'index'));

		if ($this->Service->delete($id))
		{
			$this->Session->setFlash(__('Le service "%s" a été supprimé.', h($service['Service']['name'])));
		}
		else
		{
			$this->Session->setFlash(__('Erreur lors de la suppression du service'), 'default', array('class' => 'flash_error'));
		}

		return $this->redirect(array('action' => 'index'));
	}

	/**************************************************************\
	|*                       Authorization                        *|
	\**************************************************************/
	public function isAuthorized($user = null)
	{
		$admin_level = $this->Auth->user('admin_level');
		if($admin_level == '1' || $admin_level == '2')
		{
			return true;
		}

		// Default deny
		return false;
	}

	/**************************************************************\
	|*                      Private methods                       *|
	\**************************************************************/
	private function setupSelectOptions()
	{
		$libraries = $this->Service->Library->find('list', array('fields' => array('Library.id', 'Library.name')));
		$this->set('libraries', $libraries);

		$departments = $this->Service->find('list', array('fields' => array('Service.department', 'Service.department'), 'order' => 'Service.department', 'group' => 'Service.department'));
		$departments['new'] = __('Nouvelle valeur');
		$this->set('departments', $departments);

		$faculties = $this->Service->find('list', array('fields' => array('Service.faculty', 'Service.faculty'), 'order' => 'Service.faculty', 'group' => 'Service.faculty'));
		$faculties['new'] = __('Nouvelle valeur');
		$this->set('faculties', $faculties);

		$ipRanges = $this->Service->IpRange->find('list', array('fields' => array('IpRange.id', 'IpRange.name'), 'order' => array('IpRange.name ASC')));
		$this->set('ipranges', $ipRanges);
	}
}
?>