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

	$this->set('title_for_layout', __('Confirmation de commande'));
?>

<div class="box">
	<div class="box-content">
		<div class="confirmation_header"><?php echo __('Votre commande a été enregistrée avec succès et sera traitée prochainement'); ?></div>
		<div class="confirmation_content">
		<?php
			$fields = array(
				__('Commande N°') => $data['Order']['id'],
				__('Nom') => $data['Order']['surname'] . ', ' . $data['Order']['firstname'],
				__('E-mail') => $data['Order']['mail'],
				__('Adresse') => $data['Order']['address'] . ', ' . $data['Order']['zip'] . " " . $data['Order']['locality'],
				__('Service') => $data['Service']['name'],
				__('Type de document') => $data['Order']['doc_type'],
				__('Titre') => $data['Order']['article_title'],
				__('Auteurs') => $data['Order']['authors'],
				(strstr($data['Order']['doc_type'], 0, 4) == 'book' ? __('Livre') : __('Périodique')) => $data['Order']['journal_title'],
				__('Volume') => $data['Order']['volume'],
				__('N°') => $data['Order']['issue'],
				__('Suppl.') => $data['Order']['supplement'],
				__('Pages') => $data['Order']['pages'],
				__('Année') => $data['Order']['year'],
				(strstr($data['Order']['doc_type'], 0, 4) == 'book' ? __('ISBN') : __('ISSN')) => $data['Order']['isxn'],
				__('PMID') => $data['Order']['pmid'],
				__('DOI') => $data['Order']['doi'],
				__('Autre identificateur') => $data['Order']['uid'],
				__('Code d\'accès guest') => __('Identifiant') . ' : ' . $data['Order']['mail'] . " | " . __('Mot de passe') . ' : ' . substr(hash('md5', strtolower($data['Order']['mail'])), 0, 8),
				__('Commentaire') => $data['Order']['user_comment'],
			);

		foreach ($fields as $fieldName => $fieldValue)
		{
			if(!empty($fieldValue) && $fieldValue != ", " && $fieldValue != ",  ")
			{
				echo '<b>' . $fieldName . ' : </b>' . $fieldValue . '<br />';
			}
		}
	?>
		</div>
		<div class="confirmation_footer">
		<?php echo $this->Html->link(__('Remplir une nouvelle commande'), array('controller' => 'orders', 'action' => 'create')); ?>
		</div>
	</div>
</div>
<div class="box-footer">
	<div class="box-footer-right"></div>
</div>