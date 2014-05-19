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

	$this->set('title_for_layout', __('Liste des commandes'));
/*
 * TODO :
 * - Department / faculty display next to service name
 */
	echo '<div class="box">';
		echo '<div class="box-content" id="search-box">';
		echo $this->Form->create(false, array('type' => 'get', 'action' => 'search'));
		echo $this->Form->input('field', array('options' => $searchFields, 'default' => 'external_ref', 'div' => false, 'label' => array('text' => __('Chercher') . ' : ', 'class' => 'small'))), ' = ';
		echo $this->Form->input('value', array('div' => false, 'label' => false));
		echo $this->Form->button(__('Ok'), array('class' => 'btn'));
		echo $this->Form->end();
		echo '</div>';
	echo '</div>';
	echo '<div class="box-footer">';
		echo '<div class="box-footer-right"></div>';
	echo '</div>';

	echo $this->Html->div('order_show_count', $this->Paginator->counter(__('Affichage des commandes {:start} à {:end} sur un total de {:count} trouvées pour la boite %s', $boxName)));

	foreach ($orders as $order)
	{
		echo '<div class="order">';
			echo '<div class="order_info">';
				echo $this->Html->link(__('Commande No') . ' : ' . $order['Order']['id'], array('action' => 'details', $order['Order']['id']), array('title' => __('Voir la notice complète')));
				$date = new DateTime($order['Order']['order_at']);
				echo ' | ' . __('Date') . ' : ' . $date->format('d M Y') . ' | ' . __('Bibliothèque d\'attribution') . ' : ' . $order['Library']['name'] . ' | ' . __('Provenance') . ' : ' . $order['Origin']['name'];
			echo '</div>';
			echo '<div class="order_status">';
				echo __('Statut') . ' : ' . $this->Html->link($order['Status']['title'], '#', array('style' => 'color : ' . $order['Status']['color'], 'title' => $order['Status']['help']));
				if($order['Order']['priority'] == '1')
				{
					echo ' | <font color="red">', __('Commande urgente'), '</font>';
				}

				if(!empty($order['Order']['admin_comment']))
				{
					echo $this->Html->image('warning.png', array('class' => 'warning-icon', 'title' => $order['Order']['admin_comment']));
				}
			echo '</div>';

			$serviceOutput = $order['Service']['name']; //Complete with dpt name and/or faculty name
			$address = $order['Order']['address'] . ', ' . $order['Order']['zip'] . ' ' . $order['Order']['locality'];
			$name = $order['Order']['surname'] . ', ' . $order['Order']['firstname'];
			echo '<div class="reader_info">';
				echo '<b>' . __('Lecteur') . ' : </b>'. $this->Html->link($name, array('controller' => 'orders', 'action' => 'search', 'name', urlencode($name)), array('title' => __('Chercher les commandes de ce lecteur')));
				echo ' | <b>' . __('E-mail') . ' : </b>' . $this->Html->link($order['Order']['mail'], array('controller' => 'orders', 'action' => 'search', 'mail', urlencode($order['Order']['mail'])), array('title' => __('Chercher les commandes avec cet email')));
				echo ' | <b>' . ($address == ',  ' ? '' : __('Adresse') . ' : </b>' . $address . ' | <b>');
				echo __('Service') . ' : </b>' . $serviceOutput;
			echo '</div>';
			echo '<div>';
				echo (empty($order['Order']['article_title']) ? '' : '<b>' . __('Titre') . ' : </b>' . $this->Html->link($order['Order']['article_title'], array('controller' => 'orders', 'action' => 'search', 'article_title', urlencode($order['Order']['article_title'])), array('title' => __('Chercher les commandes avec ce titre d\'article'))));
			echo '</div>';
			echo '<div>';
				echo '<b>' . __('Auteurs') . ' : </b>' . $order['Order']['authors'];
			echo '</div>';

			$titleLabel = __('Périodique');
			if(substr($order['Order']['doc_type'], 0, 4) == 'book')
				$titleLabel = __('Livre');
			
			echo '<div class="book_info">';
				echo '<b>' . $titleLabel . ' : </b>' . $this->Html->link($order['Order']['journal_title'], array('controller' => 'orders', 'action' => 'search', 'journal_title', urlencode($order['Order']['journal_title'])), array('title' => __('Chercher les commandes avec ce titre de %s', $titleLabel)));
			echo '</div>';
			$volNo = (!empty($order['Order']['volume']) ? '<b>' . __('Vol.') . '</b> : ' . $order['Order']['volume'] : '');
			$volNo .= (!empty($order['Order']['issue']) ? (empty($volNo)? '<b>' : ' | <b>') . __('N°') . '</b> : ' . $order['Order']['issue'] : '');
			$volNo .= (!empty($order['Order']['pages']) ? (empty($volNo)? '<b>' : ' | <b>') . __('Pages') . '</b> : ' . $order['Order']['pages'] : '');
			$volNo .= (!empty($order['Order']['year']) ? (empty($volNo)? '<b>' : ' | <b>') . __('Année') . '</b> : ' . $order['Order']['year'] : '');
			echo '<div class="VolNo">';
				echo $volNo;
			echo '</div>';
		echo '</div>';
	}

	echo '<div class="paging">';
		if($this->Paginator->hasPrev())
		{
			echo $this->Paginator->first(__('Début'), array('class' => 'btn'));
			echo $this->Paginator->prev(__('Précédent'), array('class' => 'btn'));
		}



		if($this->Paginator->hasNext())
		{
			echo $this->Paginator->next(__('Suivant'), array('class' => 'btn'));
			echo $this->Paginator->last(__('Fin'), array('class' => 'btn'));
		}
	echo '</div>';
?>