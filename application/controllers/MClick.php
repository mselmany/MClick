<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MClick extends CI_Controller {
    
    private $IP = 0;
    private $SAYAC = 0;
    private $ID = 0 ;
    private $TARIH;
    private $SURE = 36;
    private $yasakMi = FALSE;     
    private $odul = array();
    private $userSAYAC = 0 ;
    
    public function __construct(){
        
            parent::__construct();

            if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
            {
              $this->IP = $_SERVER['HTTP_CLIENT_IP'];
            }
            elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
            {
              $this->IP=$_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else
            {
              $this->IP=$_SERVER['REMOTE_ADDR'];
            }
        
        date_default_timezone_set('Europe/Istanbul');
        
        $this->load->model('model_1MClick');
        
        $this->yasaklimi();
         
        $this->SAYAC = $this->model_1MClick->sayacGet();

       }
    
    private function yasaklimi(){
        
        $this->yasakMi = $this->model_1MClick->isBanned($this->IP);
              
               
        if($this->yasakMi){ //karalistedeyse           
            
            $row = $this->model_1MClick->userGet($this->IP);
            //echo (strcmp($row->IP,$this->IP) == 0);
            
            $this->yasakMi = true;                                    
            $this->ID = $row->id;
            $this->TARIH = $row->tarih;

            $unixTarih = strtotime($this->TARIH );
            $unixArti1saat = ($unixTarih + $this->SURE);
            $unixSuan = time();
            
            if(($unixSuan >= $unixArti1saat)){
                
              $row = $this->model_1MClick->userDel($this->IP);
                      
                if($row){
                    $this->yasakMi = false;
                }
                                    
              }
               
        } 
    }
    
    public function preLoad(){
        $res = array('yasakMi'=>$this->yasakMi,
                     'sayac'=>$this->SAYAC);
        
        echo json_encode($res);
    }
       
	public function index(){
                     
        $this->load->view('view_1MClick');              
       
	}
    
    public function clicked(){
        
        //sayaci  artir                 
            
           if(!$this->yasakMi){
                  $this->SAYAC = $this->SAYAC+1;
                  $userEklendiMi = $this->model_1MClick->userSet($this->IP,$this->SAYAC);
                  $sayacArtti = $this->model_1MClick->sayacUpdate($this->SAYAC);
               
               if($userEklendiMi){
                                       
                    $kazandiMi = $this->model_1MClick->kazandiMi($this->SAYAC);
                   
                    if($kazandiMi){
                        $row = $this->model_1MClick->odulGet($this->SAYAC);
                        echo json_encode(array('kazandiMi'=>$kazandiMi,
                                               'kupon'=>$row->kuponKodu,
                                               'odulAdi'=>$row->odulAdi,
                                               'yasakMi'=>$this->yasakMi,
                                               'sayac'=>$this->SAYAC));
                    }else{
                        echo json_encode(array('kazandiMi'=>$kazandiMi,
                                               'yasakMi'=>$this->yasakMi));
                    }                   
               }
           }else{
               echo json_encode(array('yasakMi'=>$this->yasakMi));
           }
            
                
        //artan sayacla odulSayacini karsilastir
         
        //esitse odulkuponu cek
    }
    
    public function panel(){
        $this->load->view('view_panel');
    }
    
    public function dene(){

        
        
       $row = $this->model_1MClick->userSet($this->IP,$this->SAYAC);
       echo json_encode($row);
        
//         $row = $this->model_1MClick->sayacUpdate($this->SAYAC+1);
//        echo json_encode($row);
            
        //echo date('d.m.Y H:i:s',time());
    }
    
    
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */