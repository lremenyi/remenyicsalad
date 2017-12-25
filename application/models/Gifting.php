<?php
/**
 *  Site's gifting model
 * 
 *  This shows the lot results for the users
 * 
 *  PHP version 5
 * 
 *  @author     Reményi Gergely <gergo@remenyicsalad.hu>
*/
class Gifting extends Model {
    
    
    public function getThisYearBirthday() {
        
        $sql = 'SELECT a.id,a.username,u.name,u.image,YEAR(b.date) AS "year",MONTH(b.date) AS "month",DAY(b.date) AS "day" '
                . 'FROM birthday_lot AS l LEFT JOIN user_details AS u ON l.to_user_id = u.user_id '
                . 'LEFT JOIN birthdays AS b ON u.user_id = b.user_id LEFT JOIN users AS a ON u.user_id = a.id'
                . '  WHERE from_group=(SELECT group_id FROM user_group_connector WHERE user_id=?) AND year=YEAR(CURDATE())'
                . 'ORDER BY MONTH(b.date), DAY(b.date)';
        $stmt = $this->sc->PDOPrepare($sql);
        if(!$res = $stmt->executeBind(array($_SESSION['id']))) {
            throw new LoggableException(1019);
        }
        
        // No member of a group
        if($stmt->numRows() == 0)
            return NULL;
        
        $birthday_gift_to = array();
        
        $i = 0;
        while($row = $stmt->fetchAssoc($res)) {
            $birthday_gift_to[$i] = $row;
            $i++;
        }
        
        return $birthday_gift_to;
        
    }
    
    public function getThisYearChristmasGroup() {
        
        $sql = 'SELECT g.name, g.id FROM christmas_lot AS c INNER JOIN groups AS g ON c.to_group = g.id '
                . 'WHERE from_group=(SELECT group_id FROM user_group_connector WHERE user_id=?) AND year=YEAR(CURDATE())';
        $stmt = $this->sc->PDOPrepare($sql);
        if(!$res = $stmt->executeBind(array($_SESSION['id']))) {
            throw new LoggableException(1021);
        }
        
        return $stmt->fetchAssoc($res);
        
    }
    
    public function getThisYearChristmas() {
        
        $sql = 'SELECT a.username,u.name,u.image FROM christmas_lot AS l LEFT JOIN user_group_connector AS con '
                . 'ON l.to_group = con.group_id INNER JOIN users AS a ON con.user_id = a.id '
                . 'LEFT JOIN user_details AS u ON a.id = u.user_id '
                . 'WHERE from_group=(SELECT group_id FROM user_group_connector WHERE user_id=?) AND year=YEAR(CURDATE())';
        $stmt = $this->sc->PDOPrepare($sql);
        if(!$res = $stmt->executeBind(array($_SESSION['id']))) {
            throw new LoggableException(1022);
        }
        
        $christmas = array();
        $i = 0;
        while($row = $stmt->fetchAssoc($res)) {
            $christmas[$i] = $row;
            $i++;
        }
        
        return $christmas;
    }
    
    
    
    public function showBirthdayLot() {
        
        $sql = 'SELECT show_birthday FROM user_settings WHERE user_id=? LIMIT 1';
        $stmt = $this->sc->PDOPrepare($sql);
        if(!$stmt->executeBind(array($_SESSION['id']))) {
            throw new LoggableException(1020);
        }
        
        return $stmt->fetchOneData();
        
    }
    
    public function showChristmasLot() {
        
        $sql = 'SELECT show_christmas FROM user_settings WHERE user_id=? LIMIT 1';
        $stmt = $this->sc->PDOPrepare($sql);
        if(!$stmt->executeBind(array($_SESSION['id']))) {
            throw new LoggableException(1021);
        }
        
        return $stmt->fetchOneData();
        
    }
    
    public function changeBirthdayCollapse() {
        $sql = 'UPDATE user_settings SET show_birthday = NOT show_birthday WHERE user_id=?';
        $stmt = $this->sc->PDOPrepare($sql);
        if(!$res = $stmt->executeBind(array($_SESSION['id']))) {
            throw new LoggableException(1019);
        }
    }
    
