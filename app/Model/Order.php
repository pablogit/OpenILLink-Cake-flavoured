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

/*
* TODO :
* - Reroid, wosid lookup
*/

class Order extends AppModel
{
	public $belongsTo = array('Status', 'Origin', 'Service', 'Library');

	public $validate = array(
		'price' => array(
			'rule'		=> array('money'),
			'allowEmpty' => true,
			'message'	=> 'Entrez un prix valide. Séparateur : point.'
		),
		'surname' => array(
			'rule'    => 'notEmpty',
		),
		'firstname' => array(
			'rule'    => 'notEmpty',
		),
		'service_id' => array(
			'rule'    => 'notEmpty',
		),
		'mail' => array(
			'rule'	=> 'email',
			'allowEmpty' => false,
			'message' => 'Veuillez saisir une adresse mail valide.'
		)
	);

	public function getSearchFields()
	{
		$searchFields = array('id' => __('N° de commande'), 'order_at' => __('Date de la commande'), 'sent_at' => __('Date d\'envoi'), 'invoice_at' => __('Date de facturation'), 'status' => __('Statut'), 'origin' => __('Provenance'), 'name' => __('Nom du lecteur'), 'mail' => __('Email du lecteur'), 'service' => __('Service'), 'isxn' => __('ISBN/ISSN'), 'pmid' => __('PMID'), 'doi' => __('DOI'), 'journal_title' => __('Titre du périodique / du livre'), 'article_title' => __('Titre de l\'article / du chapitre'), 'authors' => __('Auteur'), 'external_ref' => __('Référence fournisseur'), 'internal_ref' => __('Référence interne'), 'all' => __('Sur tous les champs'));
		return $searchFields;
	}

	public function is_duplicate($data)
	{
		$conditions = array('OR' => array());
		if(isset($data['Order']['pmid']))
		{
			$conditions['OR']['pmid'] = $data['Order']['pmid'];
		}
		if(isset($data['Order']['doi']))
		{
			$conditions['OR']['doi'] = $data['Order']['doi'];
		}
		if(!empty($data['Order']['year']) && !empty($data['Order']['volume']) && !empty($data['Order']['pages']))
		{
			$conditions['OR']['AND'] = array();
			$conditions['OR']['AND']['year'] = $data['Order']['year'];
			$conditions['OR']['AND']['volume'] = $data['Order']['volume'];
			$conditions['OR']['AND']['pages'] = $data['Order']['pages'];
		}

		if(!empty($conditions['OR']))
		{
			$results = $this->find('all', array('conditions' => $conditions));
			if($results)
				return $results[0]['Order']['id'];
		}
		return 0;
	}

	public function setupDefaults($data)
	{
		//Get information on chosen service. This will define which library is in charge, default origin and default status
		$service = $this->Service->findById($data['Order']['service_id']);

		//If no status is set (guest form used), default is chosen (new or tobevalidated)
		if(!isset($data['Order']['status_id']))
		{
			$condition = $service['Service']['need_validation'] == '1'? 'tobevalidated' : 'new';
			$defaultStatus = $this->Status->find('first', array('conditions' => array('special' => $condition)));
			$data['Order']['status_id'] = $defaultStatus['Status']['id'];
		}

		//Library in charge
		if(!isset($data['Order']['library_id']))
			$data['Order']['library_id'] = $service['Service']['library_id'];

		//Default origin
		if(!isset($data['Order']['origin_id']))
		{
			$defaultOrigin = $this->Origin->find('first', array('conditions' => array('library_id' => $service['Service']['library_id'])));
			if(!$defaultOrigin)
				$defaultOrigin = $this->Origin->find('first', array('conditions' => array('library_id' => '0')));

			$data['Order']['origin_id'] = $defaultOrigin['Origin']['id'];
		}

		//Default priority
		if(!isset($data['Order']['priority']))
		{
			$data['Order']['priority'] = '2';
		}

		//Default input method
		if(!isset($data['Order']['request_by']))
		{
			$data['Order']['request_by'] = 'publicform';
		}

		//Default order datetime
		if(!isset($data['Order']['order_at']) || empty($data['Order']['order_at']))
		{
			$data['Order']['order_at'] = date("Y-m-d H:i:s");
		}

		return $data;
	}

