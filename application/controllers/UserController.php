<?php
/**
 *  The user controller
 * 
 *  This class is the controller for the user controller.
 * 
 *  PHP version 5
 * 
 *  @author     Reményi Gergely <gergo@remenyicsalad.hu>
*/
class UserController extends Controller {
    
    private $redirect_url="";
    
    public function index() {
        
        // Fetch user information
        $this->set('info', $this->User->getProfileInfo());
        
        // Fetch owned galleries
        $this->set('owned_images', $this->User->getImages());
        
        // Fetch owned events
        $this->set('owned_events', $this->User->getEvents());
        
    }
    
    public function settings($query) {
        
        if(isset($query) && $query != '') {
            throw new LoggableException(1054);
        }
        
        // If details saved
        if(isset($_POST['save_details'])) {
           
            $name = $_POST['name'];
            $email = $_POST['email'];
            $description = strip_tags($_POST['description']);
            $facebook = $_POST['facebook'];
            
            $error = false;
            
            if(!Regex::checkLink($facebook)) {
                $error = true;
                $this->set ('error_details', 'Nem megfelelő  a <strong>link formátum</strong> (Pl: http://ezegyurl.hu, Minimum három és maximum kétszáz karakternek kell lennie!');
            }
            
            if(!Regex::checkDescription($description)) {
                $error = true;
                $this->set ('error_details', '<strong>Túl hosszú</strong> leírás. Maximum 255 karakter lehet!');
            }
            
            if(!Regex::checkEmail($email)) {
                $error = true;
                $this->set ('error_details', 'Nem megfelelő <strong>email cím formátum</strong> (Pl: azen@emailcimem.hu, Minimum öt és maximum ötven karakternek kell lennie!)');
            }
            
            if(!Regex::checkName($name)) {
                $error = true;
                $this->set ('error_details', 'Nem megfelelő <strong>név formátum</strong> (kis, nagybetűk, szóköz használható csak, és minimum öt és maximum ötven karakternek  kell lennie!)');
            }
            
            if(!$error) {
                $this->User->updateUserDetails($name,$email,$description,$facebook);
                $this->_header->set('name',$name);
                $this->set('success_details', 'Az adatok sikeresen <strong>el lettek mentve</strong>');
            }     
        }
        
        if(isset($_POST['save_pass'])) {
            
            $old = $_POST['old_pass_hash'];
            $new = $_POST['new_pass_hash'];
            $renew = $_POST['new_pass_re_hash'];
            
            $error = false;

            if($new != $renew) {
                $error = true;
                $this->set('error_password', 'A megadott új jelszó és ellenőrzése <strong>nem egyezik meg</strong>!');
            }
            
            if(!$this->User->checkOldPassword($old)) {
                $error = true;
                $this->set('error_password', '<strong>Hibás</strong> korábbi jelszó!');
            }
            
            if(!$error) {
                $this->User->updatePassword($new);
                $this->set('success_password', 'Új jelszó <strong>sikeresen beállítva</strong>');
            }
            
        }
        
        if(isset($_POST['save_notif'])) {
            
            if(isset($_POST['new_lot']))
                $notification['lot'] = 1;
            else 
                $notification['lot'] = 0;
            
            
            if(isset($_POST['new_asked_date']))
                $notification['date'] = 1;
            else 
                $notification['date'] = 0;
            
            
            if(isset($_POST['new_event']))
                $notification['event'] = 1;
            else 
                $notification['event'] = 0;
            
            
            if(isset($_POST['new_gallery']))
                $notification['gallery'] = 1;
            else 
                $notification['gallery'] = 0;
            
            
            if(isset($_POST['new_image']))
                $notification['image'] = 1;
            else 
                $notification['image'] = 0;
            
            $this->User->updateUserNotifications($notification);
            $this->set('success_notif', 'Az értesítések beállításának mentése sikeresen megtörtént!');
            
        }
        
        // Load the user details
        $this->set('details', $this->User->getUserDetails());
        
        // Load user notifications
        $this->set('fill_notification', $this->User->getUserNotifications());
        
        
    }
    
    public function profile($query) {
        
        if(isset($query[1])) {
            throw new LoggableException(1041);
        }
        else if(!$this->User->checkUserExists($query[0])) {
            throw new LoggableException(1042);
        }
        else if($this->User->isItMe($query[0])) {
            header("Location: " . PROTOCOL . $_SERVER['HTTP_HOST'] . DS . 'user');
        }
        
        $user = $query[0];
        
        // Fetch user information
        $this->set('info', $this->User->getProfileInfoForUser($user));
        
        // Fetch owned galleries
        $this->set('owned_images', $this->User->getImagesForUser($user));
        
        // Fetch owned events
        $this->set('owned_events', $this->User->getEventsForUser($user));
    }
    
    public function login($query) {
        
        // If the url contains more elements throw errror
        if(isset($query) && $query != '') {
            $this->redirect_url = $query;
        }
        
        if(User::userLoginCheck()) {
            header('Location:' . PROTOCOL . $_SERVER['HTTP_HOST']);
            exit();
        }
        
        if(isset($_POST['login-submit'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            try {
                $this->User->loginFunction($username,$password);
                if($this->redirect_url != '') {
                    header('Location: ' . PROTOCOL . $_SERVER['HTTP_HOST'] . DS . $this->redirect_url);
                }
                else {
                    header('Location: ' . PROTOCOL . $_SERVER['HTTP_HOST']);
                }
            }
            catch (ErrorException $eex) {
                switch($eex->getMessage()) {
                    case 'empty_username':
                        $this->set('login_error', '<strong>Üres</strong> a <strong>felhasználónév</strong> mező!');
                    break;
                    case 'wrong_username_format':
                        $this->set('login_error', '<strong>Hibás felhasználónév</strong> formátum!');
                    break;
                    case 'empty_password':
                        $this->set('login_error', '<strong>Üres jelszó</strong> mező!');
                    break;
                    case 'locked':
                        $this->set('login_error', 'A <strong>fiók zárolva lett</strong>, a túl sok bejelentkezési kísérlet miatt. Írj a Gerinek!');
                    break;
                    case 'wrong':
                        $this->set('login_error', '<strong>Rossz felhasználónév</strong> vagy <strong>jelszó!</strong>');
                    break;
                }
            }
            catch (LoggableException $lex) {
                throw $lex;
            }
            
        }
        
    }
    
    public function logout($query) {
        
         // If the url contains more elements throw errror
        if(isset($query) && $query != '') {
            throw new LoggableException(1012);
        }
        
        try {
            // If not logged in
            if(!User::userLoginCheck()){
                header('Location: ' . PROTOCOL . $_SERVER['HTTP_HOST']);
                exit();
            }
            // If logged in
            else {
                 session_unset($_SESSION['admin_id']);
                 session_unset($_SESSION['admin_name']);
                 session_unset($_SESSION['admin_login_string']);
                 session_unset($_SESSION['admin_language']);
                 header('Location: ' . PROTOCOL . $_SERVER['HTTP_HOST']);
             }
        }
        catch (LoggableException $lex) {
            throw $lex;
        }
        
    }
    
}