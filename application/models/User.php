<?php
/**
 *  The user model
 * 
 *  This class is the model for the user controller.
 * 
 *  PHP version 5
 * 
 *  @author     Reményi Gergely <gergo@remenyicsalad.hu>
*/
class User extends Model {
    
    
    public function getProfileInfo () {
        
        $sql = 'SELECT name, image, email, description, facebook FROM user_details WHERE user_id = ? LIMIT 1';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($_SESSION['id']))) {
            throw new LoggableException(1035);
        }
        
        return $stmt->fetchAssoc($res);
        
    }
    
    public function getImages() {
        
        $sql = 'SELECT images.id,file, gallery_id FROM gallery_image_connector LEFT JOIN images ON image_id = id WHERE uploader_id = ?';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($_SESSION['id']))) {
            throw new LoggableException(1036);
        }
        
        $images = NULL;
        
        $i = 0;
        while($row = $stmt->fetchAssoc($res)) {
            $images[$i] = $row;
            $i++;
        }
        
        return $images;
                
    }

    public function getEvents() {
         $sql = 'SELECT name, where_desc, YEAR(date) AS year, MONTH(date) AS month, DAY(date) AS day, '
                 . 'HOUR(date) AS hour, MINUTE(date) AS minute FROM events WHERE host_id = '
                 . '(SELECT group_id FROM user_group_connector WHERE user_id = ? LIMIT 1)';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($_SESSION['id']))) {
            throw new LoggableException(1037);
        }
        
        $events = NULL;
        
        $i = 0;
        while($row = $stmt->fetchAssoc($res)) {
            $events[$i] = $row;
            $i++;
        }
        
        return $events;
    }
    
    public function checkUserExists($user) {
        
        $sql = 'SELECT id FROM users WHERE username = ?';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($user))) {
            throw new LoggableException(1042);
        }
        
        if($stmt->numRows() != 1)
            return false;
        else
            return true;
        
    }
    
    public function isItMe($user) {
        
        $sql = 'SELECT id FROM users WHERE username = ? LIMIT 1';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($user))) {
            throw new LoggableException(1042);
        }
        
        if($stmt->fetchOneData() != $_SESSION['id'])
            return false;
        else
            return true;
        
    }
    
    public function getProfileInfoForUser ($user) {
        
        $sql = 'SELECT name, image, email, description, facebook FROM user_details WHERE user_id = '
                . '(SELECT id FROM users WHERE username = ?) LIMIT 1';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($user))) {
            throw new LoggableException(1038);
        }
        
        return $stmt->fetchAssoc($res);
        
    }
    
    public function getImagesForUser($user) {
        
        $sql = 'SELECT images.id, file, gallery_id FROM gallery_image_connector LEFT JOIN images ON image_id = id'
                . ' WHERE uploader_id = (SELECT id FROM users WHERE username = ? LIMIT 1)';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($user))) {
            throw new LoggableException(1039);
        }
        
        $images = NULL;
        
        $i = 0;
        while($row = $stmt->fetchAssoc($res)) {
            $images[$i] = $row;
            $i++;
        }
        
        return $images;
                
    }

    public function getEventsForUser($user) {
         $sql = 'SELECT name, where_desc, YEAR(date) AS year, MONTH(date) AS month, DAY(date) AS day, '
                 . 'HOUR(date) AS hour, MINUTE(date) AS minute FROM events WHERE host_id = '
                 . '(SELECT group_id FROM user_group_connector WHERE user_id = '
                 . '(SELECT id FROM users WHERE username = ?) LIMIT 1)';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($user))) {
            throw new LoggableException(1040);
        }
        
        $events = NULL;
        
        $i = 0;
        while($row = $stmt->fetchAssoc($res)) {
            $events[$i] = $row;
            $i++;
        }
        
        return $events;
    }
    
    public function getUserDetails() {
        
        $sql = 'SELECT u.username, YEAR(u.last_login) AS year, MONTH(u.last_login) AS month, '
                . 'DAY(u.last_login) AS day, HOUR(u.last_login) AS hour, MINUTE(u.last_login) AS minute,'
                . 'YEAR(u.last_login) AS year, d.name, d.email, d.image, d.description, d.facebook FROM users AS u '
                . 'LEFT JOIN user_details AS d ON u.id = d.user_id WHERE id = ? LIMIT 1';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($_SESSION['id']))) {
            throw new LoggableException(1053);
        }
        
        return $stmt->fetchAssoc($res);
        
    }
    
    public function updateUserDetails($name,$email,$description,$facebook) {
        
        $sql = 'UPDATE user_details SET name = ?, email = ?, description = ?, facebook = ? WHERE user_id = ?';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($name,$email,$description,$facebook,$_SESSION['id']))) {
            throw new LoggableException(1053);
        }
        
    }
    
    public function checkOldPassword($old) {
        
        // Get the user by id
        $sql = 'SELECT password,salt FROM users WHERE id=? LIMIT 1';
        $stmt = $this->sc->PDOprepare($sql);
        if (!$res = $stmt->executeBind(array($_SESSION['id']))) {
            throw new LoggabletException(1056);
        }
        
        $fetched_password = $stmt->fetchAssoc($res);
        
        // Hash the incoming password
        $hashed_password = hash('sha512', $old . $fetched_password['salt']);
        
        if($hashed_password != $fetched_password['password'])
            return false;
        else 
            return true;
        
    }
    
    public function updatePassword($new) {
        
        $salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        
        $password = hash('sha512', $new . $salt);
        
        $sql = 'UPDATE users SET password = ?, salt = ? WHERE id = ?';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$stmt->executeBind(array($password, $salt, $_SESSION['id']))) {
            throw new LoggableException(1058);
        }
        
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
        
    }
    
    public function getUserNotifications() {
        $sql = 'SELECT lot, date, event, gallery, image FROM user_settings WHERE user_id = ?';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($_SESSION['id']))) {
            throw new LoggableException(1060);
        }
        
        return $stmt->fetchAssoc($res);
        
    }
    
    public function updateUserNotifications($notification) {
        
        $sql = 'UPDATE user_settings SET lot = ?, date = ?, event = ?, gallery = ?, image = ? WHERE user_id = ?';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$stmt->executeBind(array($notification['lot'],$notification['date'],$notification['event'],$notification['gallery'],$notification['image'],$_SESSION['id']))) {
            throw new LoggableException(1059);
        }
        
    }
    
    /**
     * Check if the user is logged in
     * 
     * @return bool Logged in or not logged in
     */
    public static function userLoginCheck() {

        // Check the sessions
        if (isset($_SESSION['id'], $_SESSION['username'], $_SESSION['login_string'])) {

            // Create new PDOConnection
            require_once(ROOT . DS . 'library' . DS . 'SqlConnect.php');
            $sc = new SqlConn();

            // Load the active admin details
            $id = $_SESSION['id'];
            $login_string = $_SESSION['login_string'];
            $user_browser = $_SERVER['HTTP_USER_AGENT'];

            //Match with the database stored data
            $sql = 'SELECT password FROM users WHERE id = ? LIMIT 1';
            $stmt = $sc->PDOprepare($sql);
            if (!$stmt->executeBind(array($id))) {
                throw new LoggableException(11111);
            }
            $res = $stmt->execute();

            if ($stmt->numRows() == 1) {
                $row = $stmt->fetchAssoc($res);
                $login_check = hash('sha512', $row['password'] . $user_browser);

                if ($login_check == $login_string) {
                    return true;
                } else {
                    return false;
                }
            }
            else {
                return false;
            }
        } 
        else {
            return false;
        }
    }
    
    public function loginFunction($username, $password) {
        
        // If username field empty
        if (!isset($username) || $username == '') {
            throw new ErrorException('empty_username');
        }
        
        // If name format is not correct
        if (Regex::checkUserName($username) == false) {
            throw new ErrorException('wrong_username_format');
        }
        // If password is empty
        if (!isset($password) || $password == '') {
            throw new ErrorException('empty_password');
        }

        // Get the user by username
        $sql = 'SELECT id,username,password,salt FROM users WHERE username=? LIMIT 1';
        $stmt = $this->sc->PDOprepare($sql);
        if (!($res = $stmt->executeBind(array($username)))) {
            throw new LoggabletException(1008);
        }
        $user = $stmt->fetchAssoc($res);

        // Check if user exsists
        if ($stmt->numRows() == 1) {

            // Hash the incoming password
            $hashed_password = hash('sha512', $password . $user['salt']);

            // Check if the user is blocked from too many login atempts
            try {
                if ($this->checkBrute($user['id'])) {
                    throw new ErrorException('locked');
                }
                // Check if the password and email match
                else {
                    if ($user['password'] == $hashed_password) {
                        $sql = 'UPDATE users SET last_login=NOW() WHERE id=?';
                        $stmt = $this->sc->PDOprepare($sql);

                        if (!$stmt->executeBind(array($user['id']))) {
                            throw new LoggableException(1009);
                        }

                        // Correct password, get the user agent string and create sessions
                        $user_browser = $_SERVER['HTTP_USER_AGENT'];
                        $_SESSION['id'] = preg_replace('/[^0-9]+/', '', $user['id']);
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['login_string'] = hash('sha512', $hashed_password . $user_browser);
                        
                    }
                    // Password is not correct
                    else {

                        $now = time();

                        $sql = 'INSERT INTO login_attempts(user_id,time) VALUES (?,?)';
                        $stmt = $this->sc->PDOprepare($sql);

                        if (!$stmt->executeBind(array($user['id'], $now))) {
                            throw new LoggableException(1010);
                        }

                        // Wrong email, password exception
                        throw new ErrorException('wrong');
                    }
                }
            } catch (LoggableException $lex) {
                throw $lex;
            }
        } else {
            // Wrong email, password exception
            throw new ErrorException('wrong');
        }
    }
    
    /**
     * Check brute force
     * 
     * @param string $id Incoming user id
     * 
     * @return bool Is checkbrute?
     */
    private function checkBrute($id) {

        $now = time();

        //Login attempts counted from the last 2 hours
        $valid_attempts = $now - 60 * 60 * 2;

        $sql = 'SELECT time FROM login_attempts WHERE user_id = ? AND time > ?';
        $stmt = $this->sc->PDOprepare($sql);

        if (!$stmt->executeBind(array($id, $valid_attempts))) {
            throw new LogabbleException(1011);
        }

        //If more than 9 login attempts then lock
        if ($stmt->numRows() >= 10) {
            return true;
        } else {
            return false;
        }
    }
    
}