	public function setupSearchConditions($field, $value)
	{
		$value = urldecode($value);
		$conditions = array();
		switch ($field)
		{
			case 'order_at':
			case 'sent_at':
			case 'invoice_at':
				$value = date('Y-m-d', strtotime($value));
				$conditions['DATE(Order.'.$field.')'] = $value;
				break;
			case 'status':
				$conditions['Status.title'] = $value;
				break;
			case 'origin':
				$conditions['Origin.name'] = $value;
				break;
			case 'service':
				$conditions['Service.name'] = $value;
				break;
			case 'name':
				$values = preg_split("/[\s,]+/", $value);
				foreach ($values as &$value)
				{
					$value = '' . $value . '';
				}
				unset($value);
				$conditions['OR'] = array('firstname' => $values, 'surname' => $values);
				break;
			case 'journal_title':
				$value = str_replace('*', '%', $value);
				$conditions['journal_title LIKE'] = $value;
				break;
			case 'article_title':
				$value = str_replace('*', '%', $value);
				$conditions['article_title LIKE'] = $value;
				break;
			case 'authors':
				$conditions['authors LIKE'] = '%' . $value . '%';
				break;
			case 'all':
				$fields = array('Order.id', 'order_at', 'sent_at', 'invoice_at', 'Status.title', 'Origin.name', 'firstname', 'surname', 'mail', 'Service.name', 'isxn', 'pmid', 'doi', 'journal_title', 'article_title', 'authors', 'external_ref', 'internal_ref');
				$conditions['OR'] = array();
				foreach ($fields as $f)
				{
					$conditions['OR'][$f] = $value;
				}
				break;
			default:
				$conditions['Order.'.$field] = $value;
				break;
		}
		return $conditions;
	}

	public function setupEmail($order, $configuration)
	{
		//Subject
		$emailTitle = 'mailto:' . $order['Order']['mail'] . '?subject=' . __('Commande ') . $order['Order']['id'] . ' : ' . rawurlencode($order['Order']['journal_title']) . '&body=';
		//Body
		$emailBody = __('Bonjour') . ',%0A%0A';

		switch ($order['Status']['special'])
		{
			case 'reject':
				$emailBody .= __('Suite à votre commande, nous vous informons que le document n\' est pas disponible.');
				break;
			case 'renew':
				$phpdate = strtotime($order['Order']['renew_at']);
				$emailBody .= __('Suite à votre commande, nous vous informons que le document n\' est pas encore disponible. Sans nouvelle de votre part, votre commande sera retraitée le %s.', date('d.m.Y', $phpdate));
				break;
			default:
				$emailBody .= __('Suite à votre commande de document, nous avons le plaisir de vous transmettre en fichier attaché le document demandé.');
				break;
		}

		$emailBody .= '%0A%0A';

		$fields = array(
			__('Titre') => $order['Order']['article_title'],
			__('Auteurs') => $order['Order']['authors'],
			(strstr($order['Order']['doc_type'], 0, 4) == 'book' ? __('Livre') : __('Périodique')) => $order['Order']['journal_title'],
			__('Volume') => $order['Order']['volume'],
			__('N°') => $order['Order']['issue'],
			__('Suppl.') => $order['Order']['supplement'],
			__('Pages') => $order['Order']['pages'],
			__('Année') => $order['Order']['year'],
			(strstr($order['Order']['doc_type'], 0, 4) == 'book' ? __('ISBN') : __('ISSN')) => $order['Order']['isxn'],
			__('PMID') => $order['Order']['pmid'],
			__('DOI') => $order['Order']['doi'],
			__('Autre identificateur') => $order['Order']['uid'],
			__('Commandé par') => $order['Order']['surname'] . ', ' . $order['Order']['firstname'],
			__('Remarque') => $order['Order']['user_comment'],
		);

		//We print only not empty fields
		foreach ($fields as $fieldName => $fieldValue)
		{
			if(!empty($fieldValue))
			{
				$emailBody .= rawurlencode($fieldName) . ' : ' . rawurlencode($fieldValue) . '%0A';
			}
		}

		if($configuration['Configuration']['mail_auth_info'] == '1')
		{
			$emailBody .= '%0A' . __('Nouveau service : suivez vos commandes d\'articles en temps réel. Vous pouvez vous connecter à l\'adresse %s', Router::url('/', true)).	 '%0A%0A';
			$emailBody .= __('Identifiant') . ' : ' . $order['Order']['mail'] . ' | ' . __('Mot de passe') . ' : ' . substr(hash('md5', strtolower($order['Order']['mail'])), 0, 8) . '%0A';
		}

		//Footer
		$emailBody .= '%0A' . __('Cordialement') . ',%0A%0A';
		$emailBody .= $configuration['Configuration']['library_name'] . '%0A';
		$emailBody .= __('Courriel') . ' : ' . $configuration['Configuration']['library_email'] . '%0A';
		$emailBody .= __('Tél') . ' : '. $configuration['Configuration']['library_tel'] .  '%0A';
		$emailBody .= __('Site web') . ' : ' . $configuration['Configuration']['library_url'];

		return $emailTitle . $emailBody;
	}

	public function fetchContent($type, $uid, $proxy='', $proxyauth='', $identificator="")
	{
		$uid = trim($uid);
		$result = array();

		if($type == 'isbn')
		{
			$isbn = $uid;
			$url = "http://xisbn.worldcat.org/webservices/xid/isbn/".$isbn."?method=getMetadata&format=xml&fl=*";
			$data = $this->fetchData($url, $proxy, $proxyauth);
			$result = $this->parseIsbnResponse($data);
		}
		elseif($type == 'reroid')
		{
			$reroid = $uid;
			$url = "http://opac.rero.ch/gateway?function=MARCSCR&search=KEYWORD&u1=12&rootsearch=KEYWORD&t1=" . $reroid;
			$data = $this->fetchData($url, $proxy, $proxyauth);
			$result = $this->parseReroResponse($data);
		}
		elseif($type == 'pmid')
		{
			$pmid = $uid;
			$url = "http://eutils.ncbi.nlm.nih.gov/entrez/eutils/esummary.fcgi?db=pubmed&retmode=xml&tool=OpenLinker&email=" . $identificator . "&id=" . $pmid;
			$data = $this->fetchData($url, $proxy, $proxyauth);
			$result = $this->parsePubmedResponse($data);
		}
		elseif($type == 'doi')
		{
			$doi = $uid;
			$url = "http://www.crossref.org/openurl/?pid=" . $identificator . "&noredirect=true&id=". $doi;
			$data = $this->fetchData($url, $proxy, $proxyauth);
			$result = $this->parseCrossrefResponse($data);
		}
		elseif($type == 'wosid')
		{
			$wosid = $uid;
			$url = "http://www2.unil.ch/openillink/openlinker/isi/wos.php?ut=".$uids;
			$data = $this->fetchData($url, $proxy, $proxyauth);
			$result = $this->parseWosidResponse($data);
		}

		return $result;
	}

	private function fetchData($url, $proxy='', $proxyauth='')
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if(!empty($proxy))
			curl_setopt($ch, CURLOPT_PROXY, $proxy);
		if(!empty($proxyauth))
		{
			curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
		}

		$res = curl_exec($ch);
		curl_close($ch);

		return $res;
	}

	private function parsePubmedResponse($data)
	{
		$result = array();
		$result['doc_type'] = "article";

		$xml = Xml::build($data, array('return' => 'domdocument'));
		if($xml->getElementsByTagName("ERROR")->length == 0) //No error
		{
			$id = $xml->getElementsByTagName('Id');
			if($id->length > 0)
				$result['uid'] = 'pmid:'.$id->item(0)->nodeValue;
			
			$xpath = new DomXpath($xml);

			$queries = array(
				'journal_title' => '//Item[@Name="FullJournalName"][1]',
				'volume' 		=> '//Item[@Name="Volume"][1]',
				'issue' 		=> '//Item[@Name="Issue"][1]',
				'pages'			=> '//Item[@Name="Pages"][1]',
				'article_title' => '//Item[@Name="Title"][1]',
				'isxn'			=> '//Item[@Name="ISSN"][1]',
				'authors'		=> '//Item[@Name="Author"][1]'
				);

			foreach ($queries as $attribute => $query)
			{
				$response = $xpath->query($query);
				if($response->length > 0)
					$result[$attribute] = $response->item(0)->nodeValue;
			}

			$year = $xpath->query('//Item[@Name="PubDate"][1]');
			if($year->length > 0)
				$result['year'] = substr($year->item(0)->nodeValue, 0, 4);
		}
		else
		{
			$result['error'] = $xml->getElementsByTagName("ERROR")->item(0)->nodeValue;
		}

		return $result;
	}

	private function parseCrossrefResponse($data)
	{
		$result = array();

		$xml = Xml::build($data, array('return' => 'domdocument'));

		$statusNode = $xml->getElementsByTagName('query');
		if($statusNode->length==0)
		{
			$result['error'] = __("Une erreur est survenue lors de la requête");
			return $result;
		}

		if($xml->getElementsByTagName('query')->item(0)->getAttribute('status') == "resolved")
		{
			if($xml->getElementsByTagName('doi')->length > 0)
			{
				$doi = $xml->getElementsByTagName('doi')->item(0);
				$result['uid'] = 'doi:'.$doi->nodeValue;
				switch ($doi->getAttribute('type'))
				{
				case 'book_title':
					$result['doc_type'] = "book";
					break;
				case 'book_content':
					$result['doc_type'] = "bookitem";
					break;
				case 'conference_paper':
					$result['doc_type'] = "conference";
					break;
				case 'report-paper_title':
					$result['doc_type'] = "other";
					break;
				case 'journal_article':
					$result['doc_type'] = "article";
					break;
				case 'journal_issue':
					$result['doc_type'] = "journal";
					break;
				default:
					$result['doc_type'] = "other";
					break;
				}
			}
			if($xml->getElementsByTagName('journal_title')->length > 0)
				$result['journal_title'] = $xml->getElementsByTagName('journal_title')->item(0)->nodeValue;
			elseif($xml->getElementsByTagName('volume_title')->length > 0)
				$result['journal_title'] = $xml->getElementsByTagName('volume_title')->item(0)->nodeValue;
			if($xml->getElementsByTagName('year')->length > 0)
				$result['year'] = $xml->getElementsByTagName('year')->item(0)->nodeValue;
			if($xml->getElementsByTagName('volume')->length > 0)
				$result['volume'] = $xml->getElementsByTagName('volume')->item(0)->nodeValue;
			if($xml->getElementsByTagName('issue')->length > 0)
				$result['issue'] = $xml->getElementsByTagName('issue')->item(0)->nodeValue;
			$result['pages'] = '';
			if($xml->getElementsByTagName('first_page')->length > 0)
				$result['pages'] = $xml->getElementsByTagName('first_page')->item(0)->nodeValue . '-';
			if($xml->getElementsByTagName('last_page')->length > 0)
				$result['pages'] .= $xml->getElementsByTagName('last_page')->item(0)->nodeValue;			
			if($xml->getElementsByTagName('article_title')->length > 0)
				$result['article_title'] = $xml->getElementsByTagName('article_title')->item(0)->nodeValue;

			$result['authors'] = "";
			$contributors = $xml->getElementsByTagName('contributor');
			foreach ($contributors as $contributor)
			{
				if($contributor->getAttribute('contributor_role') == "author")
				{
					$result['authors'] .= empty($result['authors'])?'':', ';
					$result['authors'] .= $contributor->getElementsByTagName('surname')->item(0)->nodeValue . ' ' . strtoupper(substr($contributor->getElementsByTagName('given_name')->item(0)->nodeValue, 0, 1));
				}
			}
			if($xml->getElementsByTagName('issn')->length > 0)
			{
				$result['isxn'] = $xml->getElementsByTagName('issn')->item(0)->nodeValue;
				if(!strpos($result['isxn'], '-'))
				{
					$result['isxn'] = substr($result['isxn'], 0, 4) . '-' . substr($result['isxn'], 4, 4);
				}
			}
			elseif($xml->getElementsByTagName('isbn')->length > 0)
				$result['isxn'] = $xml->getElementsByTagName('isbn')->item(0)->nodeValue;
		}
		else
		{
			$result['error'] = $xml->getElementsByTagName('msg')->item(0)->nodeValue;
		}
		return $result;
	}

	private function parseIsbnResponse($data)
	{
		$result = array();
		$result['doc_type'] = 'book';

		$xml = Xml::build($data, array('return' => 'domdocument'));
		$rspElement = $xml->getElementsByTagName("rsp");
		if($rspElement->length == 0 || $rspElement->item(0)->getAttribute("stat") != "ok")
		{
			$result['error'] = "Référence introuvable.";
		}
		elseif($xml->getElementsByTagName("isbn")->length > 0)
		{
			$isbnElement = $xml->getElementsByTagName("isbn")->item(0);
			$result['year'] = $isbnElement->getAttribute("year");
			$result['edition'] = $isbnElement->getAttribute("ed");
			$result['journal_title'] = $isbnElement->getAttribute("title");
			$result['authors'] = $isbnElement->getAttribute("author");
			$result['isxn'] = $isbnElement->nodeValue;
		}
		else
		{
			$result['error'] = "Référence introuvable.";
		}

		return $result;
	}

	private function parseWosidResponse($data)
	{
		//TODO
	}

	private function parseReroResponse($data)
	{
		//TODO
	}
}

?>