<?php

class Weather_WeatherCollection implements Iterator, Countable {

	protected $collection = array();
	protected $pointer = 0;				//	for Iterator

	public function addToCollection(Weather_WeatherDTO $weatherdto) {
		$this->collection[] = $weatherdto;
	}
	
	public function saveToDatabase() {
		$records_saved = 0;
		foreach ($this->collection as $dto) {
			if ($dto->saveToDatabase()) $records_saved++;
		}
		return $records_saved;
	}

	/*****************************************
	*
	*	Method to implement Countable
	*
	*****************************************/
	
	public function count() {
		return count($this->collection);
	}


	/*****************************************
	*
	*	Methods to implement Iterator
	*
	*****************************************/

	
	public function rewind() {
		$this->pointer = 0;
	}
	
	public function current() {
		return $this->collection[$this->pointer];
	}
	
	public function key() {
		return $this->pointer;
	}
	
	public function next() {
		$item = $this->collection[$this->pointer];
		if ($item) $this->pointer++;
		return $item;
	}
	
	public function valid() {
		if ($this->pointer >= count($this->collection) ) {
			return false;
		} else {
			return (isset($this->collection[$this->pointer]));
		}
	}


}

?>