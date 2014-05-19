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

	$this->set('title_for_layout', __('Détails de la commande n°%s', $order['Order']['id']));
?>
<div class="box">
	<div class="box-content">
		<div id="order-fields">
		<?php
			$fields = array(
				__('Commande N°') => $order['Order']['id'],
				__('Date de la commande') => $order['Order']['order_at'],
				__('Date d\'envoi') => $order['Order']['sent_at'],
				__('Date de facturation') => $order['Order']['invoice_at'],
				__('Date de renouvellement') => $order['Order']['renew_at'],
				__('Bibliothèque d\'attribution') => $order['Library']['name'],
				__('Provenance') => $order['Origin']['name'],
				__('Statut') => $order['Status']['title'],
				__('Lecteur') => $order['Order']['surname'] . ', ' . $order['Order']['firstname'],
				__('E-mail') => $order['Order']['mail'],
				__('Adresse') => $order['Order']['address'] . ', ' . $order['Order']['zip'] . " " . $order['Order']['locality'],
				__('Service') => $order['Service']['name'],
				__('Type de document') => $order['Order']['doc_type'],
				__('Titre') => $order['Order']['article_title'],
				__('Auteurs') => $order['Order']['authors'],
				(substr($order['Order']['doc_type'], 0, 4) == 'book' ? __('Livre') : __('Périodique')) => $order['Order']['journal_title'],
				__('Volume') => $order['Order']['volume'],
				__('N°') => $order['Order']['issue'],
				__('Suppl.') => $order['Order']['supplement'],
				__('Pages') => $order['Order']['pages'],
				__('Année') => $order['Order']['year'],
				(substr($order['Order']['doc_type'], 0, 4) == 'book' ? __('ISBN') : __('ISSN')) => $order['Order']['isxn'],
				__('PMID') => $order['Order']['pmid'],
				__('DOI') => $order['Order']['doi'],
				__('Autre identificateur') => $order['Order']['uid'],
				__('Code de gestion A') => $order['Order']['cgra'],
				__('Code de gestion B') => $order['Order']['cgrb'],
				__('N° tél.') => $order['Order']['tel'],
			);

		if(AuthComponent::user('admin_level') != '9')
		{
			$fields[__('Saisie par')] = $order['Order']['filled_out_by'];
			$fields[__('Adresse IP')] = $order['Order']['ip'];
			$fields[__('Url de provenance')] = $order['Order']['referer'];
			$fields[__('Arrivé par')] = $order['Order']['request_by'];
			$fields[__('Livraison')] = $order['Order']['deliver_type'];
			$fields[__('Prix')] = $order['Order']['price'];
			$fields[__('Payé à l\'avance')] = $order['Order']['is_prepaid'];
			$fields[__('Réf. fournisseur')] = $order['Order']['external_ref'];
			$fields[__('Réf. interne à la bibliothèque')] = $order['Order']['internal_ref'];
			$fields[__('Code d\'accès guest')] = __('Identifiant') . ' : ' . $order['Order']['mail'] . " | " . __('Mot de passe') . ' : ' . substr(hash('md5', strtolower($order['Order']['mail'])), 0, 8);
			$fields[__('Commentaire public')] = $order['Order']['user_comment'];
			$fields[__('Commentaire professionnel')] = $order['Order']['admin_comment'];
			$fields[__('Historique')] = $order['Order']['history'];
		}

		foreach ($fields as $fieldName => $fieldValue)
		{
			if(!empty($fieldValue) && $fieldValue != ", " && $fieldValue != ",  ")
			{
				echo '<b>' . $fieldName . ' : </b>';
				switch ($fieldName)
				{
					case __('E-mail'):
						echo h($fieldValue) . " ";
						if(AuthComponent::user('admin_level') != '9')
							echo $this->Html->image('email.gif', array('url' => $emailLink));
						echo '<br />';
						break;
					case __('Commentaire professionnel'):
						echo nl2br(h($fieldValue)) . '<br />';
						break;
					case __('Historique'):
						echo $fieldValue . '<br />';
						break;
					case __('Date de renouvellement'):
						$parts = explode(" ", $fields[__('Date de renouvellement')]);
						echo $parts[0] . '<br />';
						break;
					default:
						echo h($fieldValue) . '<br />';
						break;
				}
			}
		}

		?>
		</div>
		<?php 
		if(AuthComponent::user('admin_level') != '9')
		{ ?>
		<div id="order-menu">
			<div class="box">
				<div class="box-content">
				<?php
					$list = array(
						$this->Html->link(__('Editer la commande'), array('controller' => 'orders', 'action' => 'edit', $order['Order']['id']))
					);
					if(!empty($config['Configuration']['directory1_name']) && !empty($config['Configuration']['directory1_url']))
					{
						$directory_url = $config['Configuration']['directory1_url'];
						$directory_url = str_replace('XNAMEX', $order['Order']['surname'], $directory_url);
						$directory_url = str_replace('XFIRSTNAMEX', $order['Order']['firstname'], $directory_url);
						$list[] = $this->Html->link($config['Configuration']['directory1_name'], $directory_url, array('target' => '_blank'));
					}
					if(!empty($config['Configuration']['directory2_name']) && !empty($config['Configuration']['directory2_url']))
					{
						$directory_url = $config['Configuration']['directory2_url'];
						$directory_url = str_replace('XNAMEX', $order['Order']['surname'], $directory_url);
						$directory_url = str_replace('XFIRSTNAMEX', $order['Order']['firstname'], $directory_url);
						$list[] = $this->Html->link($config['Configuration']['directory2_name'], $directory_url, array('target' => '_blank'));
					}

					echo $this->Html->nestedList($list);

					$titles = array('issn' => __('Recherche par ISSN'), 'isbn' => __('Recherche par ISBN'), 'pmid' => __('Recherche par PMID'), 'atitle' => __('Recherche par titre d\'article'), 'ptitle' => __('Recherche par titre de périodique'), 'btitle' => __('Recherche par titre de livre'), 'chtitle' => __('Recherche par titre de chapitre'), 'orderLinks' => __('Traiter la commande'));
					foreach ($externalLinks as $linkType => $linkGroup)
					{
						if(count($linkGroup) == 0)
							continue;

						echo $this->Html->div('ext-link-title', $titles[$linkType]);
						echo '<ul>';
						foreach ($linkGroup as $link)
						{
							echo '<li>', $this->Html->link($link['Link']['title'], $link['Link']['url'], array('target' => '_blank')), '</li>';
						}
						echo '</ul>';
					}

					?>
				</div>
			</div>
			<div class="box-footer">
				<div class="box-footer-right"></div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<div class="box-footer">
	<div class="box-footer-right"></div>
</div>