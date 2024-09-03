<?php
/**
* This file contains the Session Class
* 
*/


/**
 * 
 * The Session Class is responsible for persistance of user data between page requests. 
 * 
 * <ul>
 * <li>Data persistence - the properties of this class are stored in the superglobal array $_SESSION</li>
 * <li>When this class is instantiated it initialises its properties from the application session variables contained in the $_SESSION array. This enables logged on user state to be passed to each page request during a logged on user session.</li>
 * <li>If the $_SESSION array is empty it means tha t no user is logged on so the Session Class initialises the session variables with NULL values.</li>
 *</ul>
 * 
 * 
 * @author Gerry Guinane 
 * 
 */


class Session { 

    private $session_id;
    public function session_id() { return $this->session_id; }

    private $is_logged_in;
    public function is_logged_in() { return $this->is_logged_in; }

    private $user_id;
    public function user_id() { return $this->user_id; }

    private $user_username;
    public function user_username() { return $this->user_username; }

    private $user_email;
    public function user_email() { return $this->user_email; }

    private $user_time_created;
    public function user_time_created() { return $this->user_time_created; }

    private $login_attempts;
    public function login_attempts() { return $this->login_attempts; }

    private $views;
    public function views() { return $this->views; }

    private $last_view_timestamp;
    public function last_view_timestamp() { return $this->last_view_timestamp; }

    private $login_timestamp;
    public function login_timestamp() { return $this->login_timestamp; }


    public function set_user_id($id) {
        $this->user_id = $id;
        $_SESSION['user_id'] = $id;
    }
    public function set_user_username($username) {
        $this->user_username = $username;
        $_SESSION['user_username'] = $username;
    }
    public function set_user_email($email) {
        $this->user_email = $email;
        $_SESSION['user_email'] = $email;
    }
    public function set_user_time_created($time_created) {
        $this->user_time_created = $time_created;
        $_SESSION['user_time_created'] = $time_created;
    }
    public function set_login_attempts($num) {
        $this->login_attempts=$num;
        $_SESSION['login_attempts']=$num;
    }

    /**
     * Constructor
     * 
     * This constructor initialises the $_SESSION variables to initial default values 
     * for first time page visit. 
     * If the page/website has been previously (a valid session key exists) 
     * it retrieves all previously set values from the $_SESSION superglobal array
     * 
     */
    public function __construct(){

        // set the timestamps
        $this->last_view_timestamp = date('Y-m-d H:i:s');
        $_SESSION["last_view_timestamp"] = $this->last_view_timestamp;

        // get the session id from the cookie array
        if (isset($_COOKIE['PHPSESSID'])) {
            $this->session_id = $_COOKIE['PHPSESSID'];
            $_SESSION['session_id'] = $_COOKIE['PHPSESSID'];
        }
        else { // sessionID is not set
            $this->session_id = null;
            $_SESSION['session_id'] = null;
        }

        // initialise session variables
        if (isset($_SESSION['is_logged_in'])) {
            $this->is_logged_in = $_SESSION['is_logged_in'];
        }
        else {
            $_SESSION['is_logged_in'] = FALSE;
            $this->is_logged_in = FALSE;
            $this->login_timestamp = null;
            $_SESSION['login_timestamp'] = $this->login_timestamp;
        }

        if (isset($_SESSION['login_timestamp'])) {
            $this->login_timestamp = $_SESSION['login_timestamp'];
        }

        if (isset($_SESSION['views'])) {  //keep track of the number of page views
            $_SESSION['views'] = $_SESSION['views'] + 1;
            $this->views = $_SESSION['views'];
        }
        else { //initialise for a new session
             $_SESSION['views'] = 1;
             $this->views = 1;
        }

        if (isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
        }
        else {
            $_SESSION['user_id'] = NULL;
            $this->user_id = NULL;
        }

        if (isset($_SESSION['user_username'])) {
            $this->user_username = $_SESSION['user_username'];
        }
        else {
            $_SESSION['user_username'] = NULL;
            $this->user_username = NULL;
        }

        if (isset($_SESSION['user_email'])) {
            $this->user_email = $_SESSION['user_email'];
        }
        else {
            $_SESSION['user_email'] = NULL;
            $this->user_email = NULL;
        }

        if (isset($_SESSION['user_time_created'])) {
            $this->user_time_created = $_SESSION['user_time_created'];
        }
        else {
            $_SESSION['user_time_created'] = NULL;
            $this->user_time_created = NULL;
        }

        if (isset($_SESSION['login_attempts'])) {
            $this->login_attempts = $_SESSION['login_attempts'];
        }
        else {
            $_SESSION['login_attempts'] = 0;
            $this->login_attempts = 0;
        }
    }

