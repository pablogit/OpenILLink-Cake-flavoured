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

	$this->set('title_for_layout', __('Édition du lien sortant "%s"', $this->request->data['Link']['title']));

	echo '<div class="manage_title">', __("Gestion des liens sortants : Édition de la fiche"), ' ', $this->request->data['Link']['id'], '</div>';

	echo $this->Form->create('Link', array('inputDefaults' => array('div' => false)));
	echo '<div class="tableRow">', $this->Form->input('title', array('label' => __('Titre').' : ')), '</div>';
	echo '<div class="tableRow">', $this->Form->input('url', array('label' => __('URL').' : ')), $this->Form->input('is_openurl', array('label' => __('OpenURL'))), '</div>';
	echo '<div class="tableRow">',
		'<label>', __('Lien de recherche par identifiant'), '</label>', 
		$this->Form->input('is_search_issn', array('label' => array('text' => __('ISSN'), 'class' => 'checkbox-label'))), 
		$this->Form->input('is_search_isbn', array('label' => array('text' => __('ISBN'), 'class' => 'checkbox-label'))), 
		$this->Form->input('is_search_pmid', array('label' => array('text' => __('PMID'), 'class' => 'checkbox-label'))), 
		'</div>';
	echo '<div class="tableRow">',
		'<label>', __('Lien de recherche par titre'), '</label>', 
		$this->Form->input('is_search_ptitle', array('label' => array('text' => __('de périodique'), 'class' => 'checkbox-label'))), 
		$this->Form->input('is_search_btitle', array('label' => array('text' => __('du livre'), 'class' => 'checkbox-label'))), 
		$this->Form->input('is_search_atitle', array('label' => array('text' => __('Titre d\'article ou de chapitre'), 'class' => 'checkbox-label'))), 
		'</div>';
	echo '<div class="tableRow">',
		'<label>', __('Lien de commande'), '</label>', 
		$this->Form->input('is_order_ext', array('label' => array('text' => __('Formulaire externe'), 'class' => 'checkbox-label'))), 
		$this->Form->input('is_order_form', array('label' => array('text' => __('Formulaire interne'), 'class' => 'checkbox-label'))), 
		'</div>';
	echo '<div class="tableRow">', $this->Form->input('library_id', array('label' => __('Bibliothèque d\'attribution').' : ', 'options' => $libraries, 'selected' => 0)), '</div>';
	echo '<div class="tableRow">', $this->Form->input('is_active', array('label' => __('Actif').' : ', 'format' => array('before', 'label', 'between', 'input', 'after', 'error'))), '</div>';

	echo '<div class="manage_footer">';
		echo $this->Form->button(__('Enregistrer les modifications'), array('class' => 'btn'));
		echo $this->Html->link(__('Annuler'), array('action' => 'index'), array('class' => 'btn'));
		echo $this->Form->end();
		echo $this->Form->postlink(__('Supprimer'), array('action' => 'delete', $this->request->data['Link']['id']), array('confirm' => __('Etes-vous sûr de vouloir supprimer le lien "%s"?', h($this->request->data['Link']['title'])), 'class' => 'btn'));
	echo '</div>';
?>