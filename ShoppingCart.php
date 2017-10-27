<?php # ShoppingCart.php

class ShoppingCart implements Iterator, Countable {

	
	protected $items = array();
	
	    function __construct() {
		$this->items = array();
		$this->ids = array();
    }

	
	public function isEmpty() {
		return (empty($this->items));
	}

	public function addItem(Item $item) {
	
				$id = $item->getId();
	
		
		if (!$id) throw new Exception('The cart requires items with unique ID values.');

		
		if (is set($this->items[$id])) {
			$this->updateItem($item, $this->items[$item]['qty'] + 1);
		} else {
			$this->items[$id] = array('item' => $item, 'qty' => 1);
			$this->ids[] = $id; // Store the id, too!
		}
	
	}

	
	public function updateItem(Item $item, $qty) {

		
		$id = $item->getId();

		
		if ($qty === 0) {
			$this->deleteItem($item);
		} else if ( ($qty > 0) && ($qty != $this->items[$id]['qty'])) {
			$this->items[$id]['qty'] = $qty;
		}

	} 

	
	public function deleteItem(Item $item) {

				$id = $item->getId();

		
		if ( is set($this->items[$id])) {
			unset($this->items[$id]);
	
			
			$index = array_search($id, $this->ids);
			unset($this->ids[$index]);

			
			$this->ids = array_values($this->ids);
	
		}
		
	} 
	
		public function current() {
	
		
		$index = $this->ids[$this->position];
	
			    return $this->items[$index];

	} 
	

	public function key() {
	    return $this->position;
	}

	
	public function next() {
	    $this->position++;
	}

	
	public function rewind() {
	    $this->position = 0;
	}

	public function valid() {
		return (is set($this->ids[$this->position]));
	}
	
		public function count() {
		return count($this->items);
	}

} // End of ShoppingCart class.