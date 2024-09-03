<?php

class AdminHome extends PanelModel
{

    /**
     * Constructor Method
     *
     * The constructor for the PanelModel class. The ManageSystems class provides the
     * panel content for up to 3 page panels.
     *
     * @param User $user The current user
     * @param MySQLi $db The database connection handle
     * @param Array $postArray Copy of the $_POST array
     * @param String $pageTitle The page Title
     * @param String $pageHead The Page Heading
     * @param String $pageID The currently selected Page ID
     */
    function __construct($user, $db, $postArray, $pageTitle, $pageHead, $pageID)
    {
        $this->modelType = 'MemberHome';
        parent::__construct($user, $db, $postArray, $pageTitle, $pageHead, $pageID);
    }

    /**
     * Set the Panel 1 heading
     */
    public function setPanelHead_1()
    {
        $bt = new BoardTable($this->db);
        $this->panelHead_1 = htmlGen\home\header($this->user);

        if (isset($this->postArray['btn-submit-create-board'])) {
            if ($this->userLoggedIn) {
                $name = $this->postArray['name'];
                if ($bt->insert_row($name,$this->user->id(),'default')) {
                    header('Location: '.$_SERVER['PHP_SELF'].'?pageID=b/'.$name);
                }
                else {
                    $this->panelHead_1.= 'error creating board';
                }
            }
        }
    }


    /**
     * Set the Panel 1 text content
     */
    public function setPanelContent_1() {
        $bt = new BoardTable($this->db);
        $boards = $bt->get_all();
        $this->panelContent_1 = htmlGen\home\board_list($boards,$this->user);
    }

    /**
     * Set the Panel 2 heading
     */
    public function setPanelHead_2()
    {
    }


    /**
     * Set the Panel 2 text content
     */
    public function setPanelContent_2()
    {
    }

    /**
     * Set the Panel 3 heading
     */
    public function setPanelHead_3()
    {
    }


    /**
     * Set the Panel 3 text content
     */
    public function setPanelContent_3()
    {
    }


}
        