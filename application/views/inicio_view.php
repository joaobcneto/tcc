<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>T C C - João B. C. Neto</title>
	<meta name="description" content="Sistema elaborado pelo aluno João Batista Caetano Neto como trabalho de conclusão do curso de Bacharelado em Sistemas de Informação no Instituto Federal Catarinense - Campus Camboriú. 2010 à 2013">
	<meta name="keywords" content="sistema de análise, análise técnica, ações, Ibovespa, Médias Móveis, Candlesticks, TCC, João B. C. Neto">
    <link href="<?php echo base_url(); ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>/assets/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>/assets/css/style.css" rel="stylesheet">
	<style>
		.accordion {
		   margin-bottom: 5px;  
	    }
	    .pb10px {
		   padding-bottom: 10px;
	    }
	    .icon-chevron-down {
		   opacity: .5;
	    }
    </style>
</head>
<body>
	<div id="wrap">
   <div class="navbar navbar-static-top">
      <div class="navbar-inner">
         <div class="container fluid">
            <a class="brand">TCC - João B. C. Neto</a>
            <ul class="nav pull-right">
               <li class='active'><a href="<?php echo base_url(); ?>">Início</a></li>
               <li><a href="<?php echo base_url(); ?>cadastro">Cadastro</a></li>
               <li><a href="<?php echo base_url(); ?>sobre">Sobre</a></li>
            </ul>
         </div>
      </div>
   </div>

   <div class="container fluid mt30">
      <h1>Atualização: <?php echo $atualizacao; ?></h1>     
         <div class="mt30">      
            <?php
               if (!empty($matriz)) {
                  $acoes = array_keys($matriz);
                  $x = 0;
                  foreach($acoes as $acao) {
                     
                        echo '<div class="accordion" id="accordion'.$x.'">';
                        echo    '<div class="accordion-group">';
                        echo       '<div class="accordion-heading">';
                        echo          '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion'.$x.'" href="#collapse'.$x.'">'.$acao.'<i class="icon-chevron-down pull-right"></i></a>';
                        echo       '</div>';
                        echo       '<div id="collapse'.$x.'" class="accordion-body collapse">';
                        echo          '<div class="accordion-inner">';
                        
                        echo             '<div class="pull-right span1 pb10px">';  
                        echo                number_format($matriz[$acao]['abe'],"2",'.','').'<br>';
                        echo                number_format($matriz[$acao]['fec'],"2",'.','').'<br>';
                        echo                number_format($matriz[$acao]['max'],"2",'.','').'<br>';
                        echo                number_format($matriz[$acao]['min'],"2",'.','').'<br>';
                        echo             '</div>';
                        echo             '<div class="pull-right span2">';  
                        echo                'ABERTURA <br>';
                        echo                'FECHAMENTO <br>';
                        echo                'MÁXIMA <br>';
                        echo                'MÍNIMA <br>';
                        echo             '</div>';
                        unset($matriz[$acao]['abe']);
                        unset($matriz[$acao]['fec']);
                        unset($matriz[$acao]['max']);
                        unset($matriz[$acao]['min']);
                        
                        foreach($matriz[$acao] as $inf) {
                        echo             $inf.'</br>';
                        }
                        
                        echo          '</div>';
                        echo       '</div>';
                        echo    '</div>';
                        echo '</div>';
                     
                     $x++;
                  }
               } else {
                  echo 'Sem novidades';
               }
            ?>
         </div>
      </div>
   </div>
      </div>
   <div id="footer">
      <div class="container">
        <p>Para mais informações entre em contato pelo email: <a href="mailto:tcc@joaobcneto.com.br">tcc@joaobcneto.com.br</a></p>
      </div>
   </div>

   
   <script src="../assets/js/jquery-1.9.1.min.js"></script>
   <script src="../assets/js/bootstrap.min.js"></script>

</body>
</html>
