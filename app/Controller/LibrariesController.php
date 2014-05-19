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

class LibrariesController extends AppController
{
	public $uses = array('Library');

	/**************************************************************\
	|*                          Actions                           *|
	\**************************************************************/
	public function index()
	{
		$this->set('libraries', $this->Library->find('all', array('order' => array('default DESC', 'name'))));
	}

	public function create()
	{
		if($this->request->is('post'))
		{
			$this->Library->create();
			if($this->Library->save($this->request->data))
			{
				$this->Session->setFlash(__('Nouvelle bibliothèque créée.'));
				return $this->redirect(array('action' => 'index'));
			}
		}
	}

	public function edit($id)
	{
		if (!$id) //No ID specified
			return $this->redirect(array('action' => 'index'));

		$library = $this->Library->findById($id);
		if (!$library) //No library with ID
			return $this->redirect(array('action' => 'index'));

		if ($this->request->is(array('post', 'put')))
		{
			$this->Library->id = $id;
			if ($this->Library->save($this->request->data))
			{
				$this->Session->setFlash(__('Modifications effectuées.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Impossible d\'effectuer les changements.'), 'default', array('class' => 'flash_error'));
		}

		if (!$this->request->data)
		{
			$this->request->data = $library;
		}
		if(!isset($this->request->data['Library']['id']))
		{
			$this->request->data['Library']['id'] = $id;
		}
	}

	public function delete($id)
	{
		if ($this->request->is('get'))
		{
			throw new MethodNotAllowedException();
		}

		$library = $this->Library->findById($id);
		if (!$library)
			return $this->redirect(array('action' => 'index'));

		if ($this->Library->delete($id))
		{
			$this->Session->setFlash(__('La bibliothèque "%s" a été supprimée.', h($library['Library']['name'])));
		}
		else
		{
			$this->Session->setFlash(__('Impossible de supprimer la bibliothèque. Vérifiez que ce ne soit pas celle par défaut.'), 'default', array('class' => 'flash_error'));
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