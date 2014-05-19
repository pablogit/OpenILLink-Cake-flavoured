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

	$this->set('title_for_layout', __('Création d\'un nouveau service'));

	echo '<div class="manage_title">', __("Gestion des services : Création d'une nouvelle fiche"), '</div>';

	echo $this->Form->create('Service', array('inputDefaults' => array('div' => false)));
	echo '<div class="tableRow">', $this->Form->input('name', array('label' => __('Nom').' : ')), '</div>';
	echo '<div class="tableRow">', $this->Form->input('library_id', array('label' => __('Attaché à la bibliothèque').' : ', 'options' => $libraries)), '</div>';
	echo '<div class="tableRow">';
		echo $this->Form->input('department', array('label' => __('Département').' : ', 'options' => $departments, 'empty' => '', 'onchange' => 'valueChanged(\'ServiceDepartment\');'));
		echo $this->Form->input('department_new', array('label' => false));
	echo '</div>';
	echo '<div class="tableRow">';
		echo $this->Form->input('faculty', array('label' => __('Faculté').' : ', 'options' => $faculties, 'empty' => '', 'onchange' => 'valueChanged(\'ServiceFaculty\');'));
		echo $this->Form->input('faculty_new', array('label' => false));
	echo '</div>';
	echo '<div class="tableRow">', $this->Form->input('IpRange', array('label' => __('Affichage selon IP'), 'options' => $ipranges, 'multiple' => true)), '</div>';
	echo '<div class="tableRow">', $this->Form->input('need_validation', array('label' => __('A valider par la bibliothèque').' : ', 'format' => array('before', 'label', 'between', 'input', 'after', 'error' ))), '</div>';

	echo '<div class="manage_footer">', $this->Form->button(__('Enregistrer le nouveau service'), array('class' => 'btn')), $this->Html->link(__('Annuler'), array('controller' => 'services', 'action' => 'index'), array('class' => 'btn')), '</div>';
	echo $this->Form->end();
?>