<?php
/** 
 *  Basic model class
 * 
 *  This contains the basic modell attributes and methodes.
 *  These are only the database object holder attribute, and the
 *  constructor what creates this object.
 * 
 *  PHP version 5
 * 
 *  @author     Reményi Gergely <gergo@remenyicsalad.hu>
 * 
 *  @var    object  $sc PDO object 
 */
class Model{
 	
    protected $sc;
    private $scmail;
 	
    /**
     * Model constructor
     * 
     * Include the SqlConnect.php and create a new PDO object into the $sc attribute
     * 
     */
    public function __construct() {
	require_once(ROOT . DS . 'library' . DS . 'SqlConnect.php');
	$this->sc = new SqlConn();
        require_once(ROOT . DS . 'library' . DS . 'PHPMailer.php');
        $this->scmail = new SqlConn();
    }
    
    public function newImagesInGalleryEmail($gallery_owner_id,$images_numb,$gallery_id) {
        $sql = 'SELECT email, name FROM user_details INNER JOIN user_settings ON user_details.user_id = user_settings.user_id WHERE user_settings.image AND user_details.user_id = ? AND user_details.user_id <> ? LIMIT 1';
        $stmt = $this->scmail->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($gallery_owner_id,$_SESSION['id']))) {
            throw new LoggableException(1089);
        }
        
        // Email to owner
        $add = $stmt->fetchAssoc($res);
        
        if(Regex::checkEmail($add['email'])) {
            $mail = new PHPMailer();
            try {
                $mail->IsHTML(true);
                $mail->CharSet = 'UTF-8';

                $mail->addReplyTo('gergo@remenyicsalad.hu', 'Reményi Gergely');
                $mail->setFrom('admin@remenyicsalad.hu', 'ReményiNET Admin');
                
                $subject = 'Új képet töltöttek fel a galériádba!';
                $body = sprintf('<p>Kedves %s!</p><p>Új képet töltöttek fel a galériádba. Ahhoz, hogy ezt megnézd, látogass el a <a href="http://remenyicsalad.hu/gallery/view/%d">galériához</a>!</p><p>Ha a továbbiakben nem szeretnél ilyen e-maileket kapni, akkor a <a href="http://remenyicsalad.hu/user/settings">beállítások</a> alatt az "Email értesítések" panelen tudod ezt kikapcsolni.</p><p>Üdvözlettel:<br>ReményiNET Admin</p>',$add['name'],$images_numb,$gallery_id);
            
                $mail->Subject = $subject;
                $mail->addAddress($add['email']);
                $mail->Body = $body;
                $mail->send();
                
            } catch (phpmailerException $e) {
            } catch (Exception $e) {
            }
        }
        
    }
    
    public function newGalleryEmail($gallery_name,$gallery_id) {
        $sql = 'SELECT email, name FROM user_details INNER JOIN user_settings ON user_details.user_id = user_settings.user_id WHERE user_settings.gallery  AND user_details.user_id <> ?';
        $stmt = $this->scmail->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($_SESSION['id']))) {
            throw new LoggableException(1092);
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
                        
                        $subject = 'Új galéria lett feltöltve!';
                        $body = sprintf('<p>Kedves %s!</p><p>Új galéria lett feltöltve "%s" néven. Ahhoz, hogy megnézd ezt, látogass el a <a href="http://remenyicsalad.hu/gallery/view/%d">galériához</a>!</p><p>Ha a továbbiakben nem szeretnél ilyen e-maileket kapni, akkor a <a href="http://remenyicsalad.hu/user/settings">beállítások</a> alatt az "Email értesítések" panelen tudod ezt kikapcsolni.</p><p>Üdvözlettel:<br>ReményiNET Admin</p>',$new['name'],$gallery_name,$gallery_id);

                        $mail->Subject = $subject;
                        $mail->addAddress($new['email']);
                        $mail->Body = $body;
                        $mail->send();

                    } catch (phpmailerException $e) {
                    } catch (Exception $e) {
                    }
                }  
            }
        }
    }
    
    public function newEventEmail($name,$date) {
        $sql = 'SELECT email, name FROM user_details INNER JOIN user_settings ON user_details.user_id = user_settings.user_id WHERE user_settings.event  AND user_details.user_id <> ?';
        $stmt = $this->scmail->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($_SESSION['id']))) {
            throw new LoggableException(1092);
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
                        
                        $subject = 'Új esemény lett rögzítve!';
                        $body = sprintf('<p>Kedves %s!</p><p>Új esemény időpont lett hozzáadva a naptárhoz "%s" néven %s időponttal. Ahhoz, hogy megnézd, látogass el az <a href="http://remenyicsalad.hu/events">események</a>-hez!</p><p>Ha a továbbiakben nem szeretnél ilyen e-maileket kapni, akkor a <a href="http://remenyicsalad.hu/user/settings">beállítások</a> alatt az "Email értesítések" panelen tudod ezt kikapcsolni.</p><p>Üdvözlettel:<br>ReményiNET Admin</p>',$new['name'],$name,$date);

                        $mail->Subject = $subject;
                        $mail->addAddress($new['email']);
                        $mail->Body = $body;
                        $mail->send();

                    } catch (phpmailerException $e) {
                    } catch (Exception $e) {
                    }
                }  
            }
        }
    }
    
    public function birthdayDateEmail($id, $start_date, $end_date) {
        $sql = 'SELECT email, name FROM user_details INNER JOIN user_settings ON user_details.user_id = user_settings.user_id WHERE user_settings.date AND user_details.user_id = ?';
        $stmt = $this->scmail->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($id))) {
            throw new LoggableException(1090);
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
                        
                        $subject = 'Új kérdés érkezett!';
                        $body = sprintf('<p>Kedves %s!</p><p>Valaki új időpontot kérdezett meg tőled %s kezdettel és %s véggel. Ahhoz, hogy válaszolni tudj rá, látogass el az <a href="http://remenyicsalad.hu/gifting">ajándékozás</a>-hoz!</p><p>Ha a továbbiakben nem szeretnél ilyen e-maileket kapni, akkor a <a href="http://remenyicsalad.hu/user/settings">beállítások</a> alatt az "Email értesítések" panelen tudod ezt kikapcsolni.</p><p>Üdvözlettel:<br>ReményiNET Admin</p>',$new['name'],$start_date,$end_date);

                        $mail->Subject = $subject;
                        $mail->addAddress($new['email']);
                        $mail->Body = $body;
                        $mail->send();

                    } catch (phpmailerException $e) {
                    } catch (Exception $e) {
                    }
                }  
            }
        }
        
    }
    
    public function christmasDateEmail($group_id, $start_date, $end_date) {
        $sql = 'SELECT email, name FROM user_details INNER JOIN user_settings ON user_details.user_id = user_settings.user_id WHERE user_settings.date AND user_details.user_id IN (SELECT user_id FROM user_group_connector WHERE group_id = ?)';
        $stmt = $this->scmail->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($group_id))) {
            throw new LoggableException(1091);
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
                        
                        $subject = 'Új kérdés érkezett!';
                        $body = sprintf('<p>Kedves %s!</p><p>Valaki új időpontot kérdezett meg tőled %s kezdettel és %s véggel. Ahhoz, hogy válaszolni tudj rá, látogass el az <a href="http://remenyicsalad.hu/gifting">ajándékozás</a>-hoz!</p><p>Ha a továbbiakben nem szeretnél ilyen e-maileket kapni, akkor a <a href="http://remenyicsalad.hu/user/settings">beállítások</a> alatt az "Email értesítések" panelen tudod ezt kikapcsolni.</p><p>Üdvözlettel:<br>ReményiNET Admin</p>',$new['name'],$start_date,$end_date);

                        $mail->Subject = $subject;
                        $mail->addAddress($new['email']);
                        $mail->Body = $body;
                        $mail->send();

                    } catch (phpmailerException $e) {
                    } catch (Exception $e) {
                    }
                }  
            }
        }
    }
    
}