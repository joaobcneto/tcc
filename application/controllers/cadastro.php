<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cadastro extends CI_Controller {

	public function index() {
	
	   if(empty($_POST)) {
	   
	      $this->load->view('cadastro_view');
	      
	   } else {
	
	      $nome  = $_POST['nome'];
		   $email = $_POST['email'];
		   
		   $this->load->model('usuario_model', '', TRUE);
		   
		      $usuario = $this->usuario_model->buscaPorEmail($email);

		      if ($usuario) {
		      
		         $data['voltar'] = '';
		         $data['tipo_alerta'] = 'alert-error';
			      $data['mensagem'] = 'Este email já está cadastrado.';
			      $this->load->view('mensagem_view', $data);
			      
		      } else {
		      
			      unset($_POST['submit']);
			      $cadastro = $this->usuario_model->adicionar($_POST);
			      if ($cadastro) {
			         $data['voltar'] = '';
				      $data['tipo_alerta'] = 'alert-success';
				      $data['mensagem'] = 'Cadastro realizado com sucesso, a partir de amanhã você recebera as nossas atualizações.';
			      } else {
				      $data['voltar'] = '';
				      $data['tipo_alerta'] = 'alert-error';
				      $data['mensagem'] = 'Falha na realização do cadastro.';
			      }
			      $this->load->view('mensagem_view', $data);
		      }
	      }
	}
}
