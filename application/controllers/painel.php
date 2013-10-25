<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Painel extends CI_Controller {

	public function index()	{
	
	    $email = $this->input->post('email');
		$senha = $this->input->post('senha');
		   
        if (($email != EMAIL) || (MD5($senha) != SENHA)){
		
		    $this->load->view('login_painel_view');
			
		} else {
					   
      		 echo 'entrei';  
	        //$data_atual = time("Y/m/d"); // obtém um time stamp da data atual
	        //include('./iBovespa.php'); // arquivo que contém o array iBovespa
	            
	        //echo 'última atualização';             
                                 
             //        $data = strtotime("-$y day", $data_atual);
             //        $arquivo = @fopen("./dados_brutos/COTAHIST_D".date('dmY', $data).".TXT", "r");
		}
	}
}

