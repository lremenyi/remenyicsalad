<?php
/**
 *  Site's header model
 * 
 *  This class is the model for the header controller.
 * 
 *  PHP version 5
 * 
 *  @author     Reményi Gergely <gergo@remenyicsalad.hu>
*/
class Header extends Model {
    
    public function getUsersName() {
        
        $sql = 'SELECT name FROM user_details WHERE user_id=? LIMIT 1';
        $stmt = $this->sc->PDOprepare($sql);
        if (!($res = $stmt->executeBind(array($_SESSION['id'])))) {
            throw new LoggableException(1016);
        }
        
        return $stmt->fetchOneData();
        
    }
    
    public function getAvatarImg() {
        
        $sql = 'SELECT image FROM user_details WHERE user_id=? LIMIT 1';
        $stmt = $this->sc->PDOprepare($sql);
        if (!($res = $stmt->executeBind(array($_SESSION['id'])))) {
            throw new LoggableException(1016);
        }
        
        return $stmt->fetchOneData();
        
    }
    
    public function getMenu() {
        
        $sql = 'SELECT m.name AS "name",m.icon AS "icon",m.url AS "url" FROM menu AS m INNER JOIN menu_viewable AS r ON m.id=r.menu_id'
                . ' WHERE r.viewable AND user_type=(SELECT level FROM users WHERE id=?) ORDER BY number ASC';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($_SESSION['id']))){
            throw new LoggableException(1016);
        }
       
        $menu = array();
        
        $i = 0;
        while($row = $stmt->fetchAssoc($res)) {
            $menu[$i] = $row;
            $i++;
        }
        
        return $menu;
        
    }
    
    public function isSidebarSmall() {
        
        $sql = 'SELECT small_menu FROM user_settings WHERE user_id=?';
        $stmt = $this->sc->PDOPrepare($sql);
        if(!$res = $stmt->executeBind(array($_SESSION['id']))) {
            throw new LoggableException(1018);
        }
        
        return $stmt->fetchOneData();   
                
    }
    
    public function changeMenuSizeSettings() {
        $sql = 'UPDATE user_settings SET small_menu = NOT small_menu WHERE user_id=?';
        $stmt = $this->sc->PDOPrepare($sql);
        if(!$res = $stmt->executeBind(array($_SESSION['id']))) {
            throw new LoggableException(1019);
        }
    }
    
}