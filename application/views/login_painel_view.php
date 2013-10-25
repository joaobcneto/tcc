<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login painel</title>
    <link href="<?php echo base_url(); ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>/assets/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>/assets/css/style.css" rel="stylesheet">
	<style>
		.well {
			margin-top: 150px;
		}
    </style>
</head>
<body>
   <div class="container">
      <div class='span3 well offset4'>
         <?php
      	    echo form_open('painel',array('id'=>'login_painel'));
            echo form_input(array('class'=>'span3','name'=>'email','placeholder'=>'Email','maxlength'=>'50','tabindex'=>'1'));
            echo form_password(array('class'=>'span3','name'=>'senha','placeholder'=>'Senha','maxlength'=>'50','tabindex'=>'2'));
            echo '<button type="submit" class="btn btn-info pull-right" tabindex="3">Login &nbsp;<span class="icon-user icon-white"></span></button>';
            echo form_close();
		 ?>
      </div>
   </div>
   <script src="../assets/js/jquery-1.9.1.min.js"></script>
   <script src="../assets/js/bootstrap.min.js"></script>
   <script src="../assets/js/bootbox.min.js"></script>
   <script>
      $(document).on("submit", "#login_painel", function(e) {
         if ($('input[name=email]').val() == '') {            
			$('input[name=email]').focus();
			$('input[name=email]').addClass('red');
			$('input[name=email]').attr("placeholder", "Adicione um email");
			return false;
		 } else {
			var sEmail = $("input[name=email]").val();
			// filtros
			var emailFilter=/^.+@.+\..{2,}$/;
			var illegalChars= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
			// condição
			if(!(emailFilter.test(sEmail))||sEmail.match(illegalChars)) {
			   $('input[name=email]').focus();
			   $('input[name=email]').val('');
			   $('input[name=email]').addClass('red');
			   $('input[name=email]').attr("placeholder", "Adicione um email válido");
			   return false;
			}
		}
		
		if ($('input[name=senha]').val() == '') {
			$('input[name=senha]').focus();
			$('input[name=senha]').addClass('red');
    		$('input[name=senha]').attr("placeholder", "Adicione uma senha");
			return false;
		}
      });
   </script>
</body>
</html>
