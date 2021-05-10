<?php
/**
 * @version     3.15.0
 * @package     com_einsatzkomponente
 * @copyright   Copyright (C) 2017 by Ralf Meyer. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Ralf Meyer <ralf.meyer@mail.de> - https://einsatzkomponente.de
 */
// No direct access
defined('_JEXEC') or die;

		if (!$cid) : $cid = JFactory::getApplication()->input->get('cid', array(), 'array'); endif;

		if (!is_array($cid) || count($cid) < 1)
		{
			JFactory::getApplication()->enqueueMessage(JText::_($this->text_prefix . '_NO_ITEM_SELECTED'), 'error');
		}
		else
		{
		//$model = $this->getModel();
		$params = JComponentHelper::getParams('com_einsatzkomponente');
			// Make sure the item ids are integers
			jimport('joomla.utilities.arrayhelper');
			JArrayHelper::toInteger($cid);
			
		foreach ($cid as $key => $val) {
			
		$query = 'SELECT * FROM #__eiko_einsatzberichte WHERE id = "'.$val.'" and state ="1" LIMIT 1';
		$db = JFactory::getDBO();
		$db->setQuery($query);
		$result = $db->loadObjectList();

		//$kat	= EinsatzkomponenteHelper::getTickerKat ($result[0]->tickerkat); 
		
		$db = JFactory::getDbo();
		$db->setQuery('SELECT MAX(asset_id) FROM #__content');
		$max = $db->loadResult();
		$asset_id = $max+1;

		$link = JRoute::_( JURI::root() . 'index.php?option=com_einsatzkomponente&view=einsatzbericht&id='.$result[0]->id).'&Itemid='.$params->get('homelink','');
		
		$image_intro = str_replace('/', '/', $result[0]->image);
		$image_intro = $db->escape($image_intro);
		if (str_replace('/com_einsatzkomponente/einsatzbilder/thumbs', '', $image_intro)):
		$image_fulltext = str_replace('/thumbs', '', $image_intro);
		endif;
		
		$user = JFactory::getUser(); 
			
		$alias = '';
		$intro = '';
		$fulltext = '';
		
		if ($result[0]->summary) {
		$alias = strtolower($result[0]->summary);
		$alias = str_replace(" ", "-", $alias).'_'.date("Y-m-d", strtotime($result[0]->date1));
		}
		
		if ($result[0]->desc) {
		$intro = $result[0]->desc;
		$intro = strstr($intro, '<hr id="system-readmore" />', true) ; 
		$intro = preg_replace("#(?<=.{".$params->get('article_max_intro','400')."}?\\b)(.*)#is", " ...", $intro, 1);
		$fulltext = str_replace($intro.'<hr id="system-readmore" />', '', $result[0]->desc);
		}

		
   
$data = array();
$data['id']             = $result[0]->article_id;
$data['title'] 			= $result[0]->summary;
$data['alias'] 			= JFilterOutput::stringURLSafe($alias);
$data['introtext'] 		= $intro;

		if ($params->get('article_orgas','1')) :	
					$org = array();
					foreach(explode(',',$result[0]->auswahl_orga) as $value):
						$db = JFactory::getDbo();
						$sql	= $db->getQuery(true);
						$sql
							->select('name')
							->from('#__eiko_organisationen')
							->where('id = "' .$value.'"');
						$db->setQuery($sql);
						$results = $db->loadObjectList();
						if(count($results)){
							$org[] = ''.$results[0]->name.''; 
						}
					endforeach;
					$auswahl_orga=  implode(',',$org); 

					$orgas 		 = str_replace(",", " +++ ", $auswahl_orga);
		$orgas       = '<br/><div class=\"eiko_article_orga\">Eingesetzte Kräfte: '.$orgas.'</div>';
		$data['fulltext'] = $fulltext.$orgas;
		else:
		$data['fulltext'] = $fulltext;
		endif;

$data['state'] 			= 1;
$data['asset_id'] = $asset_id;
$data['catid'] 			= $params->get('article_category','0');
$data['created'] = date("Y-m-d H:i:s", strtotime($result[0]->date1));
$data['created_by'] = $user->id;
$data['modified_by'] = $user->id;
$data['publish_up'] = date("Y-m-d H:i:s", strtotime($result[0]->date1));
$data['images'] = '{"image_intro":"'.$image_intro.'","float_intro":"","image_intro_alt":"","image_intro_caption":"","image_fulltext":"'.$image_fulltext.'","float_fulltext":"","image_fulltext_alt":"","image_fulltext_caption":""}';
$data['urls'] = '{"urla":"'.$link.'","urlatext":"Weitere Informationen über diesen Einsatz im Detailbericht","targeta":"","urlb":"'.$result[0]->presse.'","urlbtext":"'.$result[0]->presse_label.'","targetb":"","urlc":"'.$result[0]->presse2.'","urlctext":"'.$result[0]->presse2_label.'","targetc":""}';
$data['metakey'] 		= $auswahl_orga.','.$params->get('article_meta_key','feuerwehr,einsatzbericht,unfall,feuer,hilfeleistung,polizei,thw,rettungsdienst,hilfsorganisation').',einsatzkomponente';
$data['metadesc'] = $params->get('article_meta_desc','Einsatzbericht');
$data['metadata	'] 		= '{"page_title":"","author":"","robots":""}';
$data['access'] 		= 1;
$data['featured'] 		= $params->get('article_frontpage','1');
$data['language'] 		= '*';

   
// Lets store it!    
$row                        =            JTable::getInstance('Content', 'JTable');
$row->bind($data);
$row->check();
			// Store the row.
			if (!$row->store())
			{
			JFactory::getApplication()->enqueueMessage(JText::_($this->text_prefix . ' '), 'error');
				return false;
			}
//print_r ($row);exit;

		if (!$result[0]->article_id) {
					// Get the new item ID 
					$newId = $row->id;
						 if ($params->get('article_frontpage','1')) :	
						//Artikel als Haupteintrag-Eintrag markieren 
						 $frontpage_query = "INSERT INTO #__content_frontpage SET content_id='".$newId."'";
						 $db = JFactory::getDBO();
						 $db->setQuery($frontpage_query);
						 $db->query();
						 endif;
			}
			else {
				$newId = $result[0]->article_id;
			}

			
		// Joomla-Artikel Id in Einsatzbericht eintragen 
		$query = "UPDATE #__eiko_einsatzberichte SET article_id = '".$newId."' WHERE id = '".$result[0]->id."'";
		$db = JFactory::getDBO();
		$db->setQuery($query);
		$db->query();
		
				
				}
		}
?>