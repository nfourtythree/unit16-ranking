<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Matches_m extends MY_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	public function play_match($player1, $player2)
	{
		$this->load->library('elo');
		
		list($player1->new_rank, $player2->new_rank) = $this->elo->match($player1, $player2);
		
		
		$this->insert(array(
				'player1'				=> $player1->id,
				'player1_score'			=> $player1->score,
				'player1_start_rank'	=> $player1->rank,
				'player1_end_rank'		=> $player1->new_rank,
				'player2'				=> $player2->id,
				'player2_score'			=> $player2->score,
				'player2_start_rank'	=> $player2->rank,
				'player2_end_rank'		=> $player2->new_rank
			));
		
		$this->players_m->update($player1->id, array('rank'=>$player1->new_rank));
		$this->players_m->update($player2->id, array('rank'=>$player2->new_rank));
		
	}
	    
}
