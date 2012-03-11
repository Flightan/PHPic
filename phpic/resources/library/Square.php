<?php


/**
 * Exemple de classe
 * @author florian
 *
 */
class Square {
	
 	private $piece;
 	private $id;
 	private $is_selected;
 	private $is_possible;

	public function __construct($id) {
		$this->id = $id;
		$this->piece = false;
		$this->is_selected = false;
		$this->is_possible = false;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function setPiece($piece) {
		$this->piece = $piece;
	}
	
	public function select() {
		$this->is_selected = true;
	}
	
	public function setPossible() {
		$this->is_possible = true;
	}
	
	public function deselect() {
		$this->is_selected = false;
		$this->is_possible = false;
	}
	
	public function getPiece() {
		return $this->piece;
	}
	
	public function hasPiece() {
		return $this->piece != false;
	}
	
	public function enemyPiece($color) {
		return $this->hasPiece() && $this->piece->getColor() != $color;
	}
	
	public function isSelected() {
		return $this->is_selected;
	}
	
	public function isPossible() {
		return $this->is_possible;
	}
}