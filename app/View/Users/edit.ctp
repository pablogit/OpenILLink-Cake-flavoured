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

	$this->set('title_for_layout', __('Edition de l\'utilisateur "%s"', $this->request->data['User']['name']));

	echo '<div class="manage_title">', __("Gestion des utilisateurs : Édition de la fiche"), ' ', $this->request->data['User']['id'], '</div>';

	$admin_level_options = array();
	if(AuthComponent::user('admin_level') == '1')
	{
		$admin_level_options['1'] = __('Super administrateur');
		$admin_level_options['2'] = __('Administrateur');
	}
	if(AuthComponent::user('admin_level') == '2' && AuthComponent::user('id') == $this->request->data['User']['id'])
	{
		$admin_level_options['2'] = __('Administrateur');
	}
	$admin_level_options['3'] = __('Collaborateur');
	$admin_level_options['9'] = __('Invité');

	echo $this->Form->create('User', array('inputDefaults' => array('div' => false)));
	echo '<div class="tableRow">', $this->Form->input('name', array('label' => __('Nom').' : ')), '</div>';
	echo '<div class="tableRow">', $this->Form->input('email', array('label' => __('Email').' : ')), '</div>';
	echo '<div class="tableRow">', $this->Form->input('login', array('label' => __('Identifiant').' : ')), '</div>';
	echo '<div class="tableRow">', $this->Form->input('is_active', array('label' => __('Actif').' : ',  'format' => array('before', 'label', 'between', 'input', 'after', 'error' ))), '</div>';
	echo '<div class="tableRow">', $this->Form->input('admin_level', array('label' => __('Droits').' : ', 'options' => $admin_level_options)), '</div>';
	echo '<div class="tableRow">', $this->Form->input('library_id', array('label' => __('Bibliothèque d\'attache').' : ')), '</div>';
	echo '<div class="tableRow">', $this->Form->input('password', array('label' => __('Nouveau mot de passe').' : ')), '</div>';
	echo '<div class="tableRow">', $this->Form->input('password2', array('label' => __('Répéter nouveau mot de passe').' : ', 'type' => 'password')), '</div>';


	echo '<div class="manage_footer">';
		echo $this->Form->button(__('Enregistrer'), array('class' => 'btn'));
		echo $this->Html->link(__('Annuler'), array('controller' => 'users', 'action' => 'index'), array('class' => 'btn'));
		echo $this->Form->end();
		echo $this->Form->postlink(__('Supprimer'), array('action' => 'delete', $this->request->data['User']['id']), array('confirm' => __('Etes-vous sûr de vouloir supprimer l\'utilisateur "%s"?', h($this->request->data['User']['name'])), 'class' => 'btn'));
	echo '</div>';
?>