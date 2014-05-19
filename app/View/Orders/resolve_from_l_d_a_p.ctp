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

	echo $this->Form->input('surname', array('label' => __('Nom') . ' :', 'div' => false, 'name' => 'data[Order][surname]', 'id' => 'OrderSurname', 'required' => 'required'));
	echo $this->Form->input('firstname', array('label' => __('Prénom') . ' :', 'div' => false, 'name' => 'data[Order][firstname]', 'id' => 'OrderFirstname', 'required' => 'required'));
	if(AuthComponent::user('id'))
		echo $this->Html->image('find.png', array('alt' => 'find', 'onclick' => 'getInfos();', 'id' => 'search_logo'));

	echo '<div>', $this->Form->input('service_id', array('options' => $services, 'empty' => __('Choisir SVP.'), 'label' => __('Service') . ' :', 'div' => false, 'name' => 'data[Order][service_id]', 'id' => 'OrderServiceId', 'required' => 'required')),  '</div>';
	if($config['Configuration']['budget_visibility'] == 1)
	{
		echo $this->Form->input('cgra', array('label' => __('Code budgétaire') . ' :'));
		echo $this->Form->input('cgrb', array('label' => __('Ligne budgétaire') . ' :'));
	}
	echo $this->Form->input('mail', array('label' => __('Email') . ' :', 'div' => false, 'name' => 'data[Order][mail]', 'id' => 'OrderMail', 'required' => 'required'));
	echo $this->Form->input('tel', array('label' => __('Tél') . ' :', 'div' => false, 'name' => 'data[Order][tel]', 'id' => 'OrderTel'));

	if(isset($options))
	{
		echo '<div id="popUpDiv">';
		echo $this->Form->input('names', array('options' => $options, 'label' => __('Plusieurs personnes correspondent à votre recherche, veuillez choisir.'), 'onchange' => 'updateFromName();', 'empty' => __('Choisir SVP.')));
		echo '</div>';
	}

	if(isset($results))
	{ ?>
	<div id="nameResults">
		<?php 
			for($i = 0; $i < count($results); $i++)
			{
				echo '<entry id="name'.$i.'" surname="'.$results[$i]['surname'].'" firstname="'.$results[$i]['firstname'].'" service_id="'.$results[$i]['service_id'].'" mail="'.$results[$i]['mail'].'" />';
			}
		?>
	</div>
	<?php } ?>