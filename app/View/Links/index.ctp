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

	$this->set('title_for_layout', __('Gestion des liens sortants'));

	echo '<div class="manage_title">', __('Gestion des liens sortants'), '</div>';
	echo count($links), ' ', __('lien(s) trouvé(s)');
	echo '<div class="tableHeader">';
		echo '<div class="grid2">', __('Nom'), '</div>';
		echo '<div class="grid2">', __('URL'), '</div>';
		echo '<div class="grid2">', __('Recherche par'), '</div>';
		echo '<div class="grid2">', __('Formulaire de commande'), '</div>';
		echo '<div class="grid2">', __('Bibliothèque'), '</div>';
		echo '<div class="grid1">', __('Actif'), '</div>';
		echo '<div class="grid1">', __('Actions'), '</div>';
	echo '</div>';
	foreach ($links as $link)
	{
		$fields = array('issn' => __('ISSN'), 'isbn' => __('ISBN'), 'pmid' => __('PMID'), 'ptitle' => __('Titre du périodique'), 'btitle' => __('Titre du livre'), 'atitle' => __('Titre de l\'article'));
		$search_by = '';
		foreach ($fields as $field => $label)
		{
			if($link['Link']['is_search_'.$field] == '1')
			{
				$search_by .= (empty($search_by)?'':'; ') . $label;
			}
		}
		$library = ($link['Link']['library_id'] == '0'? 'Toutes' : $link['Library']['name']);
		$library = (strlen($library) > 13? substr($library, 0, 10).'...':$library);

		$url = (strlen($link['Link']['url']) > 20? substr($link['Link']['url'], 0, 17).'...':$link['Link']['url']);

		echo '<div class="tableRow">';
			echo '<div class="grid2">', $link['Link']['title'], '</div>';
			echo '<div class="grid2">', $url, '</div>';
			echo '<div class="grid2">', $search_by, '</div>';
			echo '<div class="grid2">', ($link['Link']['is_order_ext'] == '1'? 'Externe' : ($link['Link']['is_order_form'] == '1'? 'Interne' : '')), '</div>';
			echo '<div class="grid2">', $library, '</div>';
			echo '<div class="grid1">', $link['Link']['is_active'], '</div>';
			echo '<div class="grid1">', $this->Html->image('edit.png', array('url' => array('action' => 'edit', $link['Link']['id']))), " | ", $this->Form->postLink($this->Html->image('delete.png'), array('action' => 'delete', $link['Link']['id']), array('confirm' => __('Etes-vous sûr de vouloir supprimer le lien "%s"?', h($link['Link']['title'])), 'escape' => false)), '</div>';
		echo '</div>';
	}

	echo '<div class="manage_footer">';
	echo $this->Html->link(__('Ajouter un nouveau lien'), array('controller' => 'links', 'action' => 'create'), array('class' => 'btn'));
	echo '</div>';
?>