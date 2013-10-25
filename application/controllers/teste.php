<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Teste extends CI_Controller {

	public function index()	{
	
	   $data_atual = time("Y/m/d"); // obtém um time stamp da data atual
	
      $x = 0;
      $y = 0;
      $acao = 'PETR4  ';
      echo '<b>'.$acao.'</b><br><table border=1>';
      echo '<tr><td>DATA</td><td>ABE</td><td>FEC</td><td>MAX</td><td>MIN</td><td>VOL</td>';
      
      // busca os últimos 20 arquivos
      while ($x < 20) {
         
         $data = strtotime("-$y day", $data_atual);
         $arquivo = @fopen("./dados_brutos/COTAHIST_D".date('dmY', $data).".TXT", "r");
            
            // caso encontre o arquivo busca os dados da ação da vez            
            if ($arquivo) {
            
               while (($linha = fgets($arquivo, 256)) !== false) {
               
                  // quando encontra a ação obtém os valores necessários               
                  if (substr($linha,12,7) == $acao) {
                     echo '<tr>';
                     echo '<td>'.date('d/m/Y', $data).'</td>';
                     echo '<td>'.number_format((substr($linha,56,11).'.'.substr($linha,67,2)),"2",'.','').'</td>';
                     echo '<td>'.number_format((substr($linha,115,4).'.'.substr($linha,119,2)),"2",'.','').'</td>';
                     echo '<td>'.number_format((substr($linha,69,11).'.'.substr($linha,80,2)),"2",'.','').'</td>';
                     echo '<td>'.number_format((substr($linha,82,11).'.'.substr($linha,93,2)),"2",'.','').'</td>';
                     echo '<td>'.(int) substr($linha,170,16).'</td>';;
                     echo '</tr>';
                  }
                   
               } // fim do while nas linhas do arquivo
               $x++;
            }
            $y++;            
         } // fim do while que busca os 20 últimos arquivos
      echo '</table>';
	}
}

