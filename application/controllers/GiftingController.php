<?php
/**
 *  Site's gift controller class
 * 
 *  This shows the lot results for the users
 * 
 *  PHP version 5
 * 
 *  @author     Reményi Gergely <gergo@remenyicsalad.hu> 
*/
class GiftingController extends Controller {
    
    public function index($query) {
        
        if(isset($query) && $query != '') {
            throw new LoggableException(1017);
        }
        
        if(DEVELOPMENT_ENVIRONMENT && isset($_POST['generate'])) {
            include(ROOT . DS . 'library' . DS . 'Lot.php');
        }
        
        // Birthday and christmas panel opened/closed
        $this->set('show_birthday', $this->Gifting->showBirthdayLot());
        $this->set('show_christmas', $this->Gifting->showChristmasLot());
        
        // Get this year's birthdays for this user
        $birthdays = $this->Gifting->getThisYearBirthday();
        if($birthdays == NULL)
            $this->set('no_group', true);
        else {
            $this->set('no_group', false);
            $this->set('birthdays', $birthdays);
        }
        
        // Get which christmas group has been choosen
        $this->set('christmas_to_group', $this->Gifting->getThisYearChristmasGroup());
        // Get persons in that group
        $this->set('christmas',$this->Gifting->getThisYearChristmas());
        
        // Get asked dates
        $this->set('asked', $this->Gifting->getAskedDates());
        
    }
    
    public function xhrShowHideBirthday() {
        $this->Gifting->changeBirthdayCollapse();
    }
    
    public function xhrShowHideChristmas() {
        $this->Gifting->changeChristmasCollapse();
    }
    
    public function xhrGetDatesForBirthday() {
        $id = $_POST['id'];
        $dates = $this->Gifting->getDatesBirthday($id);
        
        echo json_encode($dates);
    }
    
    public function xhrGetDatesForChristmas() {
        
        $id = $_POST['id'];
        $dates = $this->Gifting->getDatesChristmas($id);
        
        echo json_encode($dates);
        
    }
    
    public function xhrSendDate() {
        $error = null;
        $id = $_POST['id'];
        
        // TODO regex
        if($_POST['start_time'] == '' || $_POST['end_time'] == '' || $_POST['id'] == ''|| $_POST['date'] == '') {
            $error['desc'] = 'Üresen hagytad valameyik mezőt';
        }
        else {
            $start_time = explode(':',$_POST['start_time']);
            $end_time = explode(':', $_POST['end_time']);

            if($end_time[0] < $start_time[0] || ($end_time[0] == $start_time[0] && $end_time[1] <= $start_time[1])) {
                $error['desc'] = 'Hibásan adtad meg az időintervallumot';
            }
            else {
                $start = str_replace('.', '-', $_POST['date']) . ' ' . $_POST['start_time'] . ':00';
                $end = str_replace('.', '-', $_POST['date']) . ' ' . $_POST['end_time'] . ':00';

                if(!$res = $this->Gifting->sendDate($id,$start,$end)) {
                    $error['desc'] = 'Nincs jogosultságod ahhoz, hogy tőle kérdezz!';
                }
            }
        }
        
        echo json_encode($error);
        
    }
    
    public function xhrSendChristmasDate() {
        $error = null;
        $id = $_POST['id'];
        
        // TODO regex
        if($_POST['start_time'] == '' || $_POST['end_time'] == '' || $_POST['id'] == ''|| $_POST['date'] == '') {
            $error['desc'] = 'Üresen hagytad valameyik mezőt';
        }
        else {
            $start_time = explode(':',$_POST['start_time']);
            $end_time = explode(':', $_POST['end_time']);

            if($end_time[0] < $start_time[0] || ($end_time[0] == $start_time[0] && $end_time[1] <= $start_time[1])) {
                $error['desc'] = 'Hibásan adtad meg az időintervallumot';
            }
            else {
                $start = str_replace('.', '-', $_POST['date']) . ' ' . $_POST['start_time'] . ':00';
                $end = str_replace('.', '-', $_POST['date']) . ' ' . $_POST['end_time'] . ':00';

                if(!$res = $this->Gifting->sendChristmasDate($id,$start,$end)) {
                    $error['desc'] = 'Nincs jogosultságod ahhoz, hogy tőle kérdezz!';
                }
            }
        }
        
        echo json_encode($error);
    }
    
    public function xhrChangeAnswer() {
        
        $id = explode('-', $_POST['id']);
        
        echo json_encode($this->Gifting->changeTheAnswer($id));
    }
    
    public function xhrDeleteAskedDate() {
        
        $id = $_POST['id'];
        
        $this->Gifting->deleteAskedDate($id);
        
    }
    
    public function xhrDeleteAskedChristmasDate() {
        
        $id = $_POST['id'];
        
        $this->Gifting->deleteAskedChristmasDate($id);
        
    }
    
}