    public function set_logged_in($state) {
        // this function can be used to set the logged in state to true or false
        // when set to false it does not kill the session variables or the session cookie
        // it is used for both successful and failed login attempts
        //
        if ($state) {
            $_SESSION['is_logged_in'] = TRUE;
            $this->is_logged_in = TRUE;
            $this->login_timestamp = date('Y-m-d H:i:s');
            $_SESSION['login_timestamp'] = $this->login_timestamp;
        }
        else {
            $_SESSION['is_logged_in'] = FALSE;
            $this->is_logged_in = FALSE;
            $this->set_user_id(NULL);
            $this->set_user_email(NULL);
            $this->set_user_username(NULL);
        }
    }


    /**
     *
     * Implements the logout by resetting the Session class properties and resetting the
     * $_SESSION superglobal array to empty.
     *
     * @return boolean TRUE when logout is completed
     *
     */
    public function logout() {
        // this logout function kills all session variables and expires the session cookie on the client machine
        $this->is_logged_in = FALSE;
        $this->set_user_id(NULL);
        $this->set_user_email(NULL);
        $this->set_user_username(NULL);
        $_SESSION = array(); // destroy all session variables
        if (ini_get("session.use_cookies")) {  // kill the cookie containing the session ID on the client machine
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]);
        }
        return true;
    }


    /**
     * Provides diagnostic information in HTML format relating to the Session class properties
     *
     * @return string $diagnostic Diagnostic information in HTML format relating to the Session class properties
     */
    public function getDiagnosticInfo(){
        $diagnostic = '<!-- SESSION CLASS PROPERTY SECTION  -->';
            $diagnostic .= '<div class="container-fluid"   style="background-color: #AAAAAA">'; //outer DIV
                $diagnostic .= '<h3>SESSION (CLASS) properties</h3>';
                $diagnostic .= '<table border=1 border-style: dashed; style="background-color: #EEEEEE" >';
                $diagnostic .= '<tr><th>PROPERTY</th><th>VALUE</th></tr>';
                $diagnostic .= "<tr><td>session_id  </td>   <td>$this->session_id    </td></tr>";
                $diagnostic .= "<tr><td>is_logged_in  </td>   <td>$this->is_logged_in    </td></tr>";
                $diagnostic .= "<tr><td>user_id  </td>   <td>$this->user_id    </td></tr>";
                $diagnostic .= "<tr><td>user_username  </td>   <td>$this->user_username    </td></tr>";
                $diagnostic .= "<tr><td>user_email  </td>   <td>$this->user_email    </td></tr>";
                $diagnostic .= "<tr><td>user_time_created  </td>   <td>$this->user_time_created    </td></tr>";
                $diagnostic .= "<tr><td>login_attempts  </td>   <td>$this->login_attempts    </td></tr>";
                $diagnostic .= "<tr><td>last_view_timestamp  </td>   <td>$this->last_view_timestamp    </td></tr>";
                $diagnostic .= "<tr><td>login_timestamp  </td>   <td>$this->login_timestamp    </td></tr>";
                $diagnostic .= '</table>';
                $diagnostic .= '<p><hr>';
            $diagnostic .= '</div>';
        $diagnostic .= '<!-- END SESSION CLASS PROPERTY SECTION  -->';
        return $diagnostic;
    }
}
