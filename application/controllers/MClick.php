<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MClick extends CI_Controller {
    
    private $IP = 0;
    private $SAYAC = 0;
    private $ID = 0 ;
    private $TARIH;
    public  $SURE = 30 ;
    private $yasakMi;     
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
        
        $row = $this->model_1MClick->sayacGet();
        $this->SAYAC = $row->sayac; 
        $this->SURE = $row->dakika*60;
        
        $this->yasaklimi();
         
        
        //echo $this->SURE;
        
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
                                               'yasakMi'=>true,
                                               'sayac'=>$this->SAYAC));
                    }else{
                        echo json_encode(array('kazandiMi'=>$kazandiMi,
                                               'yasakMi'=>true));
                    }                   
               }
           }else{
               echo json_encode(array('yasakMi'=>false));
           }
            
                
        //artan sayacla odulSayacini karsilastir
         
        //esitse odulkuponu cek
    }
    
    
    
    public function panel(){
        
        $rows['data'] = $this->model_1MClick->odulList();
        $rows['sure'] = $this->model_1MClick->sayacGet();
        if(!$rows['data']){
            
            $rows['data'] = array ( 0 => array ( 'kuponSayac' => 'veriYok' ,
                                                'kuponKodu' => 'veriYok',
                                                'odulAdi' => 'veriYok',
                                                'sayac' => 'veriYok',
                                                'sure' => 'veriYok') );
            $this->load->view('view_panel',$rows);
            
        }else{ 
           $this->load->view('view_panel',$rows);
        }
        
        
    }
    
    public function add(){  
        
            $this->load->library('form_validation');
			
			$this->form_validation->set_rules('kuponSayac','KUPONSAYAC','required|trim|is_unique[kupon.kuponSayac]');
            $this->form_validation->set_rules('kuponKodu','KUPONKODU','required|trim|xss_clean');
            $this->form_validation->set_message('is_unique','Bu sayac zaten girilmis !'); 
        
        if ($this->form_validation->run()) {
            $sonuc = $this->model_1MClick->odulSet($this->input->post('kuponSayac'),
                                          $this->input->post('kuponKodu'),
                                          $this->input->post('odulAdi'));
            if($sonuc){
                redirect('MClick/panel');
            }else{
                redirect('MClick/panel');
            }
            
        }else{
            $this->panel();
            //redirect('MClick/panel');
        }
       
    }
    
    public function del($kuponSayac){       
        
       $row = $this->model_1MClick->odulDel($kuponSayac);
         if($row){
             redirect('MClick/panel');
         }else{
             redirect('MClick/panel');
         }
      //     echo json_encode(array('inserted' => $row));

    }
    
    public function sureUpdate(){  
        
            $this->load->library('form_validation');
			
			$this->form_validation->set_rules('sure','SAYAC','required|trim|numeric');
            //$this->form_validation->set_rules('kuponKodu','KUPONKODU','required|trim|xss_clean');
            $this->form_validation->set_message('numeric','Sadece rakam girebilirsin !'); 
        
        if ($this->form_validation->run()) {
            $sonuc = $this->model_1MClick->sureUpdate($this->input->post('sure'));
            if($sonuc){
                redirect('MClick/panel');
            }else{
                redirect('MClick/panel');
            }
            
        }else{
            $this->panel();
            //redirect('MClick/panel');
        }
       
    }
    
    public function sifirla(){
        
        $sonuc = $this->model_1MClick->sayacReset();
            if($sonuc){
                redirect('MClick/panel');
            }else{
                redirect('MClick/panel');
            }
    }
    
       
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */