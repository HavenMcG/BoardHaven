<?php
/**
* This file contains the UnderConstruction Class
* 
*/

use anonymous\AnonUserPage;


/**
 * UnderConstruction is an extended PanelModel Class
 * 
 * The purpose of this class is to generate HTML view panel headings and template content
 * for an <em><b>UNDER CONSTRUCTION</b></em>  page.  The content generated is intended for 3 panel
 * view layouts. 
 * 
 * This class is intended as a TEMPLATE - to be copied and modified to provide
 * specific panel content.  
 *
 * @author gerry.guinane
 * 
 */

class UnderConstruction extends PanelModel {
  
    /**
    * Constructor Method
    * 
    * The constructor for the PanelModel class. The ManageSystems class provides the 
    * panel content for up to 3 page panels.
    * 
    * @param User $user  The current user
    * @param MySQLi $db The database connection handle
    * @param Array $postArray Copy of the $_POST array
    * @param String $pageTitle The page Title
    * @param String $pageHead The Page Heading
    * @param String $pageID The currently selected Page ID
    * 
    */  
    function __construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID){  
        $this->modelType='UnderConstruction';
        parent::__construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID);
    } 

    
    /**
     * Set the Panel 1 heading 
     */
    public function setPanelHead_1(){
        $this->panelHead_1='<h3>Panel 1</h3>';      
    }
    
    /**
    * Set the Panel 1 text content 
    */ 
    public function setPanelContent_1(){
        $this->panelContent_1="Panel 1 content for <b>$this->pageHeading</b> menu item is under construction.";
    }        

    /**
     * Set the Panel 2 heading 
     */
    public function setPanelHead_2(){ 
        $this->panelHead_2='<h3>Panel 2</h3>'; 
    }  
    
    /**
    * Set the Panel 2 text content 
    */ 
    public function setPanelContent_2(){
        $this->panelContent_2="Panel 2 content for <b>$this->pageHeading</b> menu item is under construction.";
    }

    /**
     * Set the Panel 3 heading 
     */
    public function setPanelHead_3(){ 
        $this->panelHead_3='<h3>Panel 3</h3>'; 
    } 
    
    /**
    * Set the Panel 3 text content 
    */ 
    public function setPanelContent_3(){
        $this->panelContent_3= "Panel 3 content for <b>$this->pageHeading</b> menu item is under construction.";
    }        

        
        
}
        