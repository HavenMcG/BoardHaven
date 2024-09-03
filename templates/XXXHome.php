<?php
/**
* This file contains the XXXHome Class Template
* 
*/

use anonymous\AnonUserPage;


/**
 * XXXHome is an extended PanelModel Class
 * 
 * 
 * The purpose of this class is to generate HTML view panel headings and template content
 * for an <em><b>XXX user type home</b></em> page.  The content generated is intended for 3 panel
 * view layouts. 
 * 
 * To use this TEMPLATE - change 'XXX' to the required usertype everywhere it appears 
 * 
 * eg: if you want to define a user type 'SUPPLIER'
 * Rename this file - replace the 'XXX' with 'SUPPLIER' in the file name 
 * Then edit this file to REPLACE ALL 'XXX' in this file with 'SUPPLIER' 
 * Move this file to its correct folder in the project eg /models/panelContent/ 
 * Finally include this file in the index.php 
 * 
 * @author gerry.guinane
 * 
 */


class XXXHome extends PanelModel{
    

    
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
    */  
    function __construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID){  
        $this->modelType='XXXHome';
        parent::__construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID);
    } 


    /**
     * Set the Panel 1 heading 
     */
    public function setPanelHead_1(){
            $this->panelHead_1='<h3>Web Application</h3>';
    }
     /**
     * Set the Panel 1 text content 
     */  
    public function setPanelContent_1(){
        $this->panelContent_1='<p>You are currently logged in as XXX User Type.';
    }      

    /**
     * Set the Panel 2 heading 
     */
    public function setPanelHead_2(){ 
        $this->panelHead_2='<h3>Welcome</h3>';
    }
    
     /**
     * Set the Panel 2 text content 
     */    
    public function setPanelContent_2(){
        $this->panelContent_2='Thank you <b>'.$this->user->getUserFirstName().' '.$this->user->getUserLastName() .'</b> for logging in successfully as a XXX user type to the sample Web Application Framework. Please use the links above to manage this system and other users. <br><br>Don\'t forget to logout when you are done.';
    }  

    /**
     * Set the Panel 3 heading 
     */
    public function setPanelHead_3(){ 
        $this->panelHead_3='<h3>Application Setup</h3>'; 
    } 
    
    
     /**
     * Set the Panel 3 text content 
     */ 
    public function setPanelContent_3(){ 
            $this->panelContent_3='<p>To set up this application read the following <a href="readme/installation.php" target=”_blank” >SETUP INSTRUCTIONS</a></p>';            
    }         



     

}
        