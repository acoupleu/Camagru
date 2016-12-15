<?php
Class Article{

	public function getImage() {
		$this->photo = str_replace('../', '', $this->photo);
		$html = '<img class=';
		$html .= substr($this->photo, strrpos($this->photo, "/") + 1, strrpos($this->photo, "/") - 5);
		$html .= ' src="';
		$html .= $this->photo;
		$html .= '">';
		return $html;
	}

	public function getUrlImage() {
		$this->photo = str_replace('../', '', $this->photo);
		return $this->photo;
	}
}
?>
