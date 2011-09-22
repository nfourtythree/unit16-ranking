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
	
	public function player_add($id=false)
	{
		if ($_POST)
		{
			$this->form_validation->set_rules(array(
				array(
					'field'=>'name',
					'label'=>'Name',
					'rules'=>'required|trim'
				),
				array(
					'field'=>'rank',
					'label'=>'Rank',
					'rules'=>'required|trim|numeric'
				)
			));
			
			if ($this->form_validation->run()):
				$this->players_m->insert(array(
					'name'=>$this->input->post('name'),
					'rank'=>$this->input->post('rank')
				));
			
			endif;
		}
		
		$this->load->view('player/add');
	}
	
	
	public function reset()
	{
		$this->players_m->update_all(array('rank'=>1200, 'wins'=>0, 'draws'=>0, 'loses'=>0, 'for'=>0, 'against'=>0));
		
		$matches = $this->matches_m->order_by('id','ASC')->get_all();
		
		$this->matches_m->delete_by(array('id !='=>''));
		
		foreach ($matches as $match) {

			$player1 = $this->players_m->get($match->player1);
			$player2 = $this->players_m->get($match->player2);
			$player1->score = $match->player1_score;
			$player2->score = $match->player2_score;
			$new_id = $this->matches_m->play_match($player1, $player2);
			$this->matches_m->update($new_id, array('created'=>$match->created));
		}
		
	}
}

/* Location: ./application/controllers/ranking.php */