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
					<a href="#" class="btn btn-navbar mb10px" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-th-list"></span>
					</a>
					<div class="nav-collapse collapse">
						<ul class="nav pull-right">
							<li class='active'><a href="<?php echo base_url(); ?>">Início</a></li>
							<li><a href="<?php echo base_url(); ?>cadastro">Cadastro</a></li>
							<li><a href="<?php echo base_url(); ?>sobre">Sobre</a></li>
						</ul>
					</div>
				</div>
			</div>
	    </div>

    <div class="container fluid mt30">
		<h1>Atualização: <?php echo $atualizacao; ?></h1>     
			<div class="mt30">      
				<?php
					if (!empty($matriz)) {
						$acoes = array_keys($matriz);
						$contador = 0;
						foreach($acoes as $acao) {
				  
							$abe = $matriz[$acao]['abe'];
							$fec = $matriz[$acao]['fec'];
							$max = $matriz[$acao]['max'];
							$min = $matriz[$acao]['min'];
							unset($matriz[$acao]['abe']);
							unset($matriz[$acao]['fec']);
							unset($matriz[$acao]['max']);
							unset($matriz[$acao]['min']);
                     
							echo '<div class="accordion" id="accordion'.$contador.'">';
							echo    '<div class="accordion-group">';
							echo       '<div class="accordion-heading">';
							echo          '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion'.$contador.'" href="#collapse'.$contador.'">'.$acao.'<i class="icon-chevron-down pull-right"></i></a>';
							echo       '</div>';
							echo       '<div id="collapse'.$contador.'" class="accordion-body collapse">';
							echo          '<div class="accordion-inner">';

							echo             '<div class="span9">';
							foreach($matriz[$acao] as $inf) {
								echo            '<span class="pb10px">'.$inf.'<span></br>';
							}
							echo             '</div>';
						
							echo             '<div class="span2 pb10px">';  
							echo                'ABERTURA:   <span class="pull-right">'.number_format($abe,"2",".","").'</span><br>';
							echo                'FECHAMENTO: <span class="pull-right">'.number_format($fec,"2",".","").'</span><br>';
							echo                'MÁXIMA:     <span class="pull-right">'.number_format($max,"2",".","").'</span><br>';
							echo                'MÍNIMA:     <span class="pull-right">'.number_format($min,"2",".","").'</span><br>';
							echo             '</div>';	

							echo          '</div>';
							echo       '</div>';
							echo    '</div>';
							echo '</div>';
                     
							$contador++;
						}
					} else {
						echo 'Sem novidades';
					}
				?>
			</div>
		</div>
		<p>&nbsp</p>
		<p>&nbsp</p>
		<p>&nbsp</p>
	</div>
	</div>
	<div id="footer">
		<div class="container">
			<p>Para mais informações entre em contato pelo email: <a href="mailto:tcc@joaobcneto.com.br">tcc@joaobcneto.com.br</a></p>
		</div>
	</div>
   
   <script src="../assets/js/jquery-1.10.2.min.js"></script>
   <script src="../assets/js/bootstrap.min.js"></script>

</body>
</html>
