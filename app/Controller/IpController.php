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

class IpController extends AppController
{
	public $uses = array('IpRange');

	/**************************************************************\
	|*                          Actions                           *|
	\**************************************************************/
	public function index()
	{
		$this->set('ranges', $this->IpRange->find('all'));
	}

	public function create()
	{
		if($this->request->is('post'))
		{
			$this->IpRange->create();
			if($this->IpRange->save($this->request->data))
			{
				$this->Session->setFlash(__('Nouvelle plage IP créée.'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('Erreur lors de la sauvegarde.'), 'default', array('class' => 'flash_error'));
			}
		}
	}

	public function edit($id)
	{	
		if (!$id) //No ID specified
			return $this->redirect(array('action' => 'index'));

		$iprange = $this->IpRange->findById($id);
		if (!$iprange) //No iprange with ID
			return $this->redirect(array('action' => 'index'));

		if ($this->request->is(array('post', 'put')))
		{
			$this->IpRange->id = $id;
			if ($this->IpRange->save($this->request->data))
			{
				$this->Session->setFlash(__('Modifications effectuées.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Impossible d\'effectuer les changements.'), 'default', array('class' => 'flash_error'));
		}

		if (!$this->request->data)
		{
			$this->request->data = $iprange;
		}
		if(!isset($this->request->data['IpRange']['id']))
		{
			$this->request->data['IpRange']['id'] = $id;
		}
	}

	public function delete($id)
	{
		if ($this->request->is('get'))
		{
			throw new MethodNotAllowedException();
		}

		$iprange = $this->IpRange->findById($id);
		if (!$iprange)
			return $this->redirect(array('action' => 'index'));

		if ($this->IpRange->delete($id))
		{
			$this->Session->setFlash(__('La plage IP "%s" a été supprimée.', h($iprange['IpRange']['name'])));
		}
		else
		{
			$this->Session->setFlash(__('Erreur lors de la suppression.'), 'default', array('class' => 'flash_error'));
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
}
?>