<?php
/**
 * This file contains the AnonController Class
 *
 */


/**
 * Controller for General (non logged in) user
 *
 * @author gerry.guinane
 *
 */



class MemberController extends Controller {



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
        $this->controllerType='GENERAL';
        parent::__construct($user,$db,$pageTitle);
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
            $page = $this->getArray['pageID'];
            $page = explode('/',$this->getArray['pageID']);
            switch ($page[0]) {
                case "home":
                    //create objects to generate view content
                    $contentModel = new MemberHome($this->user,$this->db, $this->postArray ,$this->pageTitle, strtoupper($this->getArray['pageID']),$this->getArray['pageID']);
                    $navigationModel = new NavigationMember($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$navigationModel,$contentModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_1_panel.php';  //load the view
                    break;
                case 'logout':
                    $this->user->logout();
                    $this->userLoggedIn=FALSE;
                    header('location: '.$_SERVER['PHP_SELF'].'?pageID=home');
                    break;
                case 'b':
                    if (isset($page[2])) {
                        $contentModel = new MemberPost($this->user, $this->db, $this->postArray, $this->pageTitle, strtoupper($this->getArray['pageID']), $this->getArray['pageID']);
                        $navigationModel = new NavigationMember($this->user, $this->getArray['pageID']);
                        array_push($this->controllerObjects, $navigationModel, $contentModel);
                        $data = $this->getPageContent($contentModel, $navigationModel);  //get the page content from the models
                        $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                        //update the view
                        include_once 'views/view_navbar_1_panel.php'; //load the view
                    }
                    else {
                        $contentModel = new MemberBoard($this->user, $this->db, $this->postArray, $this->pageTitle, strtoupper($this->getArray['pageID']), $this->getArray['pageID']);
                        $navigationModel = new NavigationMember($this->user, $this->getArray['pageID']);
                        array_push($this->controllerObjects, $navigationModel, $contentModel);
                        $data = $this->getPageContent($contentModel, $navigationModel);  //get the page content from the models
                        $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                        //update the view
                        include_once 'views/view_navbar_1_panel.php'; //load the view
                    }
                    break;
                case 'user':
                    if (isset($page[1])) {
                        $contentModel = new MemberUserPage($this->user, $this->db, $this->postArray, $this->pageTitle, strtoupper($this->getArray['pageID']), $this->getArray['pageID']);
                        $navigationModel = new NavigationMember($this->user, $this->getArray['pageID']);
                        array_push($this->controllerObjects, $navigationModel, $contentModel);
                        $data = $this->getPageContent($contentModel, $navigationModel);  //get the page content from the models
                        $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                        //update the view
                        include_once 'views/view_navbar_1_panel.php'; //load the view
                    }
                    break;
                default:
                    //no valid  $pageID  selected
                    //create objects to generate view content
                    $contentModel = new MemberHome($this->user,$this->db, $this->postArray ,$this->pageTitle,'HOME',$this->getArray['pageID']);
                    $navigationModel = new NavigationMember($this->user, 'home');
                    array_push($this->controllerObjects,$navigationModel,$contentModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_1_panel.php';  //load the view
                    break;
            }
        }
        else {//no page selected and NO page ID passed in the URL
            //no page selected - blank $pageID- default loads HOME page
            //create objects to generate view content
            $contentModel = new MemberHome($this->user,$this->db, $this->postArray ,$this->pageTitle,'HOME','home');
            $navigationModel = new NavigationMember($this->user, 'home');
            array_push($this->controllerObjects,$navigationModel,$contentModel);
            $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models
            $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
            //update the view
            include_once 'views/view_navbar_1_panel.php';  //load the view
        }
    }



}


