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

	$this->set('title_for_layout', __('Édition des variables du système'));

	echo '<div class="manage_title">', __("Gestion des variables du système"), '</div>';

	echo $this->Form->create('Configuration', array('inputDefaults' => array('div' => false)));
	echo '<div class="tableRow">', $this->Html->image('collapsed.gif', array('onclick' => 'expand(\'library_info\');')), __('Coordonnées de la bibliothèque'), '</div>';
	echo '<div id="library_info" class="subTable">';
		echo '<div class="tableRow">', $this->Form->input('library_name', array('label' => __('Nom') . ' :')), '</div>';
		echo '<div class="tableRow">', $this->Form->input('library_street', array('label' => __('Adresse') . ' :')), '</div>';
		echo '<div class="tableRow">', $this->Form->input('library_zip', array('label' => __('Code postal') . ' :')), '</div>';
		echo '<div class="tableRow">', $this->Form->input('library_city', array('label' => __('Ville') . ' :')), '</div>';
		echo '<div class="tableRow">', $this->Form->input('library_country', array('label' => __('Pays') . ' :')), '</div>';
		echo '<div class="tableRow">', $this->Form->input('library_tel', array('label' => __('N° de tél.') . ' :')), '</div>';
		echo '<div class="tableRow">', $this->Form->input('library_email', array('label' => __('Adresse email') . ' :')), '</div>';
		echo '<div class="tableRow">', $this->Form->input('library_url', array('label' => __('Site web') . ' :')), '</div>';
	echo '</div>';
	echo '<div class="tableRow">', $this->Html->image('collapsed.gif', array('onclick' => 'expand(\'manager_info\');')), __('Coordonnées du responsable'), '</div>';
	echo '<div id="manager_info" class="subTable">';
		echo '<div class="tableRow">', $this->Form->input('manager_name', array('label' => __('Nom') . ' :')), '</div>';
		echo '<div class="tableRow">', $this->Form->input('manager_email', array('label' => __('Adresse email') . ' :')), '</div>';
		echo '<div class="tableRow">', $this->Form->input('manager_tel', array('label' => __('N° de tél.') . ' :')), '</div>';
	echo '</div>';
	echo '<div class="tableRow">', $this->Form->input('journals_url', array('label' => __('URL du catalogue de revues') . ' :')), '</div>';
	echo '<div class="tableRow">', $this->Form->input('delivery_mail', array('label' => array('text' => __('Adresse email pour la livraison d\'articles') . ' :', 'title' => __('Sera utilisé pour préremplir un formulaire de commande auprès d\'un fournisseur')))), '</div>';
	echo '<div class="tableRow">', $this->Form->input('admin_email', array('label' => __('Adresse email de l\'administrateur') . ' :')), '</div>';
	echo '<div class="tableRow">', $this->Form->input('crossref_username', array('label' => array('text' => __('Identifiant CrossRef') . ' :', 'title' => __('Une des deux options CrossRef doit être renseignée afin de pouvoir décoder les DOI.')))), $this->Form->input('crossref_password', array('label' => __('Mot de passe CrossRef') . ' :', 'type' => 'password'));
	echo '<br /><b>OU</b><br />';
	echo $this->Form->input('crossref_email', array('label' => array('text' =>__('Email Free CrossWeb') . ' :', 'title' => __('Une des deux options CrossRef doit être renseignée afin de pouvoir décoder les DOI.')))), '</div>';
	echo '<div class="tableRow">', $this->Form->input('directory1_name', array('label' => __('Nom de l\'annuaire 1') . ' :')), $this->Form->input('directory1_url', array('label' => __('Adresse de l\'annuaire 1 :'))), '</div>';
	echo '<div class="tableRow">', $this->Form->input('directory2_name', array('label' => __('Nom de l\'annuaire 2') . ' :')), $this->Form->input('directory2_url', array('label' => __('Adresse de l\'annuaire 2 :'))), '</div>';
	echo '<div class="tableRow">', $this->Form->input('browser_language_detection', array('label' => __('Détection de la langue automatique') . ' :', 'format' => array('before', 'label', 'between', 'input', 'after', 'error'))), '</div>';
	echo '<div class="tableRow">', $this->Form->input('openurl_sid', array('label' => __('OpenURL sid') . ' :')), '</div>';
	echo '<div class="tableRow">', $this->Html->image('collapsed.gif', array('onclick' => 'expand(\'shibboleth_config\');')), __('Configuration Shibboleth (SSO)'), '</div>';
	echo '<div id="shibboleth_config" class="subTable">';
		echo '<div class="tableRow">', $this->Form->input('is_shibboleth_active', array('label' => __('Authentification Shibboleth activée') . ' :', 'format' => array('before', 'label', 'between', 'input', 'after', 'error'))), '</div>';
		echo '<div class="tableRow">', $this->Form->input('shibboleth_url', array('label' => __('Adresse du Discovery Service') . ' :')), '</div>';
		echo '<div class="tableRow">', $this->Form->input('shibboleth_entity', array('label' => __('IdentityID') . ' :')), '</div>';
		echo '<div class="tableRow">', $this->Form->input('shibboleth_return', array('label' => __('Adresse de retour') . ' :')), '</div>';
	echo '</div>';
	echo '<div class="tableRow">', $this->Html->image('collapsed.gif', array('onclick' => 'expand(\'ldap_config\');')), __('Configuration LDAP'), '</div>';
	echo '<div id="ldap_config" class="subTable">';
		echo '<div class="tableRow">', $this->Form->input('is_ldap_active', array('label' => __('Résolution LDAP activée') . ' :', 'format' => array('before', 'label', 'between', 'input', 'after', 'error'))), '</div>';
		echo '<div class="tableRow">', $this->Form->input('ldap_url', array('label' => __('Adresse') . ' :')), '</div>';
		echo '<div class="tableRow">', $this->Form->input('ldap_port', array('label' => __('Port') . ' :')), '</div>';
		echo '<div class="tableRow">', $this->Form->input('ldap_rdn', array('label' => __('RDN') . ' :')), '</div>';
		echo '<div class="tableRow">', $this->Form->input('ldap_password', array('label' => __('Mot de passe') . ' :')), '</div>';
		echo '<div class="tableRow">', $this->Form->input('ldap_base_dn', array('label' => __('Base DN') . ' :')), '</div>';
	echo '</div>';
	echo '<div class="tableRow">', $this->Html->image('collapsed.gif', array('onclick' => 'expand(\'proxy_config\');')), __('Configuration proxy'), '</div>';
	echo '<div id="proxy_config" class="subTable">';
		echo '<div class="tableRow">', $this->Form->input('is_proxy_active', array('label' => __('Utilisation d\'un proxy activée') . ' :', 'format' => array('before', 'label', 'between', 'input', 'after', 'error'))), '</div>';
		echo '<div class="tableRow">', $this->Form->input('proxy_url', array('label' => __('Adresse') . ' :')), '</div>';
		echo '<div class="tableRow">', $this->Form->input('proxy_port', array('label' => __('Port') . ' :')), '</div>';
		echo '<div class="tableRow">', $this->Form->input('proxy_username', array('label' => __('Nom d\'utilisateur (optionnel)') . ' :')), '</div>';
		echo '<div class="tableRow">', $this->Form->input('proxy_password', array('label' => __('Mot de passe (optionnel)') . ' :')), '</div>';
	echo '</div>';
	echo '<div class="tableRow">', $this->Form->input('mail_auth_info', array('label' => __('Info d\'identification guest dans les mails') . ' :', 'format' => array('before', 'label', 'between', 'input', 'after', 'error'))), '</div>';
	echo '<div class="tableRow">', $this->Form->input('invoice_fields_visibility', array('label' => __('Champs de facturation visibles') . ' :', 'format' => array('before', 'label', 'between', 'input', 'after', 'error'))), '</div>';
	echo '<div class="tableRow">', $this->Form->input('budget_visibility', array('label' => __('Champs rubriques budgétaires visibles') . ' :', 'format' => array('before', 'label', 'between', 'input', 'after', 'error'))), '</div>';
	echo '<div class="tableRow">', $this->Form->input('order_info', array('label' => __('Information pour les usagers') . ' :')), '</div>';


	echo '<div class="manage_footer">', $this->Form->button(__('Enregistrer les modifications'), array('class' => 'btn')), $this->Html->link(__('Annuler'), array('action' => 'index'), array('class' => 'btn')), '</div>';
	echo $this->Form->end();
?>