<?php

	
	class Personne
	{
		private $id_pers;
		private $pseudo;
		private $mdp;
		private $nom;
		private $prenom;
		private $age;
		private $grade;


		function __construct()
		{
			$this->__toString();
		}

		public function getnom()
		{
			return $this->nom;
		}

		public function getmdp()
		{
			return $this->mdp;
		}

		public function getpseudo()
		{
			return $this->pseudo;
		}

		public function getid_pers()
		{
			return $this->id_pers;
		}

		public function getprenom()
		{
			return $this->prenom;
		}

		public function getage()
		{
			return $this->age;
		}

		public function getgrade()
		{
			return $this->grade;
		}

		public function __toString()
		{
			return  $this->getid_pers()." ".$this->getmdp()." ".$this->getpseudo()." ".$this->getnom()." ".$this->getprenom()." ".$this->getage()." ".$this->getgrade();
		}


	}



	class Evenement
	{
		private $id_even;
		private $nom;
		private $dates;
		private $lieux;
		private $COORD_LONG;
		private $COORD_LAT;
		private $note;
		private $eff_max;
		private $description;

		function __construct()
		{
			$this->__toString();
		}

		public function getnom()
		{
			return $this->nom;
		}
		public function getCOORD_LONG()
		{
			return $this->COORD_LONG;
		}
		public function getCOORD_LAT()
		{
			return $this->COORD_LAT;
		}

		public function getdates()
		{
			return $this->dates;
		}

		public function getid_even()
		{
			return $this->id_even;
		}

		public function getlieux()
		{
			return $this->lieux;
		}
		public function getnote()
		{
			return $this->note;
		}
	
		public function geteff_max()
		{
			return $this->eff_max;
		}
		public function getdescription()
		{
			return $this->description;
		}

		public function setnom($name)
		{
			$this->nom = $name;
		}



		public function __toString()
		{
			return  $this->getid_even()." ".$this->getnom()." ".$this->getdates()." ".$this->getlieux()." ".$this->getnote()." ".$this->geteff_max()." ".$this->getdescription();
		}
	}



	class Theme
	{
		private $id_theme;
		private $nom;

		function __construct()
		{
			$this->__toString();
		}

		public function getid_theme()
		{
			return $this->id_theme;
		}

		public function getnom()
		{
			return $this->nom;
		}


		public function __toString()
		{
			return $this->getid_theme()." ".$this->getnom();
		}
	}



	class Caracterise
	{
		private $id_theme;
		private $id_even;

		function __construct()
		{
			$this->__toString();
		}

		public function getid_theme()
		{
			return $this->id_theme;
		}

		public function getid_even()
		{
			return $this->id_even;
		}


		public function __toString()
		{
			return $this->getid_theme()." ".$this->getid_even();
		}

	}


	class Participe
	{
		private $id_pers;
		private $id_even;
		private $note_perso;

		function __construct()
		{
			$this->__toString();
		}

		public function getid_pers()
		{
			return $this->id_pers;
		}

		public function getid_even()
		{
			return $this->id_even;
		}

		public function getnote_perso()
		{
			return $this->note_perso;
		}

		public function __toString()
		{
			return  $this->getid_even()." ".$this->getid_pers()." ". $this->getnote_perso();
		}
	}
	echo("test !");

	// $test = new Personne();
	// echo $test->__toString();

?>