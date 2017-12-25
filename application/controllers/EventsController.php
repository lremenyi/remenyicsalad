<?php
/**
 *  Site's events controler class
 * 
 *  This shows an calendar with the birthdays holidays and events
 * 
 *  PHP version 5
 * 
 *  @author     Reményi Gergely <gergo@remenyicsalad.hu> 
*/
class EventsController extends Controller {
    
    public function index($query) {
        
        if(isset($query) && count($query) != 1) {
            throw new LoggableException(1065);
        }
        
        if(isset($query) && $this->Events->checkEvent($query[0])) {
            $this->set('called_event', $query[0]);
        }
        
        if(isset($_POST['save-new-event'])) {
            
            $date_parts = explode('.',$_POST['new-event-date']);
            $date = $date_parts[0] . '-' . $date_parts[1] . '-' . $date_parts[2] . ' ' . $_POST['new-event-time'] . ':00';           
            $name = $_POST['new-event-name'];
            $description = strip_tags($_POST['new-event-desc']);
            $host = $_POST['new-event-host'];
            
            $error = false;
            
            $hosts_array = NULL;
            $hosts = $this->Events->getHosts();
            $i = 0;
            foreach($hosts as $one_host) {
                $hosts_array[$i] = $one_host['id'];
                $i++;
            }
            
            if(!(in_array($host,$hosts_array))) {
                $error = true;
                $this->set('error_desc', 'Nem létezik ilyen házigazda!');
            }
            if(!Regex::checkEventDescription($description)) {
                $error = true;
                $this->set('error_desc', 'Hibás esemény leírás (maximum 100 karakter lehet)!');
            }
            if(!Regex::checkEventName($name)) {
                $error = true;
                $this->set('error_desc', 'Hibás esemény név (Minimum 5, maximum 30 karakternek kell lennie és bizonyos speciális karaktereket nem tartalmazhat!)');
            }
                    
            if(!$error) {
                $this->Events->newEvent($name, $date, $description, $host);
                $this->set('success_desc', sprintf("A(z) <strong>%s</strong> esemény <strong>sikeresen hozzáadva</strong> a naptárhoz!",$name));
            }
            
        }
        
        if(isset($_POST['delete-event'])) {
            $this->Events->deleteEvent($_POST['event-id']);
        }
        
        if(isset($_POST['save-event'])) {
            
            $id = $_POST['event-id'];
            $date_parts = explode('.',$_POST['event-date']);
            $date = $date_parts[0] . '-' . $date_parts[1] . '-' . $date_parts[2] . ' ' . $_POST['event-time'] . ':00';           
            $name = $_POST['event-name'];
            $description = strip_tags($_POST['event-desc']);
            $host = $_POST['event-host'];
            
            $error = false;
            
            $hosts_array = NULL;
            $hosts = $this->Events->getHosts();
            $i = 0;
            foreach($hosts as $one_host) {
                $hosts_array[$i] = $one_host['id'];
                $i++;
            }
            
            if(!(in_array($host,$hosts_array))) {
                $error = true;
                $this->set('error_desc', 'Nem létezik ilyen házigazda!');
            }
            if(!Regex::checkEventDescription($description)) {
                $error = true;
                $this->set('error_desc', 'Hibás esemény leírás (maximum 100 karakter lehet)!');
            }
            if(!Regex::checkEventName($name)) {
                $error = true;
                $this->set('error_desc', 'Hibás esemény név (Minimum 5, maximum 30 karakternek kell lennie és bizonyos speciális karaktereket nem tartalmazhat!)');
            }
                    
            if(!$error) {
                $this->Events->updateEvent($id, $name, $date, $description, $host);
                $this->set('success_desc', sprintf("A(z) <strong>%s</strong> esemény adatai <strong>sikeresen mentve</strong>!",$name));
            }
            
        }
        
        $this->set('hosts', $this->Events->getHosts());
        
    }
    
    public function xhrFetchEventsToCalendar() {
        
        echo json_encode($this->Events->getEvents());
        
    }
    
}