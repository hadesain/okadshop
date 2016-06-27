<?php
class Dates
{
	public $date1;
	public $date2;
	public $time1;
	public $time2;
	public function dtime($heure1,$heure2)
	{
		//Extractions des différents paramètres
		list($h1, $m1, $sec1) = explode(':', $heure1);
		list($h2, $m2, $sec2) = explode(':', $heure2);
		//Calcul des timestamps
		$timestamp1 = mktime ($h1, $m1, $sec1, 7, 9, 2006);
		$timestamp2 = mktime ($h2, $m2, $sec2, 7, 9, 2006);

		$diff_heure = floor(abs($timestamp2 - $timestamp1)/60);
		//echo $diff_heure."min"; // Affiche 50min

		$timestamp = abs($timestamp2 - $timestamp1);
		$diff_heure = floor($timestamp / 3600); //Calcul des heures écoulées/restantes
		$timestamp = $timestamp - ($diff_heure * 3600);
		$diff_min = $timestamp / 60; //Calcul des minutes écoulées/restantes
		//return $diff_min; Affiche la minute 
		return $diff_heure;  // Affiche l'heure 
	}
	///date 1 and 2 format 05/02/2010 12:06
	public function GetHours($date1,$date2)
	{
			// TEMPS
		return  $date1;
		$temps = strtotime($date1);
		$temps2 = strtotime($date2);
		// JOURS
		$jours = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
		$jours_numero = date('w', $date1);
		$jours_numero2 = date('w', $date2);
		$jours_complet = $jours[$jours_numero];
		$jours_complet2 = $jours[$jours_numero2];
		// Numero du jour
		$NumeroDuJour = date('d', $temps);
		$NumeroDuJour2 = date('d', $temps2);
		
		// MOIS
		$mois = array('', 'January', 'February', 'March', 'April', 'May',
		'June', 'July', 'August', 'September', 'October', 'November', 'December');
		if(substr(date("m",$temps),0,1)==0){
			$mois_numero = preg_replace('/0/','',date("m",$temps));	
		}else{
			$mois_numero = date("m",$temps);	
		}
		if(substr(date("m",$temps2),0,1)==0){
			$mois_numero2 = preg_replace('/0/','',date("m",$temps2));	
		}else{
			$mois_numero2 = date("m",$temps2);	
		}		
		
		$mois_complet = $mois[$mois_numero];
		$mois_complet2 = $mois[$mois_numero2];
		// ANNEE
		$annee = date("Y", $temps);
		$annee2 = date("Y", $temps2);

		$time1 = strtotime("$NumeroDuJour $mois_complet $annee");
		$time2 = strtotime("$NumeroDuJour2 $mois_complet2 $annee2");
		
		if( $time1 > $time2 ) {
			$time = $time1 - $time2;
		} else {
			$time = $time2 - $time1;
		}
		 
		$time = $time / 3600;
		if(!empty($time))
		{
			return round($time);
		}
	}


    public function GetCountDaysInMonth($month=null,$year=null) {
      if ($month==null) {
           $month = date("n",time());
      }
      if ($year==null) {
           $year = date("Y",time());
      }
      $dim = date( "j", mktime(0, 0, 0, $month + 1, 1, $year) - 1 );
      return $dim;
    }
    
	function FRD2END($date){//this function convert french dates to english standar dates Y-m-d
		return date("Y-m-d", strtotime($date));
		/*$this->Date  = $date;
		$this->Date = substr($this->Date,6,4).'-'.substr($this->Date,3,2).'-'.substr($this->Date,0,2);
		return $this->Date;*/
		
	}
	function END2FRD($date){//this function convert french dates to english standar dates Y-m-d
		$this->Date  = $date;
		$this->Date = substr($this->Date,8,2).'/'.substr($this->Date,5,2).'/'.substr($this->Date,0,4);
		return $this->Date;
		
	}
	function remove_hours($date){
		$date = substr($date, 0,10);
		return $date ;
	}
	function get_Hours_from_date($date){
		$date = substr($date, 10);
		return $date ;
	}
	function Passed_days($date)
	{
		$cdate = self::remove_hours($date);
		$datetime1 = new DateTime($cdate);

		$datetime2 = new DateTime(date('Y-m-d'));

		$difference = $datetime1->diff($datetime2);
		return  $difference->d;
	}
}
?>