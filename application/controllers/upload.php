<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {

	public function index()	{
	
	   // verifica se recebeu dados
	   if ($_POST) {
		
		   $email = $this->input->post('email');
		   $senha = $this->input->post('senha');
		   
         // valida os dados de email e senha
		   if (($email != EMAIL) || (MD5($senha) != SENHA)){
		   
			      $data['voltar'] = 'upload';
			      $data['tipo_alerta'] = 'alert-error';
				   $data['mensagem'] = 'Combinação incorreta de email e senha.';
				   $this->load->view('mensagem_view', $data);
				   
			} else {
			
			   // configurações da biblioteca upload
			   $config['upload_path'] = './dados_brutos/';
         	$config['allowed_types'] = 'txt|TXT';
         	$config['max_size'] = '1024';
         	$config['overwrite']  = FALSE;
         	$this->load->library('upload', $config);
         	
            // faz o upload do arquivo      
     	      if (!$this->upload->do_upload("arquivo")) {
     	      
     	         // erro no upload
     	      
               $data['voltar'] = 'upload';
			      $data['tipo_alerta'] = 'alert-error';
				   $data['mensagem'] = $this->upload->display_errors();
				   $this->load->view('mensagem_view', $data);
				   
            } else {

               // sucesso no upload
      		   
	            $data_atual = time("Y/m/d"); // obtém um time stamp da data atual
	            include('./iBovespa.php'); // arquivo que contém o array iBovespa
	            
	            // percorre o array iBovespa
	                                     
	            foreach($iBovespa as $acao) {
	            
                  $array_fec = array();	
                  $x = 0;
                  $y = 0;
                  
                  // busca os últimos 20 arquivos
                  
                  while ($x < 20) {
                  
                     $data = strtotime("-$y day", $data_atual);
                     $arquivo = @fopen("./dados_brutos/COTAHIST_D".date('dmY', $data).".TXT", "r");
                     
                     // caso encontre o arquivo busca os dados da ação da vez
                     
                     if ($arquivo) {
                     
                        while (($linha = fgets($arquivo, 256)) !== false) {
                        
                           // quando encontra a ação obtém os valores necessários
                        
                           if (substr($linha,12,7) == $acao) {
                           
                              if ($x == 0) {
                                 $atualizacao = date('d/m/Y', $data);
                                 $abe = (float) (substr($linha,56,11).'.'.substr($linha,67,2));
                                 $max = (float) (substr($linha,69,11).'.'.substr($linha,80,2));
                                 $min = (float) (substr($linha,82,11).'.'.substr($linha,93,2));
                              }
                              
                              // preenche o array com o volume
                              $array_vol[$x] = (int) substr($linha,170,16);
                              
                              // preenche o array com o fechamento
                              $array_fec[$x] = (float) (substr($linha,115,4).'.'.substr($linha,119,2));
                           }
                                     
                        } // fim do while nas linhas do arquivo
                        $x++;
                     }
                     $y++;            
                  } // fim do while que busca os 20 últimos arquivos
                  
                  // início do preparo do arquivo json com os dados calculados

                  // calcula a média de 20 períodos do volume
                  $y = 0;   
                  foreach($array_vol as $vol) {
                     $y += $vol;   
                  }
                  $med_vol_20 = (int) ($y / 20);
                  
                  if (!empty($array_fec)) {
                  
                     // variável que guarda a saída
                     $saida  = '{"emp":"'.$acao.'",';
                     $saida .= '"abe":'.$abe.',"fec":'.$array_fec[0].',"max":'.$max.',"min":'.$min.',';
                     $saida .= '"vol":'.$array_vol[0].',"mms_vol_20":'.$med_vol_20.',';
                     
                     // calcula as médias do fechamento
                     $y = 0; // guarda a soma
                     $x = 0; // contator
                                          
                     foreach($array_fec as $valor) {
                        $y += $valor;
                        switch ($x) {
                           case 2:
                              $saida .= '"mms_03":'.number_format(($y / 3),"2",'.','').',';
                              break;
                           case 9:
                              $saida .= '"mms_10":'.number_format(($y / 10),"2",'.','').',';
                              break;
                           case 19:
                              $saida .= '"mms_20":'.number_format(($y / 15),"2",'.','');
                              break;
                        }
                        $x++;         
                     }
                     $saida .= "}\n";
                     
                     // escreve os dados no arquivo
                              
                     $this->load->helper('file');
                     if (!write_file('./dados_calculados/'.str_replace('/','',$atualizacao).'.JSON', $saida,'a')) {

                        $data['voltar'] = 'upload';
                        $data['tipo_alerta'] = 'alert-error';
				            $data['mensagem'] = 'Falha ao escrever no arquivo '.$atualizacao.'.JSON';
				            $this->load->view('mensagem_view', $data);

                     }
                  }                  
	            } // fim do foreach em $iBovespa
	            
	            // vai para o controller inicio para atualizar os usuários
	            redirect('inicio/index/true');
	            
	            
				   
			   }
         }
		} else {
		   $this->load->view('upload_view');
		}
	}
}

