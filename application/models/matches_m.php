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
		
		
		if ($player1->score > $player2->score)
		{
			$player1->wins++;
			$player2->loses++;
		}
		else if ($player2->score > $player1->score)
		{
			$player2->wins++;
			$player1->loses++;
		}
		else if ($player1->score == $player2->score)
		{
			$player1->draws++;
			$player2->draws++;
		}
		
		$player1->for += $player1->score;
		$player1->against += $player2->score;
		$player2->for += $player2->score;
		$player2->against += $player1->score;
		
		$this->players_m->update($player1->id, array('rank'=>$player1->new_rank, 'wins'=>$player1->wins, 'loses'=>$player1->loses, 'draws'=>$player1->draws, 'for'=>$player1->for, 'against'=>$player1->against));
		$this->players_m->update($player2->id, array('rank'=>$player2->new_rank, 'wins'=>$player2->wins, 'loses'=>$player2->loses, 'draws'=>$player2->draws, 'for'=>$player2->for, 'against'=>$player2->against));
		
		return $this->insert(array(
				'player1'				=> $player1->id,
				'player1_score'			=> $player1->score,
				'player1_start_rank'	=> $player1->rank,
				'player1_end_rank'		=> $player1->new_rank,
				'player2'				=> $player2->id,
				'player2_score'			=> $player2->score,
				'player2_start_rank'	=> $player2->rank,
				'player2_end_rank'		=> $player2->new_rank
			));
			
	}
	    
}