    public function changeChristmasCollapse() {
        $sql = 'UPDATE user_settings SET show_christmas = NOT show_christmas WHERE user_id=?';
        $stmt = $this->sc->PDOPrepare($sql);
        if(!$res = $stmt->executeBind(array($_SESSION['id']))) {
            throw new LoggableException(1020);
        }
    }
    
    public function getDatesBirthday($id) {
        $sql = 'SELECT id,YEAR(start_date) AS start_year, MONTH(start_date) AS start_month,DAY(start_date) AS start_day,'
                . 'HOUR(start_date) AS start_hour, MINUTE(start_date) AS start_min, HOUR(end_date) AS end_hour, MINUTE(end_date) AS end_min'
                . ', answered, answer FROM birthday_gift_date WHERE year=YEAR(CURDATE())'
                . 'AND user_id = ? AND user_id IN (SELECT to_user_id FROM birthday_lot WHERE '
                . 'from_group = (SELECT group_id FROM user_group_connector WHERE user_id = ? LIMIT 1))';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($id, $_SESSION['id']))) {
            throw new LoggableException(1026);
        }
        
        if($stmt->numROws() == 0) 
            return NULL;
        
        $dates = NULL;
        $i = 0;
        while($row = $stmt->fetchAssoc($res)) {
            $dates[$i] = $row;
            $i++;
        }
        
        return $dates;
    }
    
    public function getDatesChristmas($id) {
        $sql = 'SELECT id, YEAR(start_date) AS start_year, MONTH(start_date) AS start_month,DAY(start_date) AS start_day,'
                . 'HOUR(start_date) AS start_hour, MINUTE(start_date) AS start_min, HOUR(end_date) AS end_hour, MINUTE(end_date) AS end_min'
                . ', answered, answer FROM christmas_gift_date WHERE year=YEAR(CURDATE())'
                . 'AND group_id = ? AND group_id = (SELECT to_group FROM christmas_lot WHERE '
                . 'from_group = (SELECT group_id FROM user_group_connector WHERE user_id = ? LIMIT 1))';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($id, $_SESSION['id']))) {
            throw new LoggableException(1034);
        }
        
        if($stmt->numROws() == 0) 
            return NULL;
        
        $dates = NULL;
        $i = 0;
        while($row = $stmt->fetchAssoc($res)) {
            $dates[$i] = $row;
            $i++;
        }
        
        return $dates;
    }
    
    public function sendDate($id,$start_date,$end_date) {
         
        $sql = 'SELECT * FROM birthday_lot AS l LEFT JOIN user_group_connector AS c ON l.from_group = c.group_id '
                . 'WHERE c.user_id = ?';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($_SESSION['id']))) {
            throw new LoggableException(1027);
        }
        if($stmt->numRows() == 0)
            return false;
        
        else {
            $sql = 'INSERT INTO birthday_gift_date (user_id,start_date,end_date,answered,answer,year) '
                    . 'VALUES (?,?,?,0,0,YEAR(CURDATE()))';
            $stmt = $this->sc->PDOprepare($sql);
            if(!$res = $stmt->executeBind(array($id,$start_date,$end_date))) {
                throw new LoggableException(1028);
            }
            $this->birthdayDateEmail($id,$start_date,$end_date);
            return true;
        }
        
    }
    
    public function sendChristmasDate($id,$start_date,$end_date) {
         
        $sql = 'SELECT * FROM christmas_lot WHERE from_group = (SELECT group_id FROM user_group_connector WHERE user_id = ?) '
                . 'AND to_group = ?';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($_SESSION['id'],$id))) {
            throw new LoggableException(1027);
        }
        if($stmt->numRows() == 0)
            return false;
        
        else {
            $sql = 'INSERT INTO christmas_gift_date (group_id,start_date,end_date,answered,answer,year) '
                    . 'VALUES (?,?,?,0,0,YEAR(CURDATE()))';
            $stmt = $this->sc->PDOprepare($sql);
            if(!$res = $stmt->executeBind(array($id,$start_date,$end_date))) {
                throw new LoggableException(1035);
            }
            $this->christmasDateEmail($id,$start_date,$end_date);
            return true;
        }
        
    }
    
    public function getAskedDates() {
        $sql = 'SELECT id,YEAR(start_date) AS start_year, MONTH(start_date) AS start_month,DAY(start_date) AS start_day,'
                . 'HOUR(start_date) AS start_hour, MINUTE(start_date) AS start_min, HOUR(end_date) AS end_hour, MINUTE(end_date) AS end_min'
                . ', answered, answer FROM birthday_gift_date WHERE user_id = ?';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($_SESSION['id']))) {
            throw new LoggableException(1029);
        }
        
        $dates = NULL;
        
        $i = 0;
        while($row = $stmt->fetchAssoc($res)) {
            $dates[$i] = $row;
            $dates[$i]['table'] = 'birthday' ;
            $i++;
        }
        
        $sql1 = 'SELECT id,YEAR(start_date) AS start_year, MONTH(start_date) AS start_month,DAY(start_date) AS start_day,'
                . 'HOUR(start_date) AS start_hour, MINUTE(start_date) AS start_min, HOUR(end_date) AS end_hour, MINUTE(end_date) AS end_min'
                . ', answered, answer FROM christmas_gift_date WHERE group_id = (SELECT group_id FROM user_group_connector WHERE user_id=?) AND year = YEAR(CURDATE())';
        $stmt1 = $this->sc->PDOprepare($sql1);
        if(!$res1 = $stmt1->executeBind(array($_SESSION['id']))) {
            throw new LoggableException(1031);
        }
        while($row1 = $stmt1->fetchAssoc($res1)) {
            $dates[$i] = $row1;
            $dates[$i]['table'] = 'christmas' ;
            $i++;
        }
        
        return $dates;
    }
    
    public function changeTheAnswer($id) {
        
        $sql = 'SELECT answered, answer FROM ' . $id[0] . '_gift_date WHERE id=? AND year = YEAR(CURDATE()) LIMIT 1';
        $stmt = $this->sc->PDOprepare($sql);
        if (!$res = $stmt->executeBind(array($id[1]))) {
            throw new LoggableException(1031);
        }
        
        $row = $stmt->fetchAssoc($res);
        
        $return = NULL;
        
        if($row['answered']) {
            $sql = 'UPDATE ' . $id[0] . '_gift_date SET answer = NOT answer WHERE id = ? AND year = YEAR(CURDATE())';
            $stmt = $this->sc->PDOprepare($sql);
            if (!$res = $stmt->executeBind(array($id[1]))) {
                throw new LoggableException(1032);
            }
            $return = ($row['answer'] ? 'close' : 'check');
        }
        else {
            $sql = 'UPDATE ' . $id[0] . '_gift_date SET answered = 1, answer = 1 WHERE id = ? AND year = YEAR(CURDATE())';
            $stmt = $this->sc->PDOprepare($sql);
            if (!$res = $stmt->executeBind(array($id[1]))) {
                throw new LoggableException(1033);
            }
            $return = 'check';
        }
        
        return $return;
        
    }
    
    public function deleteAskedDate($id) {
        
        $sql = 'DELETE FROM birthday_gift_date WHERE id = ? AND user_id IN (SELECT to_user_id FROM birthday_lot WHERE from_group = '
                . '(SELECT group_id FROM user_group_connector WHERE user_id = ?))';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$stmt->executeBind(array($id,$_SESSION['id']))) {
            throw new LoggableException(1067);
        }
        
    }
    
    public function deleteAskedChristmasDate($id) {
        
        $sql = 'DELETE FROM christmas_gift_date WHERE id = ? AND group_id = (SELECT to_group FROM christmas_lot WHERE from_group = '
                . '(SELECT group_id FROM user_group_connector WHERE user_id = ?) LIMIT 1)';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$stmt->executeBind(array($id,$_SESSION['id']))) {
            throw new LoggableException(1067);
        }
        
    }
    
}
