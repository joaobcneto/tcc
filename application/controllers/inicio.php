<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller {

	public function index($atualizar_usuarios = null) {

		$data_atual_timestamp = time("Y/m/d");
		
		// o trecho a seguir obtém a data da última atualização do sistema
		
        $contador_para_dias = 0;
        $atualizacao = FALSE;
		
		while (!$atualizacao) {
			if (!file_exists("./dados_calculados/".date('dmY',strtotime("-$contador_para_dias day",$data_atual_timestamp)).".JSON")) {
				$contador_para_dias++;
			} else {
				$atualizacao = date('d/m/Y',strtotime("-$contador_para_dias day",$data_atual_timestamp));  
			}
		}
      
		// o trecho a seguir obtém os dados dos três últimos arquivos de atualização
		
		$dados_1 = array(); // dados do primeiro dia
		$dados_2 = array(); // dados do segundo dia
		$dados_3 = array(); // dados do terceiro dia
		$contador_para_dias = 0;
		$contador_para_arquivos = 0;
		
		while ($contador_para_arquivos < 3) {
			$data_timestamp = strtotime("-$contador_para_dias day", $data_atual_timestamp);
			$arquivo = @fopen("./dados_calculados/".date('dmY', $data_timestamp).".JSON", "r");

			if ($arquivo) {              
				while (($linha = @fgets($arquivo, 8192)) !== false) {            
			 	    switch ($contador_para_arquivos) {
					    case 0:
							$dados_1[] = json_decode($linha,TRUE);
							break;
						case 1:
							$dados_2[] = json_decode($linha,TRUE);
							break;
						case 2:
							$dados_3[] = json_decode($linha,TRUE);
							break;
					}
				}
				$contador_para_arquivos++;
			}
			$contador_para_dias++;
		}
      
		// o trecho a seguir realiza a análise dos dados obtidos nos arquivos e monta o resultado
		include('./iBovespa.php');
      
		// percorre o array iBovespa fazendo a análise
      
		$x = 0; // índice para percorrer o array dos dados
      
      
		foreach ($iBovespa as $acao) {
      
			// verifica se a ação no iBovespa é mesma nos 3 arquivos conforme a posição (só para conferir)
			if (($acao == $dados_1[$x]['emp']) &&
				($acao == $dados_2[$x]['emp']) &&
				($acao == $dados_3[$x]['emp'])) {
             
				/* INÍCIO DA ANÁLISE */
				
				/* VOLUME */
				
				// verifica se o volume foi acima da média (requisito para prosseguir a análise)
				if ($dados_1[$x]['vol'] > $dados_1[$x]['mms_vol_20']) {
				
					/* MÉDIAS MÓVEIS SIMPLES */
               
					// identifica o cruzamento da média móvel simples de 3 períodos de baixo para cima a de 10 períodos
					if (($dados_1[$x]['mms_03'] > $dados_1[$x]['mms_10']) && ($dados_2[$x]['mms_03'] < $dados_2[$x]['mms_10'])) {
						$resultado[$acao][] = 'MMS03 cruzou MMS10 de baixo para cima';
					}
               
               
					/* CANDLESTICKS */
               
					// identifica o padrão candlestick martelo (hammer)
                    if ((($dados_1[$x]['mms_03'] < $dados_2[$x]['mms_03']) &&
						 ($dados_2[$x]['mms_03'] < $dados_3[$x]['mms_03'])) &&
                        ($dados_1[$x]['abe'] > ($dados_1[$x]['min'] + (($dados_1[$x]['max'] - $dados_1[$x]['min']) * 0.66))) && 
                        ($dados_1[$x]['fec'] > ($dados_1[$x]['min'] + (($dados_1[$x]['max'] - $dados_1[$x]['min']) * 0.66)))) {
                        $resultado[$acao][] = 'Martelo';
                    }
               
               
					// identifica o padrão candlestick envolvente de alta (engolfing)
					if (($dados_2[$x]['mms_03'] < $dados_3[$x]['mms_03']) &&
   					    ($dados_1[$x]['abe'] < $dados_2[$x]['fec']) && 
                        ($dados_1[$x]['fec'] > $dados_2[$x]['abe']) &&
                        (($dados_1[$x]['max'] - $dados_1[$x]['min']) * 0.5 < ($dados_1[$x]['fec'] - $dados_1[$x]['abe'])) &&
                        (($dados_2[$x]['max'] - $dados_2[$x]['min']) * 0.5 < ($dados_2[$x]['abe'] - $dados_2[$x]['fec']))) {
                        $resultado[$acao][] = 'Envolvente de alta';
					}
               
               
					// identifica o padrão candlestick mulher grávida de alta (harami)
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
                        $resultado[$acao][] = 'Grávida de alta';
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
                       $resultado[$acao][] = 'Martelo invertido';
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
                       $resultado[$acao][] = 'Linha penetrante';
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
                       $resultado[$acao][] = 'Estrela da manhã';
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
                       $resultado[$acao][] = 'Bebê abandonado de alta';
                  }
               
               
 
               
               // Marobuzu de alta
                  if ((($dados_1[$x]['min'] == $dados_1[$x]['abe']) ||
                       ($dados_1[$x]['min'] == ($dados_1[$x]['abe'] - 0.01))) &&
                      ($dados_1[$x]['max'] == $dados_1[$x]['fec'])) {
                       $resultado[$acao][] = 'Marobuzu de alta';
                  }
				  
				  // Gap de alta
                  if ($dados_1[$x]['min'] > ($dados_2[$x]['max']+0.01)) {
                       $resultado[$acao][] = 'Gap de alta';
                  }
        
               
               if (isset($resultado[$acao])) {
                  $resultado[$acao]['abe'] = $dados_1[$x]['abe'];
                  $resultado[$acao]['max'] = $dados_1[$x]['max'];
                  $resultado[$acao]['min'] = $dados_1[$x]['min'];
                  $resultado[$acao]['fec'] = $dados_1[$x]['fec'];
               }
             } // fim do if que verifica se o volume foi acima da média
         } // fim do if que verifica a posição das ações no mesmo arquivo
         $x++;
      } // fim do foreach no array iBovespa
        $dados['matriz'] = @$resultado;
	$dados['atualizacao'] = $atualizacao;
	   
	   // Entra aqui quando vem através do upload (faz a análise e atualiza os usuários)
	   if ($atualizar_usuarios) {
	   
	            // Prepara o texto do email
	            $texto = '';
	            
	            if (!empty($resultado)) {
	               $acoes = array_keys($resultado);
                    foreach($acoes as $acao) {
                        $texto .= '<br>----------------------------------------------------------';
                        $texto .= '<br>'.$acao.'<br><br>';
                        unset($resultado[$acao]['abe']);
                        unset($resultado[$acao]['fec']);
                        unset($resultado[$acao]['max']);
                        unset($resultado[$acao]['min']);
                        
                        foreach($resultado[$acao] as $inf) {
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
		            if (!@mail($usuario->email, $assunto, $texto, $headers)) {
		               $data = array();
	                  $data['voltar'] = '';
	                  $data['tipo_alerta'] = 'alert-error';
		               $data['mensagem'] = 'Falha ao enviar email para '.$usuario->email;
		               $this->load->view('mensagem_view', $data);
		            }
	            }
	            
		         $data = array();
	            $data['voltar'] = '';
	            $data['tipo_alerta'] = 'alert-success';
		         $data['mensagem'] = 'Sistema atualizado com sucesso';
		         $this->load->view('mensagem_view', $data);	            
		    
	   } else {
	      $this->load->view('inicio_view', $dados);
	   }
	}
}
