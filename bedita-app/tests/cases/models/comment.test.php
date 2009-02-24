<?php
/*-----8<--------------------------------------------------------------------
 * 
 * BEdita - a semantic content management framework
 * 
 * Copyright 2009 ChannelWeb Srl, Chialab Srl
 * 
 * This file is part of BEdita: you can redistribute it and/or modify
 * it under the terms of the Affero GNU General Public License as published 
 * by the Free Software Foundation, either version 3 of the License, or 
 * (at your option) any later version.
 * BEdita is distributed WITHOUT ANY WARRANTY; without even the implied 
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the Affero GNU General Public License for more details.
 * You should have received a copy of the Affero GNU General Public License 
 * version 3 along with BEdita (see LICENSE.AGPL).
 * If not, see <http://gnu.org/licenses/agpl-3.0.html>.
 * 
 *------------------------------------------------------------------->8-----
 */

/**
 * 
 * @link			http://www.bedita.com
 * @version			$Revision$
 * @modifiedby 		$LastChangedBy$
 * @lastmodified	$LastChangedDate$
 * 
 * $Id$
 */
require_once ROOT . DS . APP_DIR. DS. 'tests'. DS . 'bedita_base.test.php';

class CommentTestCase extends BeditaTestCase {
	
	var $uses = array("Comment", "Document");
	
	function testComment() {
		$this->requiredData(array("document", "comment"));
		$result = $this->Document->save($this->data['document']) ;
		$this->assertNotEqual($result,false);		
		$idDoc = $this->Document->id;

		$this->data['comment']['object_id'] = $idDoc;
		$result = $this->Comment->save($this->data['comment']) ;
		$this->assertNotEqual($result,false);		
		$idComm = $this->Comment->id;

		// load doc and check comments
		$this->Document->containLevel("detailed");
		$result = $this->Document->findById($idDoc);
		$this->assertNotEqual($result,false);		
		pr("Document: ");
		pr($result);
		$this->assertEqual(count($result['Annotation']),1);		
		$this->assertEqual($result['Annotation'][0]['id'], $idComm);		
		$this->Comment->containLevel("detailed");
		$result = $this->Comment->findById($idComm);
		$this->assertNotEqual($result, false);		
		pr("Comment: ");
		pr($result);
		$this->assertEqual($result['description'], $this->data['comment']['description']);		
		$this->assertEqual($result['object_id'], $idDoc);		
		$this->assertEqual($result['ReferenceObject']['id'], $idDoc);		
		
		// remove document
//		$result = $this->Document->delete($idDoc);
//		$this->assertEqual($result, true);		
		// check comment removed
//		$result = $this->Comment->findById($idComm);
//		$this->assertEqual($result, false);				
 	}
	
 	public   function __construct () {
		parent::__construct('Comment', dirname(__FILE__)) ;
	}	
}
?>