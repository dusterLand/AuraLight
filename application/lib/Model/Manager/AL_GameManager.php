<?php

namespace AuraLight\Model\Manager;
use AuraLight\Model\Player\AL_Player;

class AL_GameManager {
	
	private $player_id;
	private $player;
	
	public function __construct(){
		$this->player_id = "78db8576-b292-494d-b385-b9bffb5d3887";
	}
	public function displayManager (){
		$this->player = new AL_Player($this->player_id);
		$this->player->email();
		$this->player->username();
		$this->player->name_first();
		$this->player->name_middle();
		$this->player->name_last();
		$this->player->password();
		//var_dump ($this->player);
		
		return $this->player;
		
	}
}