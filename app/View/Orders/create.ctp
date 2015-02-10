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

 	$this->set('title_for_layout', __('Nouvelle commande'));

echo $this->Form->create('Order', array('inputDefaults' => array('div' => false)));
if(AuthComponent::user('id'))
{
?>
<div class="box">
	<div class="box-content">
		<div>
		<?php
			echo $this->Form->input('status_id', array('options' => $status, 'label' => __('Statut') . ' :', 'default' => $defaultStatus));
			echo $this->Form->input('origin_id', array('options' => $origins, 'label' => __('Provenance') . ' :'));
		?>
		</div>
		<div>
		<?php
			echo $this->Form->input('priority', array('options' => array('2' => __('Normale'), '1' => __('Urgente'), '3' => __('Pas prioritaire')), 'selected' => 2, 'label' => __('Priorité') . ' : '));
			echo $this->Form->input('request_by', array('options' => array('documentalist' => __('Documentaliste'), 'publicform' => 'publicform', 'email' => 'email', 'phone' => __('téléphone')), 'label' => __('Origine de la commande') . ' :'));
		?>
		</div>
		<div>
			<div class="input-append date form-datetime date-div">
				<?php echo $this->Form->input('order_at', array('type' => 'text','div' => false, 'label' => __('Date de commande') . ' :', 'readonly' => true)); ?>
				<span class="add-on"><i class="icon-th"></i></span>
			</div>
			<div class="input-append date form-datetime date-div">
				<?php echo $this->Form->input('sent_at', array('type' => 'text','div' => false, 'label' => __('Date d\'envoi') . ' :', 'readonly' => true)); ?>
				<span class="add-on"><i class="icon-th"></i></span>
			</div>
		</div>
		<div>
			<?php 
			if($configuration['Configuration']['invoice_fields_visibility'] == 1)
			{
				echo '<div class="input-append date form-datetime date-div">';
					echo $this->Form->input('invoice_at', array('type' => 'text','div' => false, 'label' => __('Date de facturation') . ' :', 'readonly' => true));
					echo '<span class="add-on"><i class="icon-th"></i></span>';
				echo '</div>';
			}
			?>
			<div class="input-append date form-date date-div">
				<?php echo $this->Form->input('renew_at', array('type' => 'text','div' => false, 'label' => __('A renouveler le') . ' :', 'readonly' => true)); ?>
				<span class="add-on"><i class="icon-th"></i></span>
			</div>
		</div>
		<?php
		if($configuration['Configuration']['invoice_fields_visibility'] == 1)
		{
			echo '<div>';
				echo $this->Form->input('price');
				echo $this->Form->input('is_prepaid', array('label' => __('Commande payée à l\'avance')));
			echo '</div>';
		}
		?>
		<div>
			<?php 
			echo $this->Form->input('external_ref', array('label' => __('Réf. fournisseur') . ' :'));
			echo $this->Form->input('internal_ref', array('label' => __('Réf. interne à la bibliothèque') . ' :'));
			?>
		</div>
		<div>
			<?php
			echo $this->Form->input('admin_comment', array('label' => __('Commentaires professionnels') . ' :'));
			?>
		</div>
	</div>
</div>
<div class="box-footer">
	<div class="box-footer-right"></div>
</div>
<?php } //End of admin fields 
elseif(!empty($configuration['Configuration']['order_info']))
{ ?>
<div class="box">
	<div class="box-content">
		<pre><?php echo $configuration['Configuration']['order_info']; ?></pre>
	</div>
</div>
<div class="box-footer">
	<div class="box-footer-right"></div>
</div>
<?php } ?>
<div class="box">
	<div class="box-content">
		<?php
			echo '<div id="userinfo">';
				echo $this->Form->input('surname', array('label' => __('Nom') . ' :'));
				echo $this->Form->input('firstname', array('label' => __('Prénom') . ' :'));
				if($configuration['Configuration']['is_ldap_active'] && AuthComponent::user('id'))
					echo $this->Html->image('find.png', array('alt' => 'find', 'onclick' => 'getInfos();', 'id' => 'search_logo'));
				echo '<div>', $this->Form->input('service_id', array('options' => $services, 'empty' => __('Choisir SVP.'), 'label' => __('Service') . ' :')), '</div>';
				if($configuration['Configuration']['budget_visibility'] == 1)
				{
					echo $this->Form->input('cgra', array('label' => __('Code budgétaire') . ' :'));
					echo $this->Form->input('cgrb', array('label' => __('Ligne budgétaire') . ' :'));
				}
				echo $this->Form->input('mail', array('label' => __('Email') . ' :'));
				echo $this->Form->input('tel', array('label' => __('Tél') . ' :'));
			echo '</div>';
			echo $this->Form->input('address', array('label' => __('Adresse privée') . ' :'));
			echo $this->Form->input('zip', array('label' => __('Code postal') . ' :'));
			echo '<div>', $this->Form->input('locality', array('label' => __('Localité') . ' :')), '</div>';
			echo '<label>' . __('Si disponible à la bibliothèque') . ' :</label>';
			echo $this->Form->input('deliver_type', array('type' => 'radio', 'options' => array('mail' => __('envoi par email (facturé)'), 'surplace' => __('m\'avertir et je passe faire la copie (non facturé)')), 'legend' => false, 'default' => 'mail'));
			echo '<br />';
			echo $this->Form->input('cookie', array('label' => __('Mémoriser ces données pour les prochaines commandes (cookies autorisés)'), 'type' => 'checkbox'));
			echo ' | ('. $this->Html->link('supprimer le cookie', '#', array('onclick' => 'javascript:deleteCookie("CakeCookie[FormInfo]")')) . ')';
		?>
	</div>
