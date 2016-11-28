<?php
Class Article{

	public function getImage() {
		$this->photo = str_replace('../', '', $this->photo);
		$html = '<img src="';
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
