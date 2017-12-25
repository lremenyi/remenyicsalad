<?php
/**
 *  Site's header model
 * 
 *  This class is the model for the home controller.
 * 
 *  PHP version 5
 * 
 *  @author     Reményi Gergely <gergo@remenyicsalad.hu>
*/
class Home extends Model {
    
    public function getNewAskedDates() {
             
        $sql = 'SELECT * FROM birthday_gift_date WHERE answered = 0 AND user_id = ?';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$stmt->executeBind(array($_SESSION['id']))) {
            throw new LoggableException(1050);
        }
        
        $num = $stmt->numRows();
        
        $sql1 = 'SELECT * FROM christmas_gift_date WHERE answered = 0 AND group_id = '
                . '(SELECT group_id FROM user_group_connector WHERE user_id = ?)';
        $stmt1 = $this->sc->PDOprepare($sql1);
        if(!$stmt1->executeBind(array($_SESSION['id']))) {
            throw new LoggableException(1050);
        }
        
        $num += $stmt->numRows();
        
        return $num;
    }
    
    public function getGalleries() {
        
        $sql = 'SELECT count(*) FROM galleries';
        $stmt = $this->sc->PDOprepare($sql);
        $stmt->execute();
        
        return $stmt->fetchOneData();
        
    }
    
    public function getImages() {
        
        $sql = 'SELECT count(*) FROM images';
        $stmt = $this->sc->PDOprepare($sql);
        $stmt->execute();
        
        return $stmt->fetchOneData();
        
    }
    
    public function getEvents() {
        
        $sql = 'SELECT count(*) AS numb FROM events WHERE date > CURDATE() AND DATEDIFF(date,CURDATE()) <= 30';
        $stmt = $this->sc->PDOprepare($sql);
        $stmt->execute();
        
        return $stmt->fetchOneData();
        
    }
    
    public function getAllNextEvents() {
        
        $sql = 'SELECT e.id, e.name AS event_name, g.name AS host_name, g.event_color, YEAR(date) AS year, MONTH(date) AS month, DAY(date) AS day,'
                . 'HOUR(date) AS hour, MINUTE(date) AS minute FROM events AS e LEFT JOIN groups AS g '
                . 'ON e.host_id = g.id WHERE date >= CURDATE() ORDER BY date ASC LIMIT 12';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->execute()) {
            throw new LoggableException(1060);
        }
   
        $events = NULL;
        $i = 0;
        while($row = $stmt->fetchAssoc($res)) {
            $events[$i] = $row;
            $i++;
        }
        
        return $events;
        
    }
    
    public function getAllGalleries() {
        
        $sql = 'SELECT id, name FROM galleries ORDER BY id DESC LIMIT 12';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->execute()) {
            throw new LogabbleException(1061);
        }
        
        $galleries = NULL;
        $i = 0;
        while($row = $stmt->fetchAssoc($res)) {
            $galleries[$i] = $row;
            $i++;
        }
        
        if($galleries != NULL) {
            foreach ($galleries as $key => $gallery) {            
                $sql = 'SELECT i.id, i.file FROM gallery_image_connector AS c LEFT JOIN images AS i '
                        . 'ON c.image_id = i.id WHERE c.gallery_id = ? ORDER BY RAND() LIMIT 1';
                $stmt = $this->sc->PDOprepare($sql);
                if(!$res = $stmt->executeBind(array($gallery['id']))) {
                    throw new LogabbleException(1062);
                }
                $galleries[$key]['image'] = $stmt->fetchAssoc($res);
            }
        }
        
        return $galleries;
        
    }
    
    public function getAllImages() {
        
        $sql = 'SELECT c.gallery_id, i.id, i.file FROM gallery_image_connector AS c LEFT JOIN images AS i '
                . 'ON c.image_id = i.id ORDER BY i.id DESC LIMIT 12';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->execute()) {
            throw new LogabbleException(1061);
        }
        
        $images = NULL;
        $i = 0;
        while($row = $stmt->fetchAssoc($res)) {
            $images[$i] = $row;
            $i++;
        }
        
        return $images;
        
    }
    
}