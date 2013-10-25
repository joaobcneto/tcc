<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sobre | T C C - João B. C. Neto</title>
    <link href="<?php echo base_url(); ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>/assets/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>/assets/css/style.css" rel="stylesheet">
</head>
<body>
   <div class="navbar navbar-static-top">
      <div class="navbar-inner">
         <div class="container fluid">
            <a class="brand">TCC - João B. C. Neto</a>
            <ul class="nav pull-right">
               <li><a href="<?php echo base_url(); ?>">Início</a></li>
               <li><a href="<?php echo base_url(); ?>cadastro">Cadastro</a></li>
               <li class='active'><a href="#">Sobre</a></li>
            </ul>
         </div>
      </div>
   </div>
   
   <div class="container fluid mt30">
      <h1>Sobre</h1>
      <div class='row'>
         <div class='span6'>
            <h2>Apresentação</h2>
            <p>Este sistema foi desenvolvido como trabalho de conclusão de curso pelo aluno João Batista Caetano Neto e apresentado como parte dos requisitos para obtenção do título de Bacharel em Sistemas de Informação pelo Instituto Federal Catarinense – campus Camboriú. Seu objetivo é identificar padrões da análise técnica no movimento do mercado de ações e através do poder computacional poupar tempo dos investidores.</p>
         </div>
         <div class='span6'>
            <h2>Funcionamento</h2>
            <p>O sistema realiza análises sobre os relatórios diários da <a href='http://www.bmfbovespa.com.br'>BM&FBovespa</a>, e apresenta o resultado através de uma interface web. São análisadas as ações do índice Bovespa, e movimentos interessantes que apontem oportunidades de compra, são informados ao usuário, que também pode optar por recebê-las por email. Os padrões buscados são cruzamento de médias móveis simples e candlesticks.</p>
         </div>
      </div>
	  <hr>
	     <div class='row'>
         <div class='span12'>
            <h2>Padrões buscados</h2>
         </div>
         <div class='span3'>
			<img src="<?php echo base_url(); ?>assets/img/cruzamento de médias.png">
            <p><b>Volume acima da média</b> - São selecionadas ações que tenham tido um volume acima da média de 20 períodos. Caso esta premissa seja verdadeira a análise prossegue e caso contrário o sistema passa para a próxima empresa.</p>
		 </div>
		 <div class='span3'>
			<img src="<?php echo base_url(); ?>assets/img/cruzamento de médias.png">
            <p><b>Cruzamento de médias móveis</b> - Ocorre quando da interseção de duas médias, uma de um menor período e outra de maior. Neste caso a média rápida deve cruzar a lenta no sentido de baixo para cima. É um sinal de compra.</p>
		 </div>
		 <div class='span3'>
			<img src="<?php echo base_url(); ?>assets/img/cruzamento de médias.png">
            <p><b>Candlestick Martelo (Hammer)</b> - É um candle de corpo pequeno e longa sombra inferior. Quando aparece ao final de uma tendência de baixa, significa uma possível reversão da tendência pela diminuição da força vendedora.</p>
		 </div>
		 <div class='span3'>
			<img src="<?php echo base_url(); ?>assets/img/cruzamento de médias.png">
            <p><b>Candlestick envolvente de alta</b> - São gerados por dois candles sendo o último de alta e o penúltimo de baixa. O corpo do último candle deve envolver todo o corpo do anterior e deve aparecer numa tendência de baixa.</p>
		 </div>
      </div>
	  <div class='row mt30'>
         <div class='span3'>
			<img src="<?php echo base_url(); ?>assets/img/cruzamento de médias.png">
            <p><b>Grávida de alta (Harami)</b> - É o oposto do envolvente de alta, o corpo do candle anterior abrange todo o corpo do último, que fica inteiramente dentro do movimento do dia anterior. Ambos devem apresentar sombras pequenas.</p>
		 </div>
		 <div class='span3'>
			<img src="<?php echo base_url(); ?>assets/img/cruzamento de médias.png">
            <p><b>Estrela da manhã (morning star)</b> - É formado pela combinação de três candles sendo que o do meio tem seu corpo abaixo e sem cobertura dos outros dois, que devem ter sentidos opostos, o último de alta e o antepenúltimo de baixa.</p>
		 </div>
		 <div class='span3'>
			<img src="<?php echo base_url(); ?>assets/img/cruzamento de médias.png">
            <p><b>Bebê abandonado de alta</b> - Parecido com a estrela da manhã, porém nesta formação até a sombra extrapola a linha dos candles laterais. A mínima do último e do antepenúltimo devem ser maiores que a máxima do penúltimo candle.</p>
		 </div>
		 <div class='span3'>
			<img src="<?php echo base_url(); ?>assets/img/cruzamento de médias.png">
            <p><b>Linha penetrante</b> Aparece ao final de uma tendência de baixa e é formado por dois candles com sombras pequenas, o último de alta e o penúltimo de baixa. O fechamento atual deve ser igual ou acima de 50% do corpo real anterior.</p>
		 </div>
      </div>
	  <div class='row mt30'>
         <div class='span3'>
			<img src="<?php echo base_url(); ?>assets/img/cruzamento de médias.png">
            <p><b>Marobuzu de alta</b> - Representa um dia em que o mercado teve um grande movimento de alta, com a abertura próxima a mínima e fechamento próximo a máxima. Neste dia os compradores dominaram completamente o mercado.</p>
		 </div>
      </div>
      <hr>
      <div class='row'>
         <div class='span12'>
            <h2>Tecnologias usadas</h2>
         </div>
         <div class='span3'>   
            <p><a href='http://php.net/'>PHP</a> - (Hypertext preprocessor) - É uma das linguagens mais usadas para criar páginas web dinâmicas. Os códigos de toda a parte lógica do sistema como o upload de arquivos, o reconhecimento de padrões, o fluxo de informações, a montagem das páginas conforme o conteúdo a ser exibido, entre outras, foram escritos em PHP.</p>
         </div>
         <div class='span3'>
            <p><a href='http://www.mysql.com/'>MySQL</a> - Usado como sistema gerenciador de banco de dados, SGBD, foi escolhido devido ao seu baixo consumo de recursos do sistema operacional, extrema velocidade, compatibilidade e seu baixo custo financeiro. A base de dados criada é extremamente simples e armazena o nome e o e-mail dos usuários.</p>
         </div>
         <div class='span3'>
            <p><a href='https://developer.mozilla.org/en-US/docs/Web/JavaScript'>JavaScript</a> - É uma linguagem de programação leve, interpretada na máquina do usuário e com recursos de orientação a objetos. Neste sistema foi utilizada para a validação de dados em campos de formulário evitando submissões inválidas e para criar alguns efeitos de interface e melhorar a experiência do usuário.</p>
         </div>
         <div class='span3'>
            <p><a href='http://www.apache.org/'>Apache</a> - Para que o sistema escrito em linguagem PHP seja interpretado, é necessário dispor de alguma ferramenta capaz de realizar este serviço. Como opção para esta necessidade optamos pelo uso do servidor apache rodando sobre plataforma Linux, tanto no desenvolvimento local, quanto na sua implementação online.</p>
         </div>
      </div>
      <div class='row mt30'>
         <div class='span3'>   
            <p><a href='http://www.json.org/'>JSON</a> - Acrônimo de JavaScript Object Notation ou notação de objetos JavaScript, é um formato de transporte de dados leve, fácil para humanos ler e escrever, e fácil para máquinas analisar e gerar. É baseado em um subconjunto da linguagem de programação JavaScript, e é independente de idioma, sendo composto por uma coleção de pares nome : valor.</p>
         </div>
         <div class='span3'>
            <p><a href='http://www.jquery.com/'>jQuery</a> - É uma biblioteca JavaScript criada por John Resig e que pode ser usado tanto para projetos pessoais quanto comerciais pois seu uso é livre. Neste sistema o jQuery foi usada para simplificar o desenvolvimento, fornecendo mais produtividade nas atividades, devido a facilidade na criação de efeitos visuais, manipulação do DOM, entre outras funcionalidades.</p>
         </div>
         <div class='span3'>
            <p><a href='http://getbootstrap.com/'>Bootstrap</a> - Framework para desenvolvimento front-end de páginas web, tem suporte a novas tecnologias como HTML5 e CSS3 e foi criado no Twitter por Mark Otto e Jacob Thornton. Provê modelos de design para tipografia, campos de formulários, entre outros componentes de interface e extensões JavaScript. Toda a interface do sistema foi construída sobre ele.</p>
         </div>
         <div class='span3'>
            <p><a href='http://ellislab.com/codeigniter/'>Codeigniter</a> - Framework PHP baseado no conceito MVC (Model, View, Controller) e mantido pelo Ellislab, é uma ferramenta open source leve e poderosa para o trabalho de desenvolvimento back-end. No sistema foi usado como forma de otimizar os resultados, através da utilização de suas funções para acesso a bancos de dados, reescrita de URL, upload de arquivos, entre outras.</p>
         </div>
      </div>
      <hr>

   </div>
   <script src="../assets/js/jquery-1.9.1.min.js"></script>
   <script src="../assets/js/bootstrap.min.js"></script>
</body>
</html>
