<?php

namespace FrontPageApp\FrontPage;

class FrontPageController
{
	private $name1;
	private $name2;
	private $conn;
	private $sql;
	private $result;
	
	public function __construct($config,$smarty,$log_default,$conn) {
	
		//$this->name1 = $config['app']['name1'];
		//$this->name2 = $config['app']['name2'];
		$this->conn = $conn;
		$log_default = $config['app']['log_default'];
		
		$smarty->template_dir =  '../lib/View/FrontPage/Template/';
		$smarty->compile_dir = '../lib/View/FrontPage/Template_c/';
		$smarty->config_dir = '../lib/View/FrontPage/Config/';
	}
	private function AssignValues($smarty,$log_default) {
		$log_default->trace('called');
		$javascript = array(
			'../../javascript/jquery/jquery-3.1.1.js',
			'../../javascript/auralight.js',
		);
		//$smarty;
		$smarty->assign( 'name1', $this->name1 );
		$smarty->assign( 'name2', $this->name2 );
		$smarty->assign( 'stylesheet', '/CSS/index.css' );
		$smarty->assign( 'javascript', $javascript );
	}
	/**
	 * Render the page.
	 */
	public function DisplayPage($smarty,$log_default) {
		
		$sql = "SELECT id, race_name, race_reputation_name  FROM al_race";
		$result = $this->conn->query($sql);

		if ($result->num_rows > 0) {
			
			// output data of each row
			while($row = $result->fetch_assoc()) {
				$this->name1 = $row["race_reputation_name"];
				$this->name2 = $row["race_name"];
				
			}
		} else {
			echo "0 results";
		}
		$this->conn->close();
		
		
		$log_default->trace('called');
		//global $smarty;
		$this->AssignValues($smarty,$log_default);
		$smarty->display( $smarty->template_dir[0] . 'index.smarty' );
	}


}