</div>
<div class="box-footer">
	<div class="box-footer-right"></div>
</div>
<div class="box">
	<div class="box-content">
		<div class="box">
			<div class="box-content">
				<center>
					<?php echo __('Remplir la commande à partir du '); 
					?>
						<select id="tid" name="tid">
							<option value="pmid">PMID</option>
							<?php if((!empty($configuration['Configuration']['crossref_username']) && !empty($configuration['Configuration']['crossref_password'])) || !empty($configuration['Configuration']['crossref_email']))
							echo '<option value="doi">DOI</option>'; ?>
							<option value="isbn">ISBN</option>
							<!--<option value="reroid">REROID</option>
							<option value="wosid">Wos ID</option>-->
						</select>
						<input type="text" maxlength="50" name="uid" id="uid" value="<?php echo $this->request->data['uid']; ?>" />
						<button type="submit" id="resolveSubmit" onclick="cleanupUid(); return false;" class="btn">OK</button>
					<?php
					$this->Js->get('#resolveSubmit')->event(
					   'click',
					   $this->Js->request(
					    array('action' => 'resolve', 'controller' => 'orders'),
					    array(
					    	'success' => "document.getElementById('resultForm').innerHTML = data;",
					        'async' => true,
					        'data' => '"tid="+$("#tid").val()+"&uid="+$("#uid").val()',
					        'dataExpression'=>true,
					        'method' => 'POST'
					    )
					  )
					);
					echo $this->Js->writeBuffer();
					?>
				</center>
			</div>
		</div>
		<div class="box-footer">
			<div class="box-footer-right"></div>
		</div>
		<div id="resultForm">
			<?php
				echo '<div>', $this->Form->input('doc_type', array('label' => __('Type de document') . ' :', 'options' => array(
					'article' => __('Article'),
					'preprint' => __('Preprint'),
					'book' => __('Livre'),
					'bookitem' => __('Chapitre de livre'),
					'thesis' => __('Thèse'),
					'journal' => __('No de revue'),
					'proceeding' => __('Actes d\'un congrès'),
					'conference' => __('Article d\'une conférence'),
					'other' => __('Autre')))), '</div>';
				echo '<div>', $this->Form->input('journal_title', array('label' => __('Titre du périodique / livre') . ' :', 'type' => 'text')), '</div>';?>
			<div class="period">
				<?php
				echo $this->Form->input('year', array('label' => __('Année') . ' :'));
				echo $this->Form->input('volume', array('label' => __('Vol.') . ' :'));
				echo $this->Form->input('issue', array('label' => __('N°') . ' :'));
				echo $this->Form->input('supplement', array('label' => __('Suppl.') . ' :'));
				echo $this->Form->input('pages', array('label' => __('Pages') . ' :')); ?>
			</div>
			<div>
			<?php echo $this->Form->input('article_title', array('label' => __('Titre de l\'article / chapitre') . ' :', 'type' => 'text')); ?>
			</div>
			<div>
				<?php echo $this->Form->input('authors', array('label' => __('Auteurs') . ' :')); ?>
			</div>
			<div id="divers">
			<?php
				echo $this->Form->input('edition', array('label' => __('Edition (pour les livres)') . ' :'));
				echo $this->Form->input('isxn', array('label' => __('ISSN / ISBN') . ' :'));
				echo $this->Form->input('uid', array('label' => __('UID') . ' :')); ?>
			</div>
				<?php
				echo $this->Form->input('user_comment', array('label' => __('Remarques') . ' :', 'div' => false)); ?>
		</div>
		<?php echo $this->Form->button(__('Enregistrer'), array('class' => 'btn'));
		echo $this->Form->button(__('Effacer'), array('onclick' => 'orderCleanup(); return false;', 'type' => 'button', 'class' => 'btn')); 
		echo $this->Form->end(); ?>
	</div>
</div>
<div class="box-footer">
	<div class="box-footer-right"></div>
</div>
<?php 
echo  $this->Html->scriptBlock('function getInfos() {' . $this->Js->request(
		array('action' => 'resolveFromLDAP', 'controller' => 'orders'),
		array(
		'update' => '#userinfo',
		'async' => true,
		'data' => '"sn="+$("#OrderSurname").val()+"&fn="+$("#OrderFirstname").val()',
		'dataExpression'=>true,
		'method' => 'POST')) . '}');
?>

<script type="text/javascript">
	$(".form-datetime").datetimepicker({
	format: "yyyy-mm-dd - hh:ii",
	autoclose: true});
	$(".form-date").datetimepicker({
	format: "yyyy-mm-dd",
	minView: 2,
	autoclose: true});
</script>

<?php
if(!AuthComponent::user('id') && $configuration['Configuration']['is_ldap_active'])
{
	echo '<script type="text/javascript">
        autoFill();
		</script>';
}

if($this->request->data['uid'] != '')
{
	echo '<script type="text/javascript">
        $(document).ready(function(){
			 $("#resolveSubmit").trigger("click");
			});
		</script>';
}