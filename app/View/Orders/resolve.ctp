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

	if(isset($this->data['error']))
		echo $this->Html->div('resolve_error', 'Erreur : '.$this->data['error']);
	echo '<div>', $this->Form->input('doc_type', array('label' => __('Type de document') . ' :', 'div' => false, 'name' => "data[Order][doc_type]", 'id' => 'OrderDocType', 'options' => array(
		'article' => __('Article'),
		'preprint' => __('Preprint'),
		'book' => __('Livre'),
		'bookitem' => __('Chapitre de livre'),
		'thesis' => __('Thèse'),
		'journal' => __('No de revue'),
		'proceeding' => __('Actes d\'un congrès'),
		'conference' => __('Article d\'une conférence'),
		'other' => __('Autre')))), '</div>';
	echo '<div>', $this->Form->input('journal_title', array('label' => __('Titre du périodique / livre') . ' :', 'div' => false, 'name' => "data[Order][journal_title]", 'id' => 'OrderJournalTitle', 'type' => 'text')), '</div>';?>
<div class="period">
	<?php
	echo $this->Form->input('year', array('label' => __('Année') . ' :', 'div' => false, 'name' => "data[Order][year]", 'id' => 'OrderYear'));
	echo $this->Form->input('volume', array('label' => __('Vol.') . ' :', 'div' => false, 'name' => "data[Order][volume]", 'id' => 'OrderVolume'));
	echo $this->Form->input('issue', array('label' => __('N°') . ' :', 'div' => false, 'name' => "data[Order][issue]", 'id' => 'OrderIssue'));
	echo $this->Form->input('supplement', array('label' => __('Suppl.') . ' :', 'div' => false, 'name' => "data[Order][supplement]", 'id' => 'OrderSupplement'));
	echo $this->Form->input('pages', array('label' => __('Pages') . ' :', 'div' => false, 'name' => "data[Order][pages]", 'id' => 'OrderPages')); ?>
</div>
<div>
<?php echo $this->Form->input('article_title', array('label' => __('Titre de l\'article / chapitre') . ' :', 'div' => false, 'type' => 'text', 'name' => "data[Order][article_title]", 'id' => 'OrderArticleTitle')); ?>
</div>
<div>
	<?php echo $this->Form->input('authors', array('label' => __('Auteurs') . ' :', 'div' => false, 'name' => "data[Order][authors]", 'id' => 'OrderAuthors')); ?>
</div>
<div id="divers">
<?php
	echo $this->Form->input('edition', array('label' => __('Edition (pour les livres)') . ' :', 'div' => false, 'name' => "data[Order][edition]", 'id' => 'OrderEdition'));
	echo $this->Form->input('isxn', array('label' => __('ISSN / ISBN') . ' :', 'div' => false, 'name' => "data[Order][isxn]", 'id' => 'OrderIsxn'));
	echo $this->Form->input('uid', array('label' => __('UID') . ' :', 'div' => false, 'name' => "data[Order][uid]", 'id' => 'OrderUid')); ?>
</div>
	<?php
	echo $this->Form->input('user_comment', array('label' => __('Remarques') . ' :', 'div' => false, 'name' => "data[Order][user_comment]", 'id' => 'OrderUserComment', 'type' => 'textarea'));