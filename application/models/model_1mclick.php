<?php


class Model_1mclick extends CI_Model{

    public function isBanned($ip=''){

             $query = $this->db->get_where('user', array('IP' => $ip));
                     
        if ($query->num_rows() > 0) {
            	
            	return true;
            
            } else {
            	 
            	return false;
            }
       }
   
    
    public function userGet($ip=''){  
        
        $query = $this->db->get_where('user', array('IP' => $ip));
        
        if ($query->num_rows() > 0) {
            	
              $row = $query->row(); 
            
            	return $row;
            
            } else {
            	 
            	return 0;
            }
        
    }
    //engelleme icin
    public function userSet($ip='',$sayac=0){
        
        $this->db->set('ip', $ip); 
        $this->db->set('sayac', $sayac);
        $this->db->set('tarih', date('d.m.Y H:i:s',time()));
        $this->db->insert('user'); 
                
        if ($this->db->affected_rows() > 0) {
            	
              return true;
            
            } else {
            	 
              return false;
            }
        
    } 
    //engeli kaldirmak icin
    public function userDel($ip=''){
        
       
            $this->db->delete('user', array('IP' => $ip));
            
            if($this->db->affected_rows() > 0){
                return 1;
            }else{
                return 0;
            } 
            
         
        
    } 
    
    
    //tiklamada kullanilicak
    public function sayacUpdate($sayac=0){
        
        //$sayac = $sayac +1;
        
        $this->db->set('sayac', $sayac);  
        $this->db->update('sayac'); 

        if ($this->db->affected_rows() > 0) {
            	
              return true;
            
            } else {
            	 
              return false;
            }
        
    } 
     //tiklamada kullanilicak
    public function sureUpdate($sure=0){
        
        //$sayac = $sayac +1;
        
        $this->db->set('dakika', $sure);  
        $this->db->update('sayac'); 

        if ($this->db->affected_rows() > 0) {
            	
              return true;
            
            } else {
            	 
              return false;
            }
        
    } 
    //sayac sifirla
    public function sayacReset(){
        
        $sayac = 0;
        
        $this->db->set('sayac', $sayac);  
        $this->db->update('sayac'); 

        if ($this->db->affected_rows() > 0) {
            	
              return 1;
            
            } else {
            	 
              return 0;
            }
        
    }     
    //anasayfada sayac icin
    public function sayacGet(){
        
         $query = $this->db->query("SELECT * FROM sayac;");
        
        if ($query->num_rows() > 0) {
            	
              $row = $query->row(); 
            
            	return $row;
            
            } else {
            	 
            	return 0;
            }
        
    }
   
    public function odulList(){
        
        $query = $this->db->query("SELECT * FROM kupon");       
        
    	$res = $query->result_array();
 
    	if($this->db->affected_rows() > 0){
    		 //print_r($res);
    		return $res;
    			
    	}else{
    		 
    		return FALSE;
    			
    	}
    }   
    
    public function kazandiMi($sayac){
        
        $query = $this->db->get_where('kupon', array('kuponSayac' => $sayac));
        
        if ($query->num_rows() > 0) {
            
                return true;
                          
            } else {
            	 
            	return false;
            }
    }      
    //kazanan icin ve panel icin
    public function odulGet($sayac){
        
        $query = $this->db->get_where('kupon', array('kuponSayac' => $sayac));
        
        if ($query->num_rows() > 0) {
            	
              $row = $query->row(); 
            
            	return $row;
            
            } else {
            	 
            	return 0;
            }
    }      
    //panelden odul ekleme
    public function odulSet($sayac=0,$kuponKodu='',$odulAdi=''){
        
        $this->db->set('kuponKodu', $kuponKodu); 
        $this->db->set('kuponSayac', $sayac);
        $this->db->set('odulAdi', $odulAdi);
        $this->db->insert('kupon'); 
                
        if ($this->db->affected_rows() > 0) {
            	
              return true;
            
            } else {
            	 
              return false;
            }
    }
    //panelden odul kaldirma
    public function odulDel($kuponSayac){            
             
            $this->db->delete('kupon', array('kuponSayac' => $kuponSayac));
            
            if($this->db->affected_rows() > 0){
                return 1;
            }else{
                return 0;
            } 
                     
    }
    
        

} 

