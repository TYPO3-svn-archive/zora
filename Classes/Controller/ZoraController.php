<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package zora
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Zora_Controller_ZoraController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * zoraRepository
	 *
	 * @var Tx_Zora_Domain_Repository_ZoraRepository
	 */
	protected $zoraRepository;

	/**
	 * zoraObject
	 *
	 * @var Tx_Zora_Domain_Model_Zora
	 */
	protected $zoraObject;

	/**
	 * zoraUrl
	 *
	 * @var string
	 */
	protected $zoraUrl = 'http://www.zora.uzh.ch/';

	/**
	 * itemTypes
	 *
	 * @var array
	 */
	protected $itemTypes = array(
			array ('key' =>    1,  'zoraKey' => 'article', 'name' => 'Journal Article'),
			array ('key' =>    2,  'zoraKey' => 'book_section', 'name' => 'Book Section'),
			array ('key' =>    4,  'zoraKey' => 'conference_item', 'name' => 'Conference or Workshop Item'),
			array ('key' =>    8,  'zoraKey' => 'monograph', 'name' => 'Monograph'),
			array ('key' =>   16,  'zoraKey' => 'dissertation', 'name' => 'Dissertation'),
			array ('key' =>   32,  'zoraKey' => 'habilitation', 'name' => 'Habilitation'),
			array ('key' =>   64,  'zoraKey' => 'newspaper_article', 'name' => 'Newspaper Article'),
			array ('key' =>  128,  'zoraKey' => 'edited_scientific_work', 'name' => 'Edited Scientific Work'),
			array ('key' =>  256,  'zoraKey' => 'working_paper', 'name' => 'Working Paper'),
			array ('key' =>  512,  'zoraKey' => 'published_research_report', 'name' => 'Published Research Report'),
			array ('key' => 1024,  'zoraKey' => 'scientific_publication_in_electronic_form', 'name' => 'Scientific Publication in Electronic Form')
	);

	/**
	 * injectZoraRepository
	 *
	 * @param Tx_Zora_Domain_Repository_ZoraRepository $zoraRepository
	 * @return void
	 */
	public function injectZoraRepository(Tx_Zora_Domain_Repository_ZoraRepository $zoraRepository) {
		$this->zoraRepository = $zoraRepository;
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
				// has Zora Repository Object?
				$this->zoraObject = $this->zoraRepository->findByUid($this->settings['savedSearchId']);
				// create a new zora object if necessary
				if(!isset($this->zoraObject)){
					$this->zoraObject = $this->objectManager->create('Tx_Zora_Domain_Model_Zora');
					$this->zoraObject->initializeObject();
					$this->zoraRepository->add($this->zoraObject);
				}
				$flex =  $this->zoraObject->getFlexForm();	
				$flexService = new Tx_Extbase_Service_FlexFormService();
				$flexArray = $flexService->convertFlexFormContentToArray($this->zoraObject->getFlexForm());	
				if(!is_array($flexArray)) 
					return;
				$flexArray['zoraQueryType'] = $this->zoraObject->getZoraQueryType();	
			
				// get raw data or update data if necessary 
				// getLastUpdate is a DateTime object!!
				if( (strlen($this->zoraObject->getSerialized()) == 0) || 
						(time()-$this->zoraObject->getLastUpdate()->getTimestamp()) > $flexArray['refreshTime'] ){
					$ar = array();
					$raw = $this->curlExec($flexArray);
					if(!strlen($raw)){
						$this->flashMessages->add('No Data');
						return;
					}
					$documents = array();
					if($this->convertEprintToArray($raw, $documents)){
						$ar['documents'] = $documents;
						$offset = $this->zoraObject->getLastUpdate()->getOffset();
						$this->zoraObject->setLastUpdate(time());
						$ar['lastUpdate'] = time()+$offset;
						$ar['error'] = 0;
						$ar['count'] = sizeof($documents);
						$ar['query'] = $flexArray['query'];
						$this->zoraObject->setSerialized(serialize($ar));
						$a = unserialize($this->zoraObject->getSerialized());;
					}
					else {
						$this->flashMessages->add('No Data / no array');
						$ar['error'] = 2;
					}
				}
				// already updated retrieve array
				else 
					$ar = unserialize($this->zoraObject->getSerialized());
				// list qery
				//$ar['listQuery'] = 1;
				$this->view->assign('ar', $ar);
	}

	/**
	 * action show
	 *
	 * @param $zora
	 * @return void
	 */
	public function showAction(Tx_Zora_Domain_Model_Zora $zora) {
		$this->view->assign('zora', $zora);
	}

	/**
	 * curlExec
	 *
	 * @param $flexArray
	 * @return $mixed
	 */
	public function curlExec(&$flexArray) {
		// saved Search
		if($flexArray['zoraQueryType'] == 0){ 				
			$query = $this->zoraUrl."cgi/saved_search/export_zora_XMLforCMS.xml?savedsearchid=".$flexArray['searchId']."&_output=XMLforCMS&_action_export=1&screen=Public::SavedSearch";
		}
		// advanced search
		elseif($flexArray['zoraQueryType'] == 1){   
//			$query = "cgi/search/advanced/export_zora_XMLforCMS.xml";
			$query .= "?screen=Public::EPrintSearch";
			$query .= "&_action_export=1";
			$query .= "&output=XMLforCMS";
			$query .= "&exp=0|1|-date/creators_name/title|archive|-";
			// full text
			if(strlen($flexArray['fullText'])) 
				$query .= "|_fulltext_:_fulltext_:ALL:IN:".$flexArray['fullText'];
			// title
			if(strlen($flexArray['title'])) 
				$query .= "|title:title:ALL:IN:".$flexArray['title'];
			// contributors
			if(strlen($flexArray['contributors'])) 
				$query .= "|creators_name:creators_name:ALL:IN:".$flexArray['contributors'];
			// types (checkboxes)
			if(strlen($flexArray['itemTypes'])){ 
				$str ='';
				foreach($this->itemTypes as $item){
					if(!($item['key'] & $flexArray['itemTypes'])) 
						continue;
					if(strlen($str)) $str .= ' ';
					$str .=$item['zoraKey'];
				}
				$query .= "|type:type:ANY:EQ:".$str;
			}
			$query .= "|-|eprint_status:eprint_status:ALL:EQ:archive|metadata_visibility:metadata_visibility:ALL:EX:show";
			$sr = array( 'search'  => array('/\|/', '/:/', '/\//', '/,/', '/ /'),
									 'replace' => array('%7C' , '%3A', '%2F',  '%2',  'C+'));
			$query = $this->zoraUrl."cgi/search/advanced/export_zora_XMLforCMS.xml".preg_replace($sr['search'],$sr['replace'],$query);
		}
		else{}
		$flexArray['query'] = $query;
		// set URL and other appropriate options
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, FALSE);							// include header in output?
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);		//
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);		// force a new connection
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);		// returns a string instead of outputting it ou directly
		curl_setopt($ch, CURLOPT_URL, $query);						
		$data = curl_exec($ch);
		$str = curl_error($ch);
		// close cURL resource, and free up system resources
		curl_close($ch);
		return $data;
	}

	/**
	 * convertEprintToArray
	 *
	 * @param $rawData
	 * @param $documents
	 * @return true/false
	 */
	protected function convertEprintToArray($rawData, array &$documents) {
		$ary = json_decode(json_encode((array) simplexml_load_string($rawData)),1);
		// body tag only if error occurs
		if(is_array($ary['body']))
			return false;
		$count = 0;
		// has only one item
		if(is_array($ary['eprint']['@attributes'])){
			$ar1 = array($ary['eprint']);
			unset($ary);
			$ary = array('eprint' => array($ar1[0]));
		}
		foreach ($ary['eprint'] as $pub){
			$temp = '';
			// creators
			$authors = array();
			$editors = array();
			$this->getPersons($pub['creators'], $authors);
			$status = '';
			switch ($pub['full_text_status']){
				case 'public';
				$status = '';
				break;
				case 'restricted';
				$status = 'Item availability restricted.';
				break;
				case 'none';
				$status = 'Full text not available from this repository';
				break;
			}
		
			$link = $icon = $temp = '';
			if(is_array($pub['documents']) && is_array($pub['documents']['document']) && is_array($pub['documents']['document'][0])){
				$doc = $pub['documents']['document'][0];
				$link = $this->zoraUrl.($doc['eprintid']."/".$doc['pos']."/".$doc['main']);
				switch ($doc['format']){
					case 'application/pdf':
						$docType = 1; //pdf
						$format = 1;
						// todo				$icon = t3lib_extMgm::extRelPath($this->extKey). 'res/application_pdf.png';
						$icon = '<img border="0" src="'.$icon.'"  alt="file" class="ep_doc_icon">';
						break;
				}
			}
			elseif (isset($pub['@attributes']['id']))
				$link = $pub['@attributes']['id'];
			
			switch($pub['type']){
				case 'article':
					$docType = 1; 
					break;
				case 'book_section':
					$docType = 2; 
					$this->getPersons($pub['editors'], $editors);
					break;
			} 
			
			$doclink = '';
			if(strlen($link) && strlen($icon)){
				$doclink = '<a href="'.$link.'">'.$icon.'</a>';
			}
			$documents[] =array(
					'docType'     => $docType,
					'reloaded'    => $this->reloaded,
					'count'  			=> ++$count,
					'textStatus'  => $status,
					'title'  			=> $pub['title'],
					'bookTitle' 	=> $pub['book_title'],
					'placeOfPub'  => $pub['place_of_pub'],
					'abstract' 	  => htmlspecialchars($pub['abstract']),
					'link'   			=> $link,
					'format'			=> $format,
					'altText'     => '', //$pub['title'],
					'authors'			=> $authors,
					'editors'			=> $editors,
					'date'    		=> $pub['date'],
					'publication' => $pub['publication'],
					'volume'      => $pub['volume'],
					'number'      => $pub['number'],
					'pageRange'   => $pub['pagerange'],
					'status'			=> $status,
					'doclink'			=> $doclink
			);
		}
		return true;
	}
	protected function getPersons(&$persons, &$authors){
		if(is_array($persons['item']['0']))
			$creators = $persons['item'];
		else
			$creators = array('0' => $persons['item']);
		
		foreach($creators as $creator){
			if(is_array($creator['name'])){
				$family = $creator['name']['family'];
				$given  = $creator['name']['given'];
			}
			else {
				$family = $creator['family'];
				$given  = $creator['given'];
			}
			$authors[] = array(
					'author' => $family.', '.$given,
					'link'   => ($this->zoraUrl.('view/authors/'.($family).'=3A'.($creator['index']).'=3A=3A.html'))
			);
		}
		
	}
}
?>