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

class StatusController extends AppController
{
	public $uses = array('Status');

	/**************************************************************\
	|*                          Actions                           *|
	\**************************************************************/
	public function index()
	{
		$this->set('status', $this->Status->find('all'));
	}

	public function create()
	{
		if($this->request->is('post'))
		{
			$this->Status->create();
			if($this->Status->save($this->request->data))
			{
				$this->Session->setFlash(__('Nouveau statut créé.'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('Impossible de créer le nouveau statut. Assurez-vous que le nom du statut soit unique.'), 'default', array('class' => 'flash_error'));
			}
		}

		$this->set('special_states', $this->Status->getSpecialStates());
	}

	public function edit($id)
	{
		if (!$id) //No ID specified
			return $this->redirect(array('action' => 'index'));

		$status = $this->Status->findById($id);
		if (!$status) //No status with ID
			return $this->redirect(array('action' => 'index'));

		if ($this->request->is(array('post', 'put')))
		{
			$this->Status->id = $id;

			if ($this->Status->save($this->request->data))
			{
				$this->Session->setFlash(__('Modifications effectuées.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Impossible d\'effectuer les changements. Assurez-vous que le nom du statut soit unique.'), 'default', array('class' => 'flash_error'));
		}

		if (!$this->request->data)
		{
			$this->request->data = $status;
		}
		if(!isset($this->request->data['Status']['id']))
		{
			$this->request->data['Status']['id'] = $id;
		}

		$this->set('special_states', $this->Status->getSpecialStates());
	}

	public function delete($id)
	{
		if ($this->request->is('get'))
		{
			throw new MethodNotAllowedException();
		}

		$status = $this->Status->findById($id);
		if (!$status)
			return $this->redirect(array('action' => 'index'));

		if ($this->Status->delete($id))
		{
			$this->Session->setFlash(__('Le statut "%s" a été supprimé.', h($status['Status']['title'])));
		}
		else
		{
			$this->Session->setFlash(__('Erreur lors de la suppression du statut'), 'default', array('class' => 'flash_error'));
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