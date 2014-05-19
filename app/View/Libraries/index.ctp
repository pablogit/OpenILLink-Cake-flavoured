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

	$this->set('title_for_layout', __('Gestion des bibliothèques'));

	echo '<div class="manage_title">', __('Gestion des bibliothèques du réseau'), '</div>';
	echo count($libraries), ' ', __('bibliothèque(s) trouvée(s)');
	echo '<div class="tableHeader">';
		echo '<div class="grid9">', __('Nom'), '</div>';
		echo '<div class="grid2">', __('Défaut'), '</div>';
		echo '<div class="grid1">', __('Actions'), '</div>';
	echo '</div>';
	foreach ($libraries as $library)
	{
		echo '<div class="tableRow">';
			echo '<div class="grid9">', $library['Library']['name'], '</div>';
			echo '<div class="grid2">', ($library['Library']['default'] == 1? __('Oui') : __('Non')), '</div>';
			echo '<div class="grid1">', $this->Html->image('edit.png', array('url' => array('action' => 'edit', $library['Library']['id']))), " | ", $this->Form->postLink($this->Html->image('delete.png'), array('action' => 'delete', $library['Library']['id']), array('confirm' => __('Etes-vous sûr de vouloir supprimer la bibliothèque "%s"?', h($library['Library']['name'])), 'escape' => false)), '</div>';
		echo '</div>';
	}

	echo '<div class="manage_footer">';
	echo $this->Html->link(__('Ajouter une nouvelle bibliothèque'), array('controller' => 'libraries', 'action' => 'create'), array('class' => 'btn'));
	echo '</div>';
?>