<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller {

	public function index($atualizar_usuarios = null) {
      
	   $data_atual = time("Y/m/d");
	   
	   // obtém a última atualização   
           $x = 0;
           $atualizacao = FALSE;
      while (!$atualizacao) {
         if (!file_exists("./dados_calculados/".date('dmY',strtotime("-$x day",$data_atual)).".JSON")) {
            $x++;
         } else {
            $atualizacao = date('d/m/Y',strtotime("-$x day",$data_atual));  
         }
      }
      
      // obtém os dados dos três últimos arquivos
      $dados_1 = array(); // dados de hoje
      $dados_2 = array(); // dados de ontem
      $dados_3 = array(); // dados de anteontem
      $x = 0;
      $y = 0;
      while ($y < 3) {
      
         $data = strtotime("-$x day", $data_atual);
         $arquivo = @fopen("./dados_calculados/".date('dmY', $data).".JSON", "r");
                  
         if ($arquivo) {              
            while (($linha = @fgets($arquivo, 8192)) !== false) {            
               switch ($y) {
                  case 0:
                     $dados_1[] = json_decode($linha,TRUE);
                     break;
                  case 1:
                     $dados_2[] = json_decode($linha,TRUE);
                     break;
                  case 2:
                     $dados_3[] = json_decode($linha,TRUE);
                     break;
               } // fim do swicth que direciona ao array conforme o arquivo                
            } // fim do while que percorre o arquivo
            $y++;
         }
         $x++;
      } // fim do while que busca os 3 últimos arquivos de dados calculados
      
      include('./iBovespa.php');
      
      // percorre o array iBovespa fazendo a análise
      
      $x = 0; // índice para percorrer o array dos dados
      
      
      foreach ($iBovespa as $acao) {
      
         // verifica se a ação no iBovespa é mesma nos 3 arquivos conforme a posição (só para conferir)
         if (($acao == $dados_1[$x]['emp']) &&
             ($acao == $dados_2[$x]['emp']) &&
             ($acao == $dados_3[$x]['emp'])) {
             
             /* INÍCIO DA ANÁLISE */
                     
             // verifica se o volume foi acima da média
             if ($dados_1[$x]['vol'] > $dados_1[$x]['mms_vol_20']) {
               
               /* CRUZAMENTO DE MÉDIAS */
               
               // verifica o cruzamento de médias móveis simples de baixo para cima "compra"
               
                  if (($dados_1[$x]['mms_03'] > $dados_1[$x]['mms_10']) &&
                      ($dados_2[$x]['mms_03'] < $dados_2[$x]['mms_10'])) {
                     $matriz[$acao][] = 'MMS03 cruzou MMS10 de baixo para cima';
                  }
               
               
               /* CANDLESTICKS */
               
               // martelo
               /*
                * Um pequeno corpo real no final de uma tendência de baixa;
                * A cor do corpo é indiferente;
                * A sombra inferior deve ser duas ou três vezes maior que o corpo;
                * A sombra superior é inexistente ou muito pequena;
                * (MATSURA p.54)
                */
               
                  if ((($dados_1[$x]['mms_03'] < $dados_2[$x]['mms_03']) &&
                       ($dados_2[$x]['mms_03'] < $dados_3[$x]['mms_03'])) &&
                      ($dados_1[$x]['abe'] > ($dados_1[$x]['min'] + (($dados_1[$x]['max'] - $dados_1[$x]['min']) * 0.66))) && 
                      ($dados_1[$x]['fec'] > ($dados_1[$x]['min'] + (($dados_1[$x]['max'] - $dados_1[$x]['min']) * 0.66)))) {
                       $matriz[$acao][] = 'Martelo';
                  }
               
               
               // Envolvente de alta
               /*
                * Composto por dois candles;
                * Corpo real envolve o corpo real anterior;
                * Corpos reais com cores alternadas;
                * Corpos com sombras inferior e superior muito pequenas;
                * (MATSURA p.56)
                */        
               
                  if (($dados_2[$x]['mms_03'] < $dados_3[$x]['mms_03']) &&
                      ($dados_1[$x]['abe'] < $dados_2[$x]['fec']) && 
                      ($dados_1[$x]['fec'] > $dados_2[$x]['abe']) &&
                      (($dados_1[$x]['max'] - $dados_1[$x]['min']) * 0.5 < ($dados_1[$x]['fec'] - $dados_1[$x]['abe'])) &&
                      (($dados_2[$x]['max'] - $dados_2[$x]['min']) * 0.5 < ($dados_2[$x]['abe'] - $dados_2[$x]['fec']))) {
                       $matriz[$acao][] = 'Envolvente de alta';
                  }
               
               
               // Mulher grávida de alta
               /*
                * Composto por dois candles;
                * Corpo real envolvido pelo corpo real anterior;
                * Corpo real envolvido de cor indiferente;
                * Corpos com sombras inferior e superior muito pequenas;
                * (MATSURA p.57)
                */        
                  if (($dados_1[$x]['mms_03'] < $dados_2[$x]['mms_03']) &&
                      ($dados_2[$x]['mms_03'] < $dados_3[$x]['mms_03']) &&                      
                      ($dados_1[$x]['abe'] > $dados_2[$x]['fec']) && 
                      ($dados_1[$x]['fec'] > $dados_2[$x]['fec']) && 
                      ($dados_1[$x]['abe'] < $dados_2[$x]['abe']) &&
                      ($dados_1[$x]['fec'] < $dados_2[$x]['abe']) &&                      
                      ($dados_1[$x]['max'] < $dados_2[$x]['max']) && 
                      ($dados_1[$x]['min'] > $dados_2[$x]['min']) &&
                      (($dados_1[$x]['max'] - $dados_1[$x]['min']) * 0.5 < ($dados_1[$x]['fec'] - $dados_1[$x]['abe'])) &&
                      (($dados_2[$x]['max'] - $dados_2[$x]['min']) * 0.5 < ($dados_2[$x]['abe'] - $dados_2[$x]['fec']))) {
             
                       $matriz[$acao][] = 'Grávida de alta';
                  }
       
               

               // martelo invertido
               /*
                * Um pequeno corpo real no final de uma tendência;
                * A cor do corpo é indiferente;
                * A sombra superior deve ser duas ou três vezes maior que o corpo;
                * A sombra inferior é inexistente ou muito pequena;
                * (MATSURA p.58)
                */
              
                  if ((($dados_1[$x]['mms_03'] < $dados_2[$x]['mms_03']) &&
                       ($dados_2[$x]['mms_03'] < $dados_3[$x]['mms_03'])) &&
                      ($dados_1[$x]['abe'] < ($dados_1[$x]['max'] - (($dados_1[$x]['max'] - $dados_1[$x]['min']) * 0.66))) && 
                      ($dados_1[$x]['fec'] < ($dados_1[$x]['max'] - (($dados_1[$x]['max'] - $dados_1[$x]['min']) * 0.66)))) {
                       $matriz[$acao][] = 'Martelo invertido';
                  }
               
               
               
               
               // Linha penetrante
               /*
                * Composto por dois candles;
                * Fechamento atual igual ou acima de 50% do corpo real anterior;
                * Corpo real atual de alta, corpo real anterior de baixa;
                * Corpos com sombras inferior e superior pequenas;
                * (MATSURA p.60)
                */
               
                  if ((($dados_1[$x]['mms_03'] < $dados_2[$x]['mms_03']) &&
                       ($dados_2[$x]['mms_03'] < $dados_3[$x]['mms_03'])) &&
                      ($dados_1[$x]['fec'] > ($dados_2[$x]['fec'] + (($dados_2[$x]['abe'] - $dados_2[$x]['fec']) / 2))) && 
                      ($dados_1[$x]['fec'] > $dados_1[$x]['abe']) &&
                      ($dados_2[$x]['fec'] < $dados_2[$x]['abe']) &&
                      ($dados_1[$x]['max'] < $dados_2[$x]['max']) &&
                      ($dados_1[$x]['min'] < $dados_2[$x]['min']) &&
                      (($dados_1[$x]['max'] - $dados_1[$x]['min']) * 0.5 < ($dados_1[$x]['fec'] - $dados_1[$x]['abe'])) &&
                      (($dados_2[$x]['max'] - $dados_2[$x]['min']) * 0.5 < ($dados_2[$x]['abe'] - $dados_2[$x]['fec']))) {
                       $matriz[$acao][] = 'Linha penetrante';
                  }

               
 
               
               // Estrela da manhã ou Doji star
               /*
                * Uma estrela no final de uma tendência de baixa;
                * Um corpo real de alta após a estrela;
                * A sombra do corpo real de alta é inexistente ou muito pequena;
                * (MATSURA p.63)
                */
               
                  if (($dados_2[$x]['mms_03'] < $dados_3[$x]['mms_03']) &&
                      ($dados_2[$x]['fec'] > ($dados_2[$x]['min'] + (($dados_2[$x]['max'] - $dados_2[$x]['min']) * 0.33))) && 
                      ($dados_2[$x]['abe'] > ($dados_2[$x]['min'] + (($dados_2[$x]['max'] - $dados_2[$x]['min']) * 0.33))) && 
                      ($dados_2[$x]['fec'] < ($dados_2[$x]['max'] - (($dados_2[$x]['max'] - $dados_2[$x]['min']) * 0.33))) && 
                      ($dados_2[$x]['abe'] < ($dados_2[$x]['max'] - (($dados_2[$x]['max'] - $dados_2[$x]['min']) * 0.33))) && 
                      ($dados_1[$x]['fec'] > $dados_1[$x]['abe']) &&
                      ($dados_3[$x]['abe'] > $dados_3[$x]['fec']) &&
                      ($dados_1[$x]['abe'] > $dados_2[$x]['fec']) &&
                      ($dados_1[$x]['abe'] > $dados_2[$x]['abe']) &&
                      ($dados_3[$x]['fec'] > $dados_2[$x]['fec']) &&
                      ($dados_3[$x]['abe'] > $dados_2[$x]['abe']) &&
                      (($dados_1[$x]['max'] - $dados_1[$x]['min']) * 0.5 < ($dados_1[$x]['fec'] - $dados_1[$x]['abe']))) {
                       $matriz[$acao][] = 'Estrela da manhã';
                  }
          
               
 
               
               // Bebê abandonado "alta"
               /*
                * Uma estrela no final de uma tendência;
                * Um gap antes e depois da estrela (ilha de reversão);
                * inversão da tendência principal
                * (MATSURA p.65)
                */
              
                  if (($dados_1[$x]['mms_03'] > $dados_2[$x]['mms_03']) &&
                      ($dados_2[$x]['mms_03'] < $dados_3[$x]['mms_03']) &&
                      ($dados_2[$x]['fec'] > ($dados_2[$x]['min'] + (($dados_2[$x]['max'] - $dados_2[$x]['min']) * 0.33))) && 
                      ($dados_2[$x]['abe'] > ($dados_2[$x]['min'] + (($dados_2[$x]['max'] - $dados_2[$x]['min']) * 0.33))) && 
                      ($dados_2[$x]['fec'] < ($dados_2[$x]['max'] - (($dados_2[$x]['max'] - $dados_2[$x]['min']) * 0.33))) && 
                      ($dados_2[$x]['abe'] < ($dados_2[$x]['max'] - (($dados_2[$x]['max'] - $dados_2[$x]['min']) * 0.33))) && 
                      ($dados_1[$x]['fec'] > $dados_1[$x]['abe']) &&
                      ($dados_3[$x]['abe'] > $dados_3[$x]['fec']) &&
                      ($dados_1[$x]['min'] > $dados_2[$x]['max']) &&
                      ($dados_3[$x]['min'] > $dados_2[$x]['max'])) {
                       $matriz[$acao][] = 'Bebê abandonado de alta';
                  }
               
               
 
               
               // Marobuzu de alta
               /*
                * 
                */
               // PORCENTAGEM DE ALTA AQUI
                  if ((($dados_1[$x]['min'] == $dados_1[$x]['abe']) ||
                       ($dados_1[$x]['min'] == ($dados_1[$x]['abe'] - 0.01))) &&
                      ($dados_1[$x]['max'] == $dados_1[$x]['fec'])) {
                       $matriz[$acao][] = 'Marobuzu de alta';
                  }
        
               
               if (isset($matriz[$acao])) {
                  $matriz[$acao]['abe'] = $dados_1[$x]['abe'];
                  $matriz[$acao]['max'] = $dados_1[$x]['max'];
                  $matriz[$acao]['min'] = $dados_1[$x]['min'];
                  $matriz[$acao]['fec'] = $dados_1[$x]['fec'];
               }
             }
         }
         $x++;
      } // fim do foreach no array iBovespa
        $dados['matriz'] = @$matriz;
	$dados['atualizacao'] = $atualizacao;
	   
	   // Entra aqui quando vem através do upload (faz a análise e atualiza os usuários)
	   if ($atualizar_usuarios) {
	   
	            // Prepara o texto do email
	            $texto = '';
	            
	            if (!empty($matriz)) {
	               $acoes = array_keys($matriz);
                    foreach($acoes as $acao) {
                        $texto .= '<br>----------------------------------------------------------';
                        $texto .= '<br>'.$acao.'<br><br>';
                        unset($matriz[$acao]['abe']);
                        unset($matriz[$acao]['fec']);
                        unset($matriz[$acao]['max']);
                        unset($matriz[$acao]['min']);
                        
                        foreach($matriz[$acao] as $inf) {
                                $texto .= $inf.'<br>';
                        }                      

                    }
                    $texto .= '<br>----------------------------------------------------------';
                 } else {
                     $texto = '<br>----------------------------------------------------------<br>';
                     $texto .= 'Hoje não tivemos novidades';
                     $texto .= '<br>----------------------------------------------------------';
                 }
	   
	            // busca os usuários cadastrados
	            $assunto = "Análise ".$atualizacao;
	            $assunto = '=?UTF-8?B?'.base64_encode($assunto).'?=';	            
	            $headers  = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                    $headers .= 'From: tcc@joaobcneto.com.br' . "\r\n";
	            
	            $this->load->model('usuario_model', '', TRUE);
		         $usuarios = $this->usuario_model->buscaTodos();
		         foreach ($usuarios as $usuario) {
		            if (!mail($usuario->email, $assunto, $texto, $headers)) {
		               $data = array();
	                       $data['voltar'] = '';
	                       $data['tipo_alerta'] = 'alert-error';
		               $data['mensagem'] = 'Falha ao enviar emails aos usuários.';
		               $this->load->view('mensagem_view', $data);
		            } else {
		                $data = array();
	                        $data['voltar'] = '';
	                        $data['tipo_alerta'] = 'alert-success';
		                $data['mensagem'] = 'Sistema atualizado com sucesso';
		                $this->load->view('mensagem_view', $data);
		            }
	            }
	   
	            
		    
	   } else {
	      $this->load->view('inicio_view', $dados);
	   }
	}
}
