<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="../assets/img/favicon.png" />
	<title>Mensagem | T C C - João B. C. Neto</title>
   <link href="<?php echo base_url(); ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
   <link href="<?php echo base_url(); ?>/assets/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>/assets/css/style.css" rel="stylesheet">
   <style>
      .icon-repeat {
         margin-top: 5px;
      }
   </style>
</head>
<body>
    <div class="container mt30">
      <div class='row'>
         <div class="alert <?php echo $tipo_alerta; ?> span8 offset2">
            <a href='<?php echo base_url().$voltar; ?>' class="close" data-dismiss="alert"><span class='icon-repeat'></span></a>
            <?php echo $mensagem; ?>
         </div>
       </div>
    </div>

   <script src="../assets/js/jquery-1.9.1.min.js"></script>
   <script src="../assets/js/bootstrap.min.js"></script>
</body>
</html>
