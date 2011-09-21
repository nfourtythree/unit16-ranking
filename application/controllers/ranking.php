<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ranking extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('elo', 'form_validation'));
	}
	
	
	public function index()
	{
		$data->ranking = $this->players_m->order_by('rank','DESC')->get_all();
		
		$data->players = $this->players_m->dropdown('name');
		
		$this->load->view('match', $data);
		
		
		
	}
	
	public function match()
	{		
		if ($_POST):
			$this->form_validation->set_rules(array(
				array(
					'field'=>'player1',
					'label'=>'Player 1',
					'rules'=>'required|trim|not_equal[player2]'
				),
				array(
					'field'=>'player2',
					'label'=>'Player 2',
					'rules'=>'required|trim|not_equal[player1]'
				),
				array(
					'field'=>'player1_score',
					'label'=>'Player 1 Score',
					'rules'=>'required|trim|numeric'
				),
				array(
					'field'=>'player2_score',
					'label'=>'Player 2 Score',
					'rules'=>'required|trim|numeric'
				)
			));
			
			if ($this->form_validation->run()):
				$player1 = $this->players_m->get($this->input->post('player1'));
				$player2 = $this->players_m->get($this->input->post('player2'));
				if (!empty($player1) AND !empty($player2)):
					$player1->score = $this->input->post('player1_score');
					$player2->score = $this->input->post('player2_score');
					
					$this->matches_m->play_match($player1, $player2);
					
				endif;
			
			endif;
		
		endif;
		
		redirect();
	}
	
}

/* Location: ./application/controllers/ranking.php */