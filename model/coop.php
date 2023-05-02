<?php
	class Coop{		

		private $id;
		private $title;
		private $link;
		private $source;
		private $pubDate;
				
		function __construct($id, $title, $link, $source, $pubDate){
			$this->setId($id);
			$this->setTitle($title);
			$this->setLink($link);
			$this->setSource($source);
			$this->setPubDate($pubDate);
		}

		public function getId(){
			return $this->id;
		}
		public function setId($id){
			$this->id = $id;
		}
		public function getTitle(){
			return $this->title;
		}
		public function setTitle($title){
			$this->title = $title;
		}
		public function getLink(){
			return $this->link;
		}
		public function setLink($link){
			$this->link = $link;
		}
		public function getSource(){
			return $this->source;
		}
		public function setSource($source){
			$this->source = $source;
		}
		public function getPubDate(){
			return $this->pubDate;
		}
		public function setPubDate($pubDate){
			$this->pubDate = $pubDate;
		}

	}
?>