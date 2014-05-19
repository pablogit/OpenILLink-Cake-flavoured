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

class OriginsController extends AppController
{
	/**************************************************************\
	|*                          Actions                           *|
	\**************************************************************/
	public function index()
	{
		$this->set('origins', $this->Origin->find('all', array('order' => array('Origin.library_id ASC'))));
	}

	public function create()
	{
		if($this->request->is('post'))
		{
			$this->Origin->create();
			if($this->Origin->save($this->request->data))
			{
				$this->Session->setFlash(__('Nouvelle provenance créée.'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('Erreur lors de la sauvegarde. Assurez-vous que la combinaison nom / bibliothèque d\'attribution soit unique.'), 'default', array('class' => 'flash_error'));
			}
		}

		$this->set('libraries', $this->Origin->getLibrariesOptions());
	}

	public function edit($id)
	{
		if (!$id) //No ID specified
			return $this->redirect(array('action' => 'index'));

		$origin = $this->Origin->findById($id);
		if (!$origin) //No library with ID
			return $this->redirect(array('action' => 'index'));

		if ($this->request->is(array('post', 'put')))
		{
			$this->Origin->id = $id;
			if ($this->Origin->save($this->request->data))
			{
				$this->Session->setFlash(__('Modifications effectuées.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Impossible d\'effectuer les changements.'), 'default', array('class' => 'flash_error'));
		}

		if (!$this->request->data)
		{
			$this->request->data = $origin;
		}
		if(!isset($this->request->data['Origin']['id']))
		{
			$this->request->data['Origin']['id'] = $id;
		}

		$this->set('libraries', $this->Origin->getLibrariesOptions());
	}

	public function delete($id)
	{
		if ($this->request->is('get'))
		{
			throw new MethodNotAllowedException();
		}

		$origin = $this->Origin->findById($id);
		if (!$origin)
			return $this->redirect(array('action' => 'index'));

		if ($this->Origin->delete($id))
		{
			$this->Session->setFlash(__('La provenance "%s" a été supprimée.', h($origin['Origin']['name'])));
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