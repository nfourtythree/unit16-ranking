<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

	class Elo
	{
		var $starting_points = 1200;
		var $provisional_matches = 5;
		
		function __construct()
		{
			
		}
		
		
		function match($player1, $player2, $debug=false)
		{
			if (!empty($player1) AND !empty($player2))
			{
				$player1_expected = $this->expected($player1->rank, $player2->rank);
				if ($debug) echo $player1->name . ' expected score: '.$player1_expected.'<br>';
				$player2_expected = $this->expected($player2->rank, $player1->rank);
				if ($debug) echo $player2->name . ' expected score: '.$player2_expected.'<br>';
				
				if ($player1->score > $player2->score)
				{
					if ($debug) echo $player1->name . ' beat ' . $player2->name.'<br>';
					$player1_points = 1;
					$player2_points = 0;
				}
				else if ($player2->score > $player1->score)
				{
					if ($debug) echo $player2->name . ' beat ' . $player1->name.'<br>';
					$player1_points = 0;
					$player2_points = 1;
					
				}
				else if ($player1->score == $player2->score)
				{
					if ($debug) echo $player1->name . ' drew with ' . $player2->name.'<br>';
					$player1_points = 0.5;
					$player2_points = 0.5;
				}
				
				$player1_new_ranking = round( $player1->rank + $this->k_factor($player1) * ($player1_points - $player1_expected) );
				$player2_new_ranking = round( $player2->rank + $this->k_factor($player2) * ($player2_points - $player2_expected) ) ;
				
					if ($debug) echo $player1->name . ' new ranking: ' . $player1_new_ranking.' [diff: ' . ($player1_new_ranking - $player1->rank) . ']<br>';
					if ($debug) echo $player2->name . ' new ranking: ' . $player2_new_ranking.' [diff: ' . ($player2_new_ranking - $player2->rank) . ']<br>';
				
				return array(round($player1_new_ranking), round($player2_new_ranking));
			}
		}
		
		function expected($pa, $pb)
		{
			$expected = 1 / (1 + pow(10, (($pb - $pa) / 400)));
			
			return $expected;
		}
		
		function k_factor($player)
		{
			// do something dependant on the player
			$CI =& get_instance();
			$num_matches = $CI->matches_m->count_by('player1',$player->id) + $CI->matches_m->count_by('player2',$player->id);
			if ($player->rank >= 2400)
			{
				return 10;
			}
			else if ($num_matches >= 30)
			{
				return 15;
			}
			else
			{
				return 25;
			}
		}
	
	}

