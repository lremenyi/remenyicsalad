<?php

// Create a new lot
$lot = new Lot();

class Lot {
    
    private $sc;
    private $christmasLotResult;
    private $birthdayLotResult;
    
    public function __construct() {
        
        //Define basic home and directory separator consts
        if(!defined('DS')  && !defined('ROOT')) {
            define('DS', DIRECTORY_SEPARATOR);
            define('ROOT', dirname(__FILE__));
            require_once(ROOT . DS . 'SqlConnect.php');
        }
        else {
             require_once(ROOT . DS . 'library' . DS . 'SqlConnect.php');
        }
     
	$this->sc = new SqlConn();
        
        if(defined('DEVELOPMENT_ENVIRONMENT') && DEVELOPMENT_ENVIRONMENT) {
            $done = $this->christmasLot();
            while (!$done) {
                $done = $this->christmasLot();
            }
            $this->updateChristmasLotToDatabase();
            
            $doneBirthday = $this->birthdayLot();
            while (!$doneBirthday) {
                $doneBirthday = $this->birthdayLot();
            }
            $this->updateBirthdayLotToDatabase();
            $this->sendEmailToSubscribers();
        }
        else {
            $cntr = 0;
            if(!$this->isChristmasLotExists()) {
                $done = $this->christmasLot();
                while (!$done) {
                    $done = $this->christmasLot();
                }
                $this->uploadChristmasLotToDatabase();
                $cntr += 1;
            }
            if(!$this->isBirthdayLotExists()) {

                $done = $this->birthdayLot();
                while (!$done) {
                    $done = $this->birthdayLot();
                }
                $this->uploadBirthdayLotToDatabase();
                $cntr += 1;
            }
            if($cntr > 0) {
                $this->sendEmailToSubscribers();
            }
        }
        
    }
    
    public function isChristmasLotExists() {
        
        $sql = 'SELECT id FROM christmas_lot WHERE year=YEAR(CURDATE())';
        $stmt = $this->sc->PDOprepare($sql);
        $stmt->execute();
        
        if($stmt->numRows() > 0) {
            return true;
        }
        
        return false;
        
    }
    
    public function christmasLot() {
        
        // Get group ids from the database
        $groups = $this->getGroupsForChristmasLot();
        
        // Put the groups into the hat and shuffle the hat
        $hat = $groups;
        shuffle($hat);
        shuffle($groups);
        
        // Store for the results
        $result = NULL;
        
        $invalid = false;
        
        for($i=0;$i<count($groups);$i++) {
            if($groups[$i] == $hat[$i]) {
                $invalid = true;
                break;
            }
            else {
                $result[$i]['from_group'] = $groups[$i];
                $result[$i]['to_group'] = $hat[$i];
            }
        }
        
        if($invalid)
            return false;
        if($result == NULL)
            return false;
        
        $this->christmasLotResult = $result;
        return true;
        
    }
    
    public function getGroupsForChristmasLot() {
        
        $sql = 'SELECT id FROM groups ORDER BY RAND()';
        $stmt = $this->sc->PDOprepare($sql);
        $res = $stmt->execute();
        
        $i = 0;
        while($row = $stmt->fetchAssoc($res)) {
            $groups[$i] = $row['id'];
            $i++;
        }
        
        return $groups;
        
    }
    
    public function uploadChristmasLotToDatabase() {
        
        foreach($this->christmasLotResult as $lot) {
            $sql = 'INSERT INTO christmas_lot (from_group,to_group,year) VALUES (?,?,YEAR(CURDATE()))';
            $stmt = $this->sc->PDOprepare($sql);
            if(!$res = $stmt->executeBind(array($lot['from_group'],$lot['to_group']))){
                // PARA
            }
            
        }
        
    }
    
    public function updateChristmasLotToDatabase() {
        
        // Delete prevoius
        $sql = 'DELETE FROM christmas_lot WHERE year=YEAR(CURDATE())';
        $stmt = $this->sc->PDOprepare($sql);
        $stmt->execute();
        
        $this->uploadChristmasLotToDatabase();
        
    }
    
