<?php


class NavigationMember implements NavigationInterface {

    /**
     *
     * @var boolean $loggedin User logged in state
     */
    protected $loggedin;

    /**
     *
     * @var String $modelType Identifues this navigation model type
     */
    protected $modelType;

    /**
     *
     * @var String $pageID The currently selected page
     */
    protected $pageID;

    /**
     *
     * @var array $menuNav An array of menu items
     */
    protected $menuNav;

    /**
     *
     * @var User $user  The current user object.
     */
    protected $user;


    /**
     * Class constructor.
     *
     * @param User $user The current user object.
     * @param string $pageID The currently selected page
     */
    function __construct($user,$pageID) {
        $this->loggedin=$user->is_logged_in();
        $this->modelType='NavigationGeneral';
        $this->user=$user;
        $this->pageID=$pageID;
        $this->setmenuNav();
    }

    /**
     * Method to prepare the navigation menu depending on the currently selected page ID.
     *
     * This method implements handlers for each page ID.  It prepares a HTML list item string
     * containing the menu items that will appear in the view. This string may be returned using the
     * getMenuNav() method of this class.
     *
     * If a user is not properly logged in it force redirects to the website home page.
     *
     */
    public function setmenuNav() { // set the menu items depending on the users selected page ID

        //empty string for menu items
        $this->menuNav='';

        //handlers for not logged in user
        switch ($this->pageID) {
            case "home":
                $this->menuNav .= '<li><a href="' . $_SERVER['PHP_SELF'] . '?pageID=user/'.$this->user->username().'">'.$this->user->username().'</a></li>';
                $this->menuNav .= '<li><a href="' . $_SERVER['PHP_SELF'] . '?pageID=logout">Logout</a></li>';
                break;
            default:
                $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                $this->menuNav .= '<li><a href="' . $_SERVER['PHP_SELF'] . '?pageID=user/'.$this->user->username().'">'.$this->user->username().'</a></li>';
                $this->menuNav .= '<li><a href="' . $_SERVER['PHP_SELF'] . '?pageID=logout">Logout</a></li>';
                break;
        }
    }

    /**
     * Getter to return the HTML menu string.
     *
     * @return string Containing  a HTML list item string containing the menu items that will appear in the view.
     */
    public function getMenuNav(){return $this->menuNav;}

    /**
     * Dumps diagnostic information in HTML format relating to the class properties
     */
    public function getDiagnosticInfo(){

        echo '<!-- NAVIGATION GENERAL CLASS PROPERTY SECTION  -->';
        echo '<div class="container-fluid"   style="background-color: #AAAAAA">'; //outer DIV

        echo '<h3>NAVIGATION GENERAL (CLASS) properties</h3>';
        echo '<table border=1 border-style: dashed; style="background-color: #EEEEEE" >';
        echo '<tr><th>PROPERTY</th><th>VALUE</th></tr>';
        echo "<tr><td>pageID</td>   <td>$this->pageID</td></tr>";
        echo "<tr><td>menuNav</td>  <td>$this->menuNav      </td></tr>";
        echo '</table>';
        echo '<p><hr>';
        echo '</div>';
        echo '<!-- END NAVIGATION CLASS PROPERTY SECTION  -->';

    }


}
