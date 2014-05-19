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

	$this->set('title_for_layout', __('Création d\'une nouvelle plage IP'));

	echo '<div class="manage_title">', __("Gestion des plages IP : Création d'une nouvelle fiche"), '</div>';

	echo $this->Form->create('IpRange', array('inputDefaults' => array('div' => false)));
	echo '<div class="tableRow">', $this->Form->input('name', array('label' => __('Nom').' : ')), '</div>';
	echo '<div class="tableRow">', $this->Form->input('mask', array('label' => __('Masque réseau').' : ')), '</div>';

	echo '<div class="manage_footer">', $this->Form->button(__('Enregistrer la nouvelle plage IP'), array('class' => 'btn')), $this->Html->link(__('Annuler'), array('action' => 'index'), array('class' => 'btn')), '</div>';
	echo $this->Form->end();
?>