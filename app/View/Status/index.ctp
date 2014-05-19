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

	$this->set('title_for_layout', __('Gestion des statuts'));

	echo '<div class="manage_title">', __('Gestion des statuts des commandes'), '</div>';
	echo count($status), ' ', __('statuts trouvés');
	echo '<div class="tableHeader">';
		echo '<div class="grid3">', __('Nom'), '</div>';
		echo '<div class="grid5">', __('Description'), '</div>';
		echo '<div class="grid1">', __('Dossier'), '</div>';
		echo '<div class="grid2">', __('Statut spécial'), '</div>';
		echo '<div class="grid1">', __('Actions'), '</div>';
	echo '</div>';
	foreach ($status as $state)
	{
		echo '<div class="tableRow">';
			echo '<div class="grid3"><font color="', $state['Status']['color'], '">', $state['Status']['title'], '</font></div>';
			echo '<div class="grid5">', $state['Status']['help'], '</div>';
			echo '<div class="grid1">', $state['Status']['is_visible_in_box'], '</div>';
			echo '<div class="grid2">', $state['Status']['special'], '</div>';
			echo '<div class="grid1">', $this->Html->image('edit.png', array('url' => array('action' => 'edit', $state['Status']['id']))), " | ", $this->Form->postLink($this->Html->image('delete.png'), array('action' => 'delete', $state['Status']['id']), array('confirm' => __('Etes-vous sûr de vouloir supprimer le statut "%s"?', h($state['Status']['title'])), 'escape' => false)), '</div>';
		echo '</div>';
	}

	echo '<div class="manage_footer">';
	echo $this->Html->link(__('Ajouter un nouveau statut'), array('controller' => 'status', 'action' => 'create'), array('class' => 'btn'));
	echo '</div>';
?>