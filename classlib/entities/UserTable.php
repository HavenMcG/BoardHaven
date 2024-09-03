<?php
class UserTable extends TableEntity {

    function __construct($databaseConnection){
        parent::__construct($databaseConnection,'user');  //the name of the table is passed to the parent constructor
    }

    public function validate_login($email, $password, $encryptPW){

        if($encryptPW) { //encrypt the password
            $password = hash('ripemd160', $password);
        }

        $this->SQL="SELECT * FROM user WHERE Email='$email' AND Password='$password'";


        //execute the query
        try {
            $rs = $this->db->query($this->SQL);
        }
        catch (mysqli_sql_exception $e) { //catch the exception
            $this->MySQLiErrorNr = $e->getCode();
            $this->MySQLiErrorMsg = $e->getMessage();
            return false;
        }

        //check the credentials
        if ($rs->num_rows === 1 && $rs) {
            //valid username and password combination entered.
            //check if the user login is enabled.

            $row = $rs->fetch_assoc();
            return true;

        }
        else {
            return FALSE; //user credentials are not correct
        }
    }

    public function change_password($postArray,$user){
        
        //get the values entered in the registration form contained in the $postArray argument      
        extract($postArray);
    
        //add escape to special characters      
        $pass1 = addslashes($pass1);
        $pass2 = addslashes($pass2);
        $password = addslashes($password);
        $userID = $user->getUserID();

        //check old password is valid before changing
        if($this->validate_login($userID, $password, $user->getPWEncrypted())) {
            //encrypt the password if required
            if($user->getPWEncrypted()){
                $pass1 = hash('ripemd160', $pass1);       
            }  
            
            //construct the UPDATE SQL 
            $this->SQL="UPDATE user SET PassWord='$pass1' WHERE userID='$userID'";   
            
            //execute the query
            try {
                $rs = $this->db->query($this->SQL);
            }
            catch (mysqli_sql_exception $e) { //catch the exception
                $this->MySQLiErrorNr = $e->getCode();
                $this->MySQLiErrorMsg = $e->getMessage();
                return false;
            }
 
            //check the insert query worked
            if ($this->db->affected_rows === 1 && $rs) { return TRUE; }
            else { return FALSE; }
        }
        else { return FALSE; }  //user did not provide valid old password
    }


    public function insert_row($username, $email, $password) {
        $this->SQL = "
            INSERT INTO `user` (`Username`, `Email`, `Password`) VALUES
            ('$username', '$email', '$password');
        ";

        try {
            $rs=$this->db->query($this->SQL);
        } catch (mysqli_sql_exception $e) { //catch the exception
            $this->MySQLiErrorNr=$e->getCode();
            $this->MySQLiErrorMsg=$e->getMessage();
            return false;
        }
        if ($rs) return true;
        else return false;
    }

    public function get_by_id($id) {
        $this->SQL = "SELECT * FROM user WHERE user.Id=$id";
        $rs = $this->db->query($this->SQL);
        return $rs;
    }

    public function username_exists($username) {
        $this->SQL = "SELECT EXISTS (SELECT NULL FROM user u WHERE u.Username = '$username') AS 'name_taken'";
        $rs = $this->db->query($this->SQL);
        return (bool)$rs;
    }

    public function email_exists($email) {
        $this->SQL = "SELECT EXISTS (SELECT NULL FROM user u WHERE u.Email = '$email') AS 'email_taken'";
        $rs = $this->db->query($this->SQL);
        return (bool)$rs;
    }

    public function get_id_by_username($username) {
        $this->SQL = "SELECT Id FROM user WHERE Username='$username'";
        $rs = $this->db->query($this->SQL);
        $row = $rs->fetch_assoc();
        return $row['Id'];
    }

    public function get_id_by_email($email) {
        $this->SQL = "SELECT Id FROM user WHERE Email='$email'";
        $rs = $this->db->query($this->SQL);
        $row = $rs->fetch_assoc();
        return $row['Id'];
    }

    public function is_admin($user_id) {
        if ($user_id == NULL) return false;
        // query checks if user has active administratorship
        $this->SQL = "
            SELECT
                CASE WHEN A.User IS NOT NULL THEN TRUE ELSE FALSE END AS IsAdmin
            FROM user U LEFT JOIN (
                SELECT User
                FROM administratorship
                WHERE (CURRENT_TIME() BETWEEN StartTime AND EndTime) OR (CURRENT_TIME() >= StartTime AND EndTime IS NULL)
            ) A 
            ON U.Id = A.User
            WHERE U.Id = $user_id;
        ";
        $rs = $this->db->query($this->SQL);
        $row = $rs->fetch_assoc();
        return $row['IsAdmin'];
    }

    public function get_active_administratorship($user_id) {
        if ($user_id == NULL) return false;
        $this->SQL = "
            SELECT *
            FROM administratorship
            WHERE
                ((CURRENT_TIME() BETWEEN StartTime AND EndTime) OR (CURRENT_TIME() >= StartTime AND EndTime IS NULL))
                AND User = $user_id
        ";
        $rs = $this->db->query($this->SQL);
        if ($row = $rs->fetch_assoc()) {
            return $row['Id'];
        }
        else return false;
    }
}

