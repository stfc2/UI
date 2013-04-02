<?php

class planets {
	// Standard handling class for planets
	var $db;
	
	var $planet_obj;
	
	var $it_planet;
	
	var $active_user;
	var $visible_by_ally;
	var $explored_by_ally;
	
	// Fake fields for cached planetary data
	var $cache_planet_name;
	var	$cache_planet_owner;
	var	$cache_user_name;
	var	$cache_alliance_id;
	var $cache_alliance_name; 
	var	$cache_alliance_tag;
	var	$cache_planet_points;
	var $cache_by_ally;
	
	
	function __construct(&$db, $active_user, $planet_obj){
		$this->db = $db; // MySQL control structure
		$this->active_user = $active_user; // Store current user_id
		$this->planet_obj = $planet_obj; // Planet
		
		$sql =	'SELECT * FROM planets WHERE planet_id = '.$this->planet_obj;
		
		$this->it_planet = $this->db->queryrow($sql);	
	}
	
	function is_visible($idcheck, $alliance_flag){
		
		switch($alliance_flag){
			case 0:
				$sql = 'SELECT * FROM starsystems_details WHERE log_code = 500 AND system_id = '.$this->it_planet['system_id'].' AND user_id = '.$idcheck.' ORDER BY timestamp DESC LIMIT 0,1';
				break;
			case 1:
				$sql = 'SELECT * FROM starsystems_details WHERE log_code = 500 AND system_id = '.$this->it_planet['system_id'].' AND alliance_id = '.$idcheck.' ORDER BY timestamp DESC LIMIT 0,1';
				break;
		}
		
		if(($test = $this->db->queryrow($sql)) === false) return false;
		
		if(isset($test['log_code'])) return true;
				
		return false;
	}
	
	function is_explored($idcheck, $alliance_flag){
		
		$this->explored_by_ally = false;
		
		switch($alliance_flag){
			case 0:
				$sql = 'SELECT * FROM starsystems_details WHERE log_code = 101 AND system_id = '.$this->it_planet['system_id'].' AND user_id = '.$idcheck.' ORDER BY timestamp DESC LIMIT 0,1';
				break;
			case 1:
				$sql = 'SELECT * FROM starsystems_details WHERE log_code = 101 AND system_id = '.$this->it_planet['system_id'].' AND alliance_id = '.$idcheck.' ORDER BY timestamp DESC LIMIT 0,1';
				break;
		}
		
		if(($test = $this->db->queryrow($sql)) === false) return false;
		
		if(isset($test['log_code'])) return true;		
				
		return false;
	}
	
	function setcachevalue($idcheck, $alliance_flag) {
		
		switch($alliance_flag){
			case 0:
				$sql = 'SELECT pd.user_id, pd.alliance_id, pd.planet_name, pd.planet_owner, pd.owner_alliance, pd.planet_points, u.user_name, a.alliance_name, a.alliance_tag FROM planet_details pd LEFT JOIN user u ON u.user_id = pd.planet_owner LEFT JOIN alliance a ON a.alliance_id = pd.owner_alliance WHERE pd.log_code = 102 AND pd.planet_id = '.$this->it_planet['planet_id'].' AND pd.user_id = '.$idcheck.' ORDER BY pd.timestamp DESC LIMIT 0,1';
				break;
			case 1:
				$sql = 'SELECT pd.user_id, pd.alliance_id, pd.planet_name, pd.planet_owner, pd.owner_alliance, pd.planet_points, u.user_name, a.alliance_name, a.alliance_tag FROM planet_details pd LEFT JOIN user u ON u.user_id = pd.planet_owner LEFT JOIN alliance a ON a.alliance_id = pd.owner_alliance WHERE pd.log_code = 102 AND pd.planet_id = '.$this->it_planet['planet_id'].' AND pd.alliance_id = '.$idcheck.' ORDER BY pd.timestamp DESC LIMIT 0,1';
				break;
		}
		
		if(($qdetail = $this->db->queryrow($sql)) === false) return false;

		$this->cache_planet_name    = $qdetail['planet_name'];
		$this->cache_planet_owner   = $qdetail['planet_owner'];
		$this->cache_user_name      = $qdetail['user_name'];
		$this->cache_alliance_id    = $qdetail['owner_alliance'];
		$this->cache_alliance_name  = $qdetail['alliance_name'];
		$this->cache_alliance_tag   = $qdetail['alliance_tag'];
		$this->cache_planet_points  = $qdetail['planet_points'];
		
		return true;
		
	}
}


?>
