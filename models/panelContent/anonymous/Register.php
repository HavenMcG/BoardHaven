<?php
/**
 * This file contains the Login Class
 *
 */

/**
 * Login is an extended PanelModel Class
 *
 * The purpose of this class is to generate HTML view panel headings and template content
 * for an  <em><b>not logged in user login</b></em> page.  The content generated is intended for 3 panel
 * view layouts.
 *
 * @author gerry.guinane
 *
 */
class Register extends PanelModel
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
        $this->modelType = 'Register';
        parent::__construct($user, $db, $postArray, $pageTitle, $pageHead, $pageID);
    }


    /**
     * Set the Panel 1 heading
     */
    public function setPanelHead_1()
    {
        $this->panelHead_1 = '<h3>Registration Form</h3>';
    }

    /**
     * Set the Panel 1 text content
     */
    public function setPanelContent_1()
    {
        $this->panelContent_1 = Form::form_register('register');  //this reads an external form file into the string
    }

    /**
     * Set the Panel 2 heading
     */
    public function setPanelHead_2()
    {
        $this->panelHead_2 = '<h3>Instructions</h3>';
    }

    /**
     * Set the Panel 2 text content
     */
    public function setPanelContent_2()
    {
        //process the login details from the login form if the button has been pressed
        if (isset($this->postArray['btn-register'])) {  //check that the login button is pressed
            $username = $this->postArray['username'];
            $username = addslashes($username);
            $email = strtolower($this->postArray['email']);
            $email = addslashes($email);
            $pass1 = $this->postArray['pass1'];
            $pass1 = addslashes($pass1);
            $pass2 = $this->postArray['pass2'];

            if ($pass1 === $pass2) {
                $ut = new UserTable($this->db);
                if ($ut->insert_row($username,$email,$pass1)) {
                    $this->panelContent_2 = 'REGISTRATION SUCCESSFUL<br>You can now log in to your new account.';
                }
                else {
                    $this->panelContent_2 = 'REGISTRATION FAILED<br><ul>';
                    if ($ut->username_exists($username)) $this->panelContent_2 .= '<li>Sorry, that username is already taken.</li>';
                    if ($ut->email_exists($email)) $this->panelContent_2 .= '<li>Email already in use. Login to your account instead.</li>';
                    $this->panelContent_2 .= '</ul>';
                }
            }
            else {
                $this->panelContent_2 .= "Passwords didn't match.";
            }
        }
    }

    /**
     * Set the Panel 3 heading
     */
    public function setPanelHead_3()
    {
        $this->panelHead_3 = '<h3>Panel 3</h3>';
    }

    /**
     * Set the Panel 3 text content
     */
    public function setPanelContent_3()
    {
        $this->panelContent_3 = 'Panel 3 content';
    }


}
