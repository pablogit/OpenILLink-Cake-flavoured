<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __('OpenIllink');
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT"); // une date d'expiration dans le passé
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // la date/heure de génération de la page
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // désactivation du cache
header("Cache-Control: post-check=0, pre-check=0", false); // gestion du cache de IE
header("Pragma: no-cache"); // gestion du cache de IE 
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?> : 
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('bootstrap-datetimepicker.min');
		echo $this->Html->css('style1');
		echo $this->Html->script('jquery-1.8.3.min');
		echo $this->Html->script('bootstrap.min');
		echo $this->Html->script('bootstrap-datetimepicker.min');
		echo $this->Html->script('common');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div class="page">
		<div class="head-bar">
			<div class="banner"></div>
			<div class="top-menu">
					<?php
					$list = array();
					if(AuthComponent::user('id')) //Admin menu
					{
						$username = (strlen(AuthComponent::user('name')) > 15? substr(AuthComponent::user('name'), 0, 13) . '...' : AuthComponent::user('name'));
						$list = array(
							$username . ' ' . $this->Html->link('[' . __('Déconnexion') . ']', array('controller' => 'users', 'action' => 'logout')),
							$this->Html->link(__('Nouvelle commande'), array('controller' => 'orders', 'action' => 'create')),
							$this->Html->link(__('In'), array('controller' => 'orders', 'action' => 'index', 'in'), array('title' => __('Commandes à fournir ou à valider'))),
							$this->Html->link(__('Out'), array('controller' => 'orders', 'action' => 'index', 'out'), array('title' => __('Commandes envoyées à l\'extérieur et pas encore reçu.'))),
							$this->Html->link(__('All'), array('controller' => 'orders', 'action' => 'index', 'all'), array('title' => __('Toutes les commandes'))),
							$this->Html->link(__('Poubelle'), array('controller' => 'orders', 'action' => 'index', 'trash'), array('title' => __('Commandes supprimées'))),
							$this->Html->link(__('Administration'), array('controller' => 'admin', 'action' => 'index')),
							$this->Html->link(__('Statistiques'), array('controller' => 'statistics', 'action' => 'index')),
						);						
					}
					elseif(AuthComponent::user('admin_level') == '9')
					{
						$list = array(
							AuthComponent::user('username') . ' ' . $this->Html->link('[' . __('Déconnexion') . ']', array('controller' => 'users', 'action' => 'logout')),
							$this->Html->link(__('Nouvelle commande'), array('controller' => 'orders', 'action' => 'create')),
							$this->Html->link(__('Mes commandes'), array('controller' => 'orders', 'action' => 'index', 'guest'), array('title' => __('Mes commandes'))),
						);						
					}
					else //unlogged menu
					{
						$list = array(
							$this->Html->link(__('Connexion'), array('controller' => 'users', 'action' => 'login')),
							$this->Html->link(__('Nouvelle commande'), array('controller' => 'orders', 'action' => 'create')),
						);
					}
					if(!empty($config['Configuration']['journals_url']))
					{
						array_push($list, $this->Html->link(__('Liste des revues'), $config['Configuration']['journals_url'], array('target' => '_blank')));
					}

					echo $this->Html->nestedList($list);
					?>
			</div>
		</div>
		<div class="content-area">
			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer" class="footer">
			<?php 
			echo 'Site propulsé par ' . $this->Html->link('OpenLinker', 'http://openlinker.org', array('target' => '_blank')) . '<br />';
			echo '© ' . $this->Html->link('Pablo Iriarte', 'http://www.pablog.ch', array('target' => '_blank'));
			echo ' ' . $this->Html->link('BiUM', 'http://www.chuv.ch/bdfm/', array('target' => '_blank'));
			echo '/' . $this->Html->link('CHUV', 'http://www.chuv.ch', array('target' => '_blank')) . ' Lausanne & ';
			echo $this->Html->link('Jan Krause', 'http://jankrause.net', array('target' => '_blank'));
			echo ' ' . $this->Html->link('BFM', 'http://www.unige.ch/medecine/bibliotheque/', array('target' => '_blank'));
			echo '/' . $this->Html->link('UNIGE', 'http://www.unige.ch', array('target' => '_blank')) . ' Genève & ';
			echo $this->Html->link('Cyril Sester', '#');
			echo ' ' . $this->Html->link('HNE', 'http://www.h-ne.ch/', array('target' => '_blank')) . ' Neuchâtel'; ?>
			</div>
		</div>
	</div>
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>
