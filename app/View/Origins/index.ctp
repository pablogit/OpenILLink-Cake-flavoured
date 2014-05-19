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

	$this->set('title_for_layout', __('Gestion des provenances'));

	echo '<div class="manage_title">', __('Gestion des provenances du réseau'), '</div>';
	echo count($origins), ' ', __('provenance(s) trouvée(s)');
	echo '<div class="tableHeader">';
		echo '<div class="grid6">', __('Nom'), '</div>';
		echo '<div class="grid5">', __('Appartenance'), '</div>';
		echo '<div class="grid1">', __('Actions'), '</div>';
	echo '</div>';
	foreach ($origins as $origin)
	{
		echo '<div class="tableRow">';
			echo '<div class="grid6">', $origin['Origin']['name'], '</div>';
			echo '<div class="grid5">', (empty($origin['Library']['name'])? "Toutes les localisations":$origin['Library']['name']), '</div>';
			echo '<div class="grid1">', $this->Html->image('edit.png', array('url' => array('action' => 'edit', $origin['Origin']['id']))), " | ", $this->Form->postLink($this->Html->image('delete.png'), array('action' => 'delete', $origin['Origin']['id']), array('confirm' => __('Etes-vous sûr de vouloir supprimer la provenance "%s"?', h($origin['Origin']['name'])), 'escape' => false)), '</div>';
		echo '</div>';
	}

	echo '<div class="manage_footer">';
	echo $this->Html->link(__('Ajouter une nouvelle provenance'), array('controller' => 'origins', 'action' => 'create'), array('class' => 'btn'));
	echo '</div>';
?>