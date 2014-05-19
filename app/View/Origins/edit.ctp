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

	$this->set('title_for_layout', __('Édition de la provenance "%s"', h($this->request->data['Origin']['name'])));

	echo '<div class="manage_title">', __("Gestion des provenances : Édition de la fiche"), ' ', $this->request->data['Origin']['id'], '</div>';

	echo $this->Form->create('Origin', array('inputDefaults' => array('div' => false)));
	echo '<div class="tableRow">', $this->Form->input('name', array('label' => __('Nom').' : ')), '</div>';
	echo '<div class="tableRow">', $this->Form->input('library_id', array('label' => __('Bibliothèque d\'attribution').' : ', 'options' => $libraries)), '</div>';

	echo '<div class="manage_footer">';
		echo $this->Form->button(__('Enregistrer les modifications'), array('class' => 'btn'));
		echo $this->Html->link(__('Annuler'), array('controller' => 'origins', 'action' => 'index'), array('class' => 'btn'));
		echo $this->Form->end();
		echo $this->Form->postlink(__('Supprimer'), array('action' => 'delete', $this->request->data['Origin']['id']), array('confirm' => __('Etes-vous sûr de vouloir supprimer la provenance "%s"?', h($this->request->data['Origin']['name'])), 'class' => 'btn'));
	echo '</div>';
?>