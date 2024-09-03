<?php
/**
* This file contains the User Class
* 
*/

/**
 * The user class represents the end user of the application. 
 * 
 * This class is responsible for providing the following functions:
 * 
 * <ul>
 * <li>User registration</li>
 * <li>User Login</li>
 * <li>User Logout</li>
 * <li>Persisting user session data by keeping the $_SESSION array up to date</li>
 *</ul>
 * 
 * @author Gerry Guinane 
 * 
 */


class User {

    protected $session;

    protected $db;            

    protected $id;
    public function id() { return $this->id; }

    protected $username;
    public function username() { return $this->username; }

    protected $email;
    public function email() { return $this->email; }

    protected $time_created;
    public function time_created() { return $this->time_created; }

    protected $is_admin;
    public function is_admin() { return $this->is_admin; }


    protected $postArray;

    protected $is_logged_in;
    public function is_logged_in() { return $this->session->is_logged_in(); }

    protected $encrypt_pw;
    public function getPWEncrypted() { return $this->encrypt_pw; }


    public function getLoginAttempts() { return $this->session->login_attempts(); }

    public function setLoginAttempts($num) { $this->session->set_login_attempts($num); }


    /**
     * Class constructor
     * 
     * @param Session Object $session
     * @param MySQLi Object $database
     * @param boolean $encryptPW  TRUE if passwords are hash encrypted in DB
     * 
     * 
     */
    function __construct($session, $database, $encrypt_pw) {
        $this->is_logged_in = $session->is_logged_in();
        $this->db = $database;
        $this->session = $session;
        
        //get properties from the session object
        $this->id = $session->user_id();
        $this->username = $session->user_username();
        $this->email = $session->user_email();
        $this->time_created = $session->user_time_created();

        $this->is_admin = (new UserTable($this->db))->is_admin($this->id());

        $this->encrypt_pw = $encrypt_pw;
        $this->postArray = array();
    }

    /**
     * Login method. Validates the user credentials provided and returns TRUE 
     * if they match credentials stored in the user table in the database. 
     * 
     * @param String $email
     * @param String $password
     * 
     * @return boolean TRUE if login is successful
     * 
     */
    public function login($email, $password) {

        $userTable = new UserTable($this->db);
        if ($userTable->validate_login($email, $password, $this->encrypt_pw)) {  //check if the login details match
            //query the table for that specific user
            $rs = $userTable->get_by_id($userTable->get_id_by_email($email));

            $row = $rs->fetch_assoc(); //get the users record from the query result

            //then set the session array property values
            $this->session->set_user_id($row['Id']);
            $this->session->set_user_username($row['Username']);
            $this->session->set_user_email($row['Email']);
            $this->session->set_user_time_created($row['TimeCreated']);
            $this->session->set_logged_in(TRUE);

            //update the User class properties
            $this->id = $row['Id'];
            $this->username = $row['Username'];
            $this->email = $row['Email'];
            $this->time_created = $row['TimeCreated'];
            $this->is_admin = $userTable->is_admin($this->id());

            return TRUE;
        }
        else {
            $this->session->set_logged_in(FALSE);
            $this->username = NULL;
            $this->email = NULL;
            $this->is_logged_in = FALSE;
            return FALSE;
        }
    }

    public function logout() {
        if ($this->session->logout()) { return true; }
        else { return false; }
    }

    public function refresh_admin_status() {
        $this->is_admin = (new UserTable($this->db))->is_admin($this->id());
        return $this->is_admin();
    }


    /**
     * Provides diagnostic information in HTML format relating to the User class properties
     * 
     * @return string $diagnostic  Diagnostic information in HTML format relating to the User class properties
     */
    public function getDiagnosticInfo(){
        $diagnostic = '<div class="container-fluid"   style="background-color: #AAAAAA">'; //outer DIV
            $diagnostic .=  '<h3>USER (CLASS)  properties</h3>';
            $diagnostic .=  '<table border=1 border-style: dashed; style="background-color: #EEEEEE" >';
            $diagnostic .=  '<tr><th>PROPERTY</th><th>VALUE</th></tr>';
            $diagnostic .=  "<tr><td>user_id  </td><td>$this->id       </td></tr>";
            $diagnostic .=  "<tr><td>username  </td><td>$this->username     </td></tr>";
            $diagnostic .=  "<tr><td>email  </td><td>$this->email         </td></tr>";
            $diagnostic .=  "<tr><td>time_created  </td><td>$this->time_created         </td></tr>";
            $diagnostic .=  "<tr><td>is_logged_in  </td><td> $this->is_logged_in        </td></tr>";
            $diagnostic .=  "<tr><td>is_admin  </td><td> $this->is_admin        </td></tr>";
            $diagnostic .=  "<tr><td>encrypt_pw  </td><td> $this->encrypt_pw        </td></tr>";
            $diagnostic .=  '</table>';
            $diagnostic .=  '<p><hr>';
        $diagnostic .=  '</div>';
        return $diagnostic;
    }

}
