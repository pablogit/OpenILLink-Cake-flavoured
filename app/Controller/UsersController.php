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

class UsersController extends AppController
{
	/**************************************************************\
	|*                          Actions                           *|
	\**************************************************************/
	public function index()
	{
		$this->set('users', $this->User->find('all', array('order' => 'User.name ASC')));
	}

	public function create()
	{
		if($this->request->is('post'))
		{
			$this->User->create();
			if($this->User->save($this->request->data))
			{
				$this->Session->setFlash(__('Nouvel utilisateur créé.'));
				return $this->redirect(array('action' => 'index'));
			}
		}

		$this->set('libraries', $this->User->Library->find('list', array('fields' => array('id', 'name'))));
	}

	public function edit($id)
	{
		if (!$id) //No ID specified
			return $this->redirect(array('action' => 'index'));

		$user = $this->User->findById($id);
		if (!$user) //No user with ID
			return $this->redirect(array('action' => 'index'));

		if ($this->request->is(array('post', 'put')))
		{
			$this->User->id = $id;
			if ($this->User->save($this->request->data))
			{
				$this->Session->setFlash(__('Modifications effectuées.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Impossible d\'effectuer les changements.'), 'default', array('class' => 'flash_error'));
		}

		if (!$this->request->data)
		{
			$this->request->data = $user;
		}
		if(!isset($this->request->data['User']['id']))
		{
			$this->request->data['User']['id'] = $id;
		}
		unset($this->request->data['User']['password']);

		$this->set('libraries', $this->User->Library->find('list', array('fields' => array('id', 'name'))));
	}

	public function delete($id)
	{
		if ($this->request->is('get'))
		{
			throw new MethodNotAllowedException();
		}

		$user = $this->User->findById($id);
		if (!$user)
			return $this->redirect(array('action' => 'index'));

		if ($this->User->delete($id))
		{
			$this->Session->setFlash(__('L\'utilisateur "%s" a été supprimé.', h($user['User']['name'])));
		}
		else
		{
			$this->Session->setFlash(__('Erreur lors de la suppression.'), 'default', array('class' => 'flash_error'));
		}

		return $this->redirect(array('action' => 'index'));
	}

	public function login()
	{
		if ($this->request->is('post'))
		{
			if ($this->Auth->login())
			{
				return $this->redirect($this->Auth->redirect());
			}
			else
			{
				$this->Session->setFlash(__("Identifiant ou mot de passe invalide."), 'default', array('class' => 'flash_error'));
			}
		}
	}

	public function logout()
	{
		return $this->redirect($this->Auth->logout());
	}

	public function shibboleth()
	{
		if ($this->Auth->login())
		{
			return $this->redirect($this->Auth->redirect());
		}
		else
		{
			$this->Session->setFlash(__("L'authentification Shibboleth a échouée"), 'default', array('class' => 'flash_error'));
			return $this->redirect(array('controller' => 'users', 'action' => 'login'));
		}
	}

	/**************************************************************\
	|*                       Authorization                        *|
	\**************************************************************/
	public function isAuthorized($user = null)
	{
		$admin_level = $this->Auth->user('admin_level');
		if($this->action === 'edit' || $this->action === 'delete')
		{
			$targetUser = $this->User->findById($this->request->params['pass']['0']);
			return ($admin_level == '1' || ($this->request->params['pass']['0'] == $this->Auth->user('id')) || $targetUser['User']['admin_level'] > $admin_level);
		}

		if($admin_level == '1' || $admin_level == '2')
		{
			return true;
		}

		// Default deny
		return false;
	}

	/**************************************************************\
	|*                         Callbacks                          *|
	\**************************************************************/
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('login', 'logout', 'shibboleth');
	}
}
?>