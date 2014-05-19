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

	$this->set('title_for_layout', __('Administration'));

	echo '<div class="manage_title">', __('Administration'), '</div>';

	$list = array();
	if(in_array(AuthComponent::user('admin_level'),  array('1', '2')))
	{
		$list = array(
			$this->Html->link(__('Gestion des utilisateurs'), array('controller' => 'users', 'action' => 'index')) => array(
				$this->Html->link(__('Créer un nouvel utilisateur'), array('controller' => 'users', 'action' => 'create')),
				$this->Html->link(__('Modifier mes codes d\'accès'), array('controller' => 'users', 'action' => 'edit', AuthComponent::user('id'))),
				),
			$this->Html->link(__('Gestion des bibliothèques'), array('controller' => 'libraries', 'action' => 'index')) => array(
				$this->Html->link(__('Créer une nouvelle bibliothèque'), array('controller' => 'libraries', 'action' => 'create'))
				),
			$this->Html->link(__('Gestion des provenances'), array('controller' => 'origins', 'action' => 'index')) => array(
				$this->Html->link(__('Créer une nouvelle provenance'), array('controller' => 'origins', 'action' => 'create'))
				),
			$this->Html->link(__('Gestion des statuts de commande'), array('controller' => 'status', 'action' => 'index')) => array(
				$this->Html->link(__('Créer un nouveau statut de commande'), array('controller' => 'status', 'action' => 'create'))
				),
			$this->Html->link(__('Gestion des unités/services'), array('controller' => 'services', 'action' => 'index')) => array(
				$this->Html->link(__('Créer une nouvelle unité/service'), array('controller' => 'services', 'action' => 'create'))
				),
			$this->Html->link(__('Gestion des liens sortants'), array('controller' => 'links', 'action' => 'index')) => array(
				$this->Html->link(__('Créer un nouveau lien sortant'), array('controller' => 'links', 'action' => 'create'))
				),
			$this->Html->link(__('Gestion des plages IP'), array('controller' => 'ip', 'action' => 'index')) => array(
				$this->Html->link(__('Créer une nouvelle plage IP'), array('controller' => 'ip', 'action' => 'create'))
				)
		);
	}
	else
	{
		$list = array(
			$this->Html->link(__('Modifier mes codes d\'accès'), array('controller' => 'users', 'action' => 'edit', AuthComponent::user('id')))
		);
	}

	if(AuthComponent::user('admin_level') == '1')
	{
		array_push($list, $this->Html->link(__('Gestion des variables du système'), array('controller' => 'admin', 'action' => 'edit')));
		array_push($list, $this->Html->link(__('Vider la boite poubelle'), array('controller' => 'orders', 'action' => 'emptyTrash')));
	}

	echo $this->Html->nestedList($list);
?>