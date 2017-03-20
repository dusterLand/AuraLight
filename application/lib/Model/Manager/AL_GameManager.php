<?php

namespace AuraLight\Model\Manager;
use AuraLight\Model\Player\AL_Player;

class AL_GameManager {
	
	private $player_id;
	private $player;
	
	public function __construct(){
		$this->player_id = "684ffcdb-f66e-4987-9a0c-f45e4376f5d6";
	}
	public function displayManager (){
		$this->player = new AL_Player($this->player_id);
		$this->player->email();
		$this->player->username();
		$this->player->name_first();
		$this->player->name_middle();
		$this->player->name_last();
		//var_dump ($this->player);
		
		return $this->player;
		
	}
}