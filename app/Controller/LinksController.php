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

class LinksController extends AppController
{
	/**************************************************************\
	|*                          Actions                           *|
	\**************************************************************/
	public function index()
	{
		$this->set('links', $this->Link->find('all', array('order' => array('Link.title ASC'))));
	}

	public function create()
	{
		if($this->request->is('post'))
		{
			$this->Link->create();
			if($this->Link->save($this->request->data))
			{
				$this->Session->setFlash(__('Nouveau lien créé.'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('Erreur lors de la sauvegarde.'), 'default', array('class' => 'flash_error'));
			}
		}

		$this->set('libraries', $this->Link->getLibrariesOptions());
	}

	public function edit($id)
	{	
		if (!$id) //No ID specified
			return $this->redirect(array('action' => 'index'));

		$link = $this->Link->findById($id);
		if (!$link) //No library with ID
			return $this->redirect(array('action' => 'index'));

		if ($this->request->is(array('post', 'put')))
		{
			$this->Link->id = $id;
			if ($this->Link->save($this->request->data))
			{
				$this->Session->setFlash(__('Modifications effectuées.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Impossible d\'effectuer les changements.'), 'default', array('class' => 'flash_error'));
		}

		if (!$this->request->data)
		{
			$this->request->data = $link;
		}
		if(!isset($this->request->data['Link']['id']))
		{
			$this->request->data['Link']['id'] = $id;
		}

		$this->set('libraries', $this->Link->getLibrariesOptions());
	}

	public function delete($id)
	{
		if ($this->request->is('get'))
		{
			throw new MethodNotAllowedException();
		}

		$link = $this->Link->findById($id);
		if (!$link)
			return $this->redirect(array('action' => 'index'));

		if ($this->Link->delete($id))
		{
			$this->Session->setFlash(__('Le lien "%s" a été supprimé.', h($link['Link']['title'])));
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