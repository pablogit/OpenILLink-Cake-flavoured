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

	$fields = array("Order.id" => __('No de commande'), 
					"Order.order_at" => __('Commandé le'), 
					"Order.sent_at" => __('Envoyé le'), 
					"Order.firstname" => __('Prénom du demandeur'), 
					"Order.surname" => __('Nom du demandeur'), 
					"Service.name" => __('Service du demandeur'), 
					"Service.department" => __('Département du demandeur'), 
					"Service.faculty" => __('Faculté du demandeur'), 
					"Origin.name" => __('Fournisseur du document'), 
					"Status.title" => __('Statut de la commande'));
	$operators = array('equals' => "=", 'different' => "!=", 'bigger' => ">", 'smaller' => '<');

	echo '<h3>' . __('Veuillez choisir une statistique prédéfinie') . ' :</h3>';
	echo $this->Form->create('Statistics', array('action' => 'generateFromSaved'));
	echo $this->Form->input('statName', array('options' => $statOptions, 'label' => __('Statistique prédéfinie') . ' : ', 'div' => false, 'class' => 'big-select'));
	echo '<div class="input-append date form-date date-div">';
		echo $this->Form->input('fromDate', array('type' => 'text','div' => false, 'label' => __('Date de début') . ' :', 'readonly' => true, 'default' => $defaultFromDate));
		echo '<span class="add-on"><i class="icon-th"></i></span>';
	echo '</div>';
	echo '<div class="input-append date form-date date-div">';
		echo $this->Form->input('toDate', array('type' => 'text','div' => false, 'label' => __('Date de fin') . ' : ', 'readonly' => true, 'default' => $defaultToDate));
		echo '<span class="add-on"><i class="icon-th"></i></span>';
	echo '</div>';
	echo $this->Form->button('Générer', array('class' => 'btn'));
	echo $this->Form->end();

	echo '<h3>' . __('Ou créez une statistique') . ' :</h3>';
	echo $this->Form->create('Statistics', array('action' => 'generateFromForm', 'inputDefaults' => array('div' => false)));
	echo '<div id="fields">';
		echo '<div>';
			echo $this->Form->input('fields', array('options' => $fields, 'name' => "data[Statistics][fields][]", 'label' => __('Champs affichés') . ' :'));
			echo $this->Form->input('iscount', array('type' => 'hidden', 'name' => "data[Statistics][is_count][0]", 'value' => '0'));
			echo $this->Form->input('iscount', array('type' => 'checkbox', 'name' => "data[Statistics][is_count][0]", 'value' => '1', 'label' => __('Appliquer fonction Count')));
		echo '</div>';
	echo '</div>';
	echo '<div>' . $this->Form->button(__('Ajouter un champ'), array('type' => 'button', 'onclick' => 'addField(); return false;', 'class' => 'btn')) . '</div>';
	echo '<div id="groupby">';
		echo '<div>'.$this->Form->input('groupby', array('options' => $fields, 'name' => "data[Statistics][groupby][]", 'label' => __('Regroupement sur') .' :', 'empty' => '')).'</div>';
	echo '</div>';
	echo '<div>' . $this->Form->button(__('Ajouter un regroupement'), array('type' => 'button', 'onclick' => 'addGroupby(); return false;', 'class' => 'btn')) . '</div>';
	echo '<div id="condition">';
		echo '<div>';
			echo $this->Form->input('condition', array('options' => $fields, 'name' => "data[Statistics][conditions][]", 'label' => __('Condition') .' :', 'empty' => ''));
			echo $this->Form->input('operator', array('options' => $operators, 'name' => "data[Statistics][operators][]", 'label' => false));
			echo $this->Form->input('value', array('name' => "data[Statistics][comparators][]", 'label' => false));
		echo '</div>';
	echo '</div>';
	echo '<div>' . $this->Form->button(__('Ajouter une condition'), array('type' => 'button', 'onclick' => 'addCondition(); return false;', 'class' => 'btn')) . '</div>';
	echo $this->Form->button('Générer', array('class' => 'btn'));
	echo $this->Form->end();
?>

<script type="text/javascript">
	$(".form-date").datetimepicker({
	format: "yyyy-mm-dd",
	minView: 2,
	autoclose: true});
</script>