    public function isBirthdayLotExists() {
        
        $sql = 'SELECT id FROM birthday_lot WHERE year=YEAR(CURDATE())';
        $stmt = $this->sc->PDOprepare($sql);
        $stmt->execute();
        
        if($stmt->numRows() > 0) {
            return true;
        }
        
        return false;
        
    }
    
    public function birthdayLot() {
        
        // Get group ids from the database
        $members = $this->getMembersForBirthdayLot();
        
        // Put the members into the hat and shuffle the hat
        $hat = $members;
        shuffle($hat);
        shuffle($members);
        
        // Store for the results
        $result = NULL;
        
        $invalid = false;
        
        for($i=0;$i<count($members);$i++) {
            if($members[$i]['group_id'] == $hat[$i]['group_id']) {
                $invalid = true;
                break;
            }
            else {
                $result[$i]['from_group'] = $members[$i]['group_id'];
                $result[$i]['to_user_id'] = $hat[$i]['user_id'];
                
            }
        }
       
        if($invalid)
            return false;
        if($result == NULL)
            return false;

        $this->birthdayLotResult = $result;
        return true;
    }
    
    public function getMembersForBirthdayLot() {
        
        // Get the groups
        $sql = 'SELECT user_id,group_id FROM user_group_connector ORDER BY RAND()';
        $stmt = $this->sc->PDOprepare($sql);
        $res = $stmt->execute();
        
        $i = 0;
        while($row = $stmt->fetchAssoc($res)) {
            $members[$i] = $row;
            $i++;
        }
        return $members;   
    }
    
    public function uploadBirthdayLotToDatabase() {
        
        foreach($this->birthdayLotResult as $lot) {
            $sql = 'INSERT INTO birthday_lot (from_group,to_user_id,year) VALUES (?,?,YEAR(CURDATE()))';
            $stmt = $this->sc->PDOprepare($sql);
            if(!$res = $stmt->executeBind(array($lot['from_group'],$lot['to_user_id']))){
                // PARA
            }
            
        }
        
    }
    
    public function updateBirthdayLotToDatabase() {
        
        // Delete prevoius
        $sql = 'DELETE FROM birthday_lot WHERE year=YEAR(CURDATE())';
        $stmt = $this->sc->PDOprepare($sql);
        $stmt->execute();
            
        $this->uploadBirthdayLotToDatabase();
        
    }
    
    public function sendEmailToSubscribers() {
        // Send mails to subscribers
        require_once ('PHPMailer.php');
                
        $sql = 'SELECT email, name FROM user_details INNER JOIN user_settings ON user_details.user_id = user_settings.user_id WHERE user_settings.lot';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->execute()) {
            throw new LoggableException(1088);
        }
        $i = 0;
        $add = NULL;
        while($row = $stmt->fetchAssoc($res)) {
            $add[$i] = $row;
            $i++;
        }
        
        if($add != NULL) {
            foreach($add as $new) {
                if(Regex::checkEmail($new['email'])) {
                    $mail = new PHPMailer();
                    try {
                        $mail->IsHTML(true);
                        $mail->CharSet = 'UTF-8';

                        $mail->addReplyTo('gergo@remenyicsalad.hu', 'Reményi Gergely');
                        $mail->setFrom('admin@remenyicsalad.hu', 'ReményiNET Admin');

                        $mail->Subject = 'Születésnapi, karácsonyi sorsolás';
                        $mail->addAddress($new['email']);
                        $mail->Body = sprintf('<p>Kedves %s!</p><p>Az ide karácsonyi és születésnapi sorsolás megtörtént. Ahhoz, hogy megnézd, hogy kiket húztál, látogass el az <a href="http://remenyicsalad.hu/gifting">ajándékozás</a>-hoz!</p><p>Ha a továbbiakben nem szeretnél ilyen e-maileket kapni, akkor a <a href="http://remenyicsalad.hu/user/settings">beállítások</a> alatt az "Email értesítések" panelen tudod ezt kikapcsolni.</p><p>Üdvözlettel:<br>ReményiNET Admin</p>',$new['name']);
                        $mail->send();

                    } catch (phpmailerException $e) {
                    } catch (Exception $e) {
                    }
                }  
            }
        }
    }
    
}

