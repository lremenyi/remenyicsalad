<?php
/**
 *  Site's events model
 * 
 *  TThe model for the events
 * 
 *  PHP version 5
 * 
 *  @author     Reményi Gergely <gergo@remenyicsalad.hu>
*/
class Events extends Model {
    
    public function checkEvent($id) {
        
        $sql = 'SELECT * FROM events WHERE id = ?';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$stmt->executeBind(array($id))) {
            throw new LoggableException(1067);
        }
        
        return ($stmt->numRows() == 1);
        
    }
    
    public function getEvents() {
        
        $sql = 'SELECT e.id, e.name, YEAR(date) as year, MONTH(date) AS month, DAY(date) AS day, '
                . 'HOUR(date) as hour, MINUTE(date) as minute, e.host_id, where_desc, event_color '
                . 'FROM events AS e LEFT JOIN groups AS g On e.host_id = g.id';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->execute()) {
            throw new LoggableException(1062);
        }
        
        $events = NULL;
        
        $i = 0;
        while($row = $stmt->fetchAssoc($res)) {
            $events[$i]['id'] = $row['id'];
            $events[$i]['title'] = $row['name'];
            $events[$i]['start'] = $row['year'] . '-' . sprintf('%02d',$row['month']) . '-' . sprintf('%02d',$row['day']) . 'T' . sprintf('%02d',$row['hour']) . ':' . sprintf('%02d',$row['minute']);
            $events[$i]['host'] = $row['host_id'];
            $events[$i]['description'] = $row['where_desc'];
            $events[$i]['editable'] = true;
            $events[$i]['color'] = $row['event_color'];
            $i++;
        }
        
        return $events;
        
    }
    
    public function getHosts() {
        
        $sql = 'SELECT id, name FROM groups';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->execute()) {
            throw new LoggableException(1062);
        }
        
        $hosts = NULL;
        
        $i = 0;
        while($row = $stmt->fetchAssoc($res)) {
            $hosts[$i] = $row;
            $i++;
        }
        
        return $hosts;
        
    }
    
    public function newEvent($name, $date, $desc, $host) {
        $sql = 'INSERT INTO events (name,date,where_desc,host_id) VALUES (?,?,?,?)';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$stmt->executeBind(array($name, $date, $desc, $host))) {
            throw new LoggableException(1063);
        }
        
        $this->newEventEmail($name,$date);
    }
    
    public function updateEvent($id, $name, $date, $desc, $host) {
        $sql = 'UPDATE events SET name = ?, date = ?, where_desc = ?, host_id = ? WHERE id = ? AND date >= CURDATE()';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$stmt->executeBind(array($name, $date, $desc, $host, $id))) {
            throw new LoggableException(1064);
        }
    }
    
    public function deleteEvent($id) {
        $sql = 'DELETE FROM events WHERE id = ?';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$stmt->executeBind(array($id))) {
            throw new LoggableException(1065);
        }
    }
    
}