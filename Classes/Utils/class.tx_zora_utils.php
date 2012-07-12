<?php

//namespace typo3conf\ext\zora\Classes\Utils;

/**
 *
 * @author cfuchs
 *        
 */
class tx_zora_utils {
	
	function addFields ($config) {
		//debug($config,'start');
		$pages = array();
		$ar = explode(',',$config['row']['pages']);
		$str = '';
		foreach($ar as $page){
			$ar = explode('|',$page);
			$ar = explode('pages_',$ar[0]);
			$pages[] = $ar[1];	
		}
		foreach($pages as $page){
			if(strlen($str)) $str .= ',';
			$str .= "'".$page."'";
		}
		//debug($str,"str");
		if(strlen($str) > 0) 
			$config['config']['foreign_table_where'] = preg_replace("(0)","$str",$config['config']['foreign_table_where']);
		//debug($config['config']['foreign_table_where'],'where');
		//$config['items'] = array_merge($config['items'],$pages);
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
				'uid,title',         // SELECT ...
				$config['config']['foreign_table'],     // FROM ...
				'pid in ('.$str.')',    // WHERE...
				'',            // GROUP BY...
				'title',    // ORDER BY...
				''            // LIMIT ...
		);
		$items = array();
		while( $row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			$items[] = array(0 => $row['title'], 1 => $row['uid']);
		}		
		//debug($items,'-->items-----');
		$config['items'] = array(); // remove old items
		$config['items'] = array_merge($config['items'],$items);
		//debug($config, 'config last');
		return $config;
		$optionList = array();
		// add first option
		$optionList[0] = array(0 => 'option1', 1 => 'value1');
		// add second option
		$optionList[1] = array(0 => 'option2', 1 => 'value2');
		$config['items'] = array_merge($config['items'],$optionList);
		return $config;
	}
}

?>