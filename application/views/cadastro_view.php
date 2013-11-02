<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cadastro | T C C - João B. C. Neto</title>
	<link href="<?php echo base_url(); ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>/assets/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>/assets/css/style.css" rel="stylesheet">
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
							<li><a href="<?php echo base_url(); ?>">Início</a></li>
							<li class='active'><a href="#">Cadastro</a></li>
							<li><a href="<?php echo base_url(); ?>sobre">Sobre</a></li>
						</ul>
					</div>
					
					
				</div>
			</div>
		</div>

		<div class="container fluid">
			<div class="mt30 span4 offset4">		
				<h1>Cadastro</h1>
				<p>Cadastre-se e receba os relatórios do sistema em seu email a cada nova atualização.</p>
				<?php
					echo form_open('cadastro', array('id'=>'cadastro'));
					echo form_input(array('name'=>'nome','placeholder'=>'Nome','maxlength'=>'100','class'=>'span4'));
					echo form_input(array('name'=>'email','placeholder'=>'Email','maxlength'=>'100','class'=>'span4'));
					echo form_button(array('name'=>'submit','class'=>'btn btn-info pull-right','type' => 'submit'),'Enviar &nbsp;<span class="icon-ok icon-white"></span>');
					echo form_close();
				?>
			</div>

		</div>
	</div>
 	<p>&nbsp</p>
	<div id="footer">
		<div class="container">
			<p>Para mais informações entre em contato pelo email: <a href="mailto:tcc@joaobcneto.com.br">tcc@joaobcneto.com.br</a></p>
		</div>
	</div>
 
	<script src="../assets/js/jquery-1.10.2.min.js"></script>
	<script src="../assets/js/bootstrap.min.js"></script>
	<script>
		$(document).on("submit", "#cadastro", function(e) {
			if ($('input[name=nome]').val() == '') {
				$('input[name=nome]').focus();
				$('input[name=nome]').addClass('red');
				$('input[name=nome]').attr("placeholder", "Informe o seu nome");
				return false;
			}
			if ($('input[name=email]').val() == '') {
				$('input[name=email]').focus();
				$('input[name=email]').addClass('red');
				$('input[name=email]').attr("placeholder", "Informe o seu email");
				return false;
			} else {
				var sEmail = $("input[name=email]").val();
				var emailFilter=/^.+@.+\..{2,}$/;
				var illegalChars= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
				
				if(!(emailFilter.test(sEmail))||sEmail.match(illegalChars)) {
					$('input[name=email]').focus();
					$('input[name=email]').val('');
					$('input[name=email]').addClass('red');
					$('input[name=email]').attr("placeholder", "Informe um email válido");
					return false;
				}
			}
		});
	</script>
</body>
</html>
