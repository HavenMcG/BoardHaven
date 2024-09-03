<?php
/**
* This file contains the XXXController Class TEMPLATE
* 
*/

use anonymous\AnonHome;
use anonymous\AnonUserPage;


/**
 * Controller for logged in - XXX user type
 * 
 * To use this TEMPLATE - change 'XXX' to the required usertype everywhere it appears 
 * 
 * eg: if you want to define a user type 'SUPPLIER'
 * Rename this file - replace the 'XXX' with 'SUPPLIER' in the file name 
 * Then edit this file to REPLACE ALL 'XXX' in this file with 'SUPPLIER' 
 * Move this file to its correct folder in the project eg /controllers/ 
 * Finally include this file in the index.php 
 *
 * @author gerry.guinane
 * 
 */


class XXXController extends Controller  {


    /**
     * Constructor Method
     * 
     * The constructor for the Controller class. The Controller class is the parent class for all Controllers.
     * 
     * @param User $user  The current user
     * @param MySQLi  $db The database connection object
     * @param String  $pageTitle The web page title 
     */  
    function __construct($user,$db, $pageTitle) { 
        $this->controllerType='XXX';
        parent::__construct($user,$db, $pageTitle);
    }



    /**
     * Method to update the selected view depending on the currently selected page ID. 
     * 
     * This method implements handlers for each page ID.  It loads the page content and navigation models 
     * as required by the page ID and prepares the $data content array to pass to the view. 
     * It selects and loads the required view. 
     * 
     */
    public function updateView() { //update the VIEW based on the users page selection
        if (isset($this->getArray['pageID'])) { //check if a page id is contained in the URL
            switch ($this->getArray['pageID']) {
                
                //home handlers
                case "home":
                    //create objects to generate view content
                    $contentModel = new XXXHome($this->user,$this->db, $this->postArray ,$this->pageTitle, strtoupper($this->getArray['pageID']),$this->getArray['pageID']);
                    $navigationModel = new NavigationXXX($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$navigationModel,$contentModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_2_panel.php';  //load the view                      
                    break;   
                
                
                case "menuItem1":
                    //create objects to generate view content
                    $contentModel = new UnderConstruction($this->user,$this->db, $this->postArray ,$this->pageTitle, strtoupper($this->getArray['pageID']),$this->getArray['pageID']);
                    $navigationModel = new NavigationXXX($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$navigationModel,$contentModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_2_panel.php';  //load the view                      
                    break;                 
                
                case "menuItem2":
                    //create objects to generate view content
                    $contentModel = new UnderConstruction($this->user,$this->db, $this->postArray ,$this->pageTitle, strtoupper($this->getArray['pageID']),$this->getArray['pageID']);
                    $navigationModel = new NavigationXXX($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$navigationModel,$contentModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_2_panel.php';  //load the view                      
                    break; 

                
                case "logout":                    
                    //Change the login state to false
                    $this->user->logout();
                    $this->userLoggedIn=FALSE;
                    
                    //create objects to generate view content
                    $contentModel = new AnonHome($this->user,$this->db, $this->postArray ,$this->pageTitle, strtoupper($this->getArray['pageID']),$this->getArray['pageID']);
                    $navigationModel = new NavigationAnon($this->user, 'home');
                    array_push($this->controllerObjects,$navigationModel,$contentModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_3_panel.php'; //load the view                  
                    break;   
                             
                default:
                    //no valid $pageID selected by user - default loads HOME page
                    //create objects to generate view content
                    $contentModel = new XXXHome($this->user,$this->db, $this->postArray ,$this->pageTitle, 'HOME','home');
                    $navigationModel = new NavigationXXX($this->user, 'home');
                    array_push($this->controllerObjects,$navigationModel,$contentModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_3_panel.php';
                    break;
            }
        } 
        else {//no page selected and NO page ID passed in the URL 
            //no page selected - default loads HOME page
            //create objects to generate view content
            $contentModel = new XXXHome($this->user,$this->db, $this->postArray ,$this->pageTitle, 'HOME','home');
            $navigationModel = new NavigationXXX($this->user, 'home');
            array_push($this->controllerObjects,$navigationModel,$contentModel);
            $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
            $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
            //update the view
            include_once 'views/view_navbar_3_panel.php';  //load the view
        }
    }

       
     
}


