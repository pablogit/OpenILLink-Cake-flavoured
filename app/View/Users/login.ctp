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

	$this->set('title_for_layout', __('Connexion'));

	echo '<div class="manage_title">', __("Connexion"), '</div>';

	echo $this->Form->create('User', array('inputDefaults' => array('div' => false)));
	echo '<div class="tableRow">', $this->Form->input('login', array('label' => __('Identifiant').' : ')), '</div>';
	echo '<div class="tableRow">', $this->Form->input('password', array('label' => __('Mot de passe').' : ')), '</div>';

	echo '<div class="manage_footer">', $this->Form->button(__('Connexion'), array('class' => 'btn')), '</div>';
	echo $this->Form->end();

	if($config['Configuration']['is_shibboleth_active'])
	{
		echo '<div class="manage_title">', __("Authentification Shibboleth"), '</div>';
		$shibboleth_address = $config['Configuration']['shibboleth_url'] . '?entityID=' . $config['Configuration']['shibboleth_entity'] . '&return=' . $config['Configuration']['shibboleth_return'] . '&target=' . Router::url('/', true) . '/users/shibboleth';
		echo $this->Html->image('shibboleth.png', array('url' => $shibboleth_address));
	}
?>