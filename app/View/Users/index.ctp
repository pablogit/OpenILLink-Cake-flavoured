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

	$this->set('title_for_layout', __('Gestion des utilisateurs'));

	$admin_levels = array(
		'1' => 'Super administrateur',
		'2' => 'Administrateur',
		'3' => 'Collaborateur',
		'9' => 'Invité');

	echo '<div class="manage_title">', __('Gestion des utilisateurs'), '</div>';
	echo count($users), ' ', __('utilisateur(s) trouvée(s)');
	echo '<div class="tableHeader">';
		echo '<div class="grid3">', __('Nom'), '</div>';
		echo '<div class="grid3">', __('Bibliothèque'), '</div>';
		echo '<div class="grid2">', __('Login'), '</div>';
		echo '<div class="grid2">', __('Droits'), '</div>';
		echo '<div class="grid1">', __('Actif'), '</div>';
		echo '<div class="grid1">', __('Actions'), '</div>';
	echo '</div>';
	foreach ($users as $user)
	{
		echo '<div class="tableRow">';
			echo '<div class="grid3">', $user['User']['name'], '</div>';
			echo '<div class="grid3">', $user['Library']['name'], '</div>';
			echo '<div class="grid2">', $user['User']['login'], '</div>';
			echo '<div class="grid2">', $admin_levels[$user['User']['admin_level']], '</div>';
			echo '<div class="grid1">', $user['User']['is_active'], '</div>';
			echo '<div class="grid1">';
			if(AuthComponent::user('admin_level') == '1' || AuthComponent::user('id') == $user['User']['id'] || $user['User']['admin_level'] > AuthComponent::user('admin_level'))
			{
				echo $this->Html->image('edit.png', array('url' => array('action' => 'edit', $user['User']['id']))), " | ", $this->Form->postLink($this->Html->image('delete.png'), array('action' => 'delete', $user['User']['id']), array('confirm' => __('Etes-vous sûr de vouloir supprimer l\'utilisateur "%s"?', h($user['User']['name'])), 'escape' => false));
			}
			echo '</div>';
		echo '</div>';
	}

	echo '<div class="manage_footer">';
	echo $this->Html->link(__('Ajouter un nouvel utilisateur'), array('controller' => 'users', 'action' => 'create'), array('class' => 'btn'));
	echo '</div>';
?>