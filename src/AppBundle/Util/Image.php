<?php

namespace AppBundle\Util;

class Image {

	const REDIM_CONTAIN = 'REDIM_CONTAIN';
	const REDIM_COVER = 'REDIM_COVER';

	public $tabErreur = []; // Renseigné si erreur.
	private $chemin; // Chemin du fichier.
	private $largeur; // Largeur en px.
	private $hauteur; // Hauteur en px.
	private $type; // Type PHP.

	public function __construct($chemin = null) {
		$this->chemin = $chemin;
		list($this->largeur, $this->hauteur, $this->type) = getimagesize($this->chemin);
		if ($this->largeur === null) {
			$this->tabErreur[] = I18n::get('IMAGE_ERR_NO_IMAGE_FOUND');
			return;
		}
		if ($this->type !== IMAGETYPE_JPEG && $this->type !== IMAGETYPE_PNG) {
			$this->tabErreur[] = I18n::get('IMAGE_ERR_WRONG_IMAGE_TYPE');
			return;
		}
	}

	public function copier($largeurCadreDest, $hauteurCadreDest, $cheminDest, $modeRedim = self::REDIM_CONTAIN, $qualite = null) {
		if (!$qualite) {
			$qualite = $this->type === IMAGETYPE_JPEG ? 60 : 6;
		}
		$xSrc = 0;
		$ySrc = 0;
		$ratioSrc = $this->largeur / $this->hauteur;
		$ratioCadreDest = $largeurCadreDest / $hauteurCadreDest;
		if ($this->largeur <= $largeurCadreDest || $this->hauteur <= $hauteurCadreDest || $modeRedim === self::REDIM_CONTAIN) {
			if ($this->largeur <= $largeurCadreDest && $this->hauteur <= $hauteurCadreDest) {
				if (!copy($this->chemin, $cheminDest)) {
					$this->tabErreur[] = I18n::get('IMAGE_ERR_CANT_WRITE');
				}
				return;
			}
			if ($ratioSrc < $ratioCadreDest) {
				$hauteurDest = $hauteurCadreDest;
				$largeurDest = round($hauteurDest * $ratioSrc);
			} else {
				$largeurDest = $largeurCadreDest;
				$hauteurDest = round($largeurDest / $ratioSrc);
			}
			$largeurSrc = $this->largeur;
			$hauteurSrc = $this->hauteur;
		} elseif ($modeRedim === self::REDIM_COVER) {
			if ($ratioSrc < $ratioCadreDest) {
				$largeurSrc = $this->largeur;
				$hauteurSrc = round($largeurSrc / $ratioCadreDest);
				$ySrc = ($this->hauteur - $hauteurSrc) / 2;
			} else {
				$hauteurSrc = $this->hauteur;
				$largeurSrc = round($hauteurSrc * $ratioCadreDest);
				$xSrc = ($this->largeur - $largeurSrc) / 2;
			}
			$largeurDest = $largeurCadreDest;
			$hauteurDest = $hauteurCadreDest;
		}
		if (!$resSrc = $this->type === IMAGETYPE_JPEG ? imagecreatefromjpeg($this->chemin) : imagecreatefrompng($this->chemin)) {
			$this->tabErreur[] = I18n::get('IMAGE_ERR_OUT_OF_MEMORY');
			return;
		}
		if (!$resDest = imagecreatetruecolor($largeurDest, $hauteurDest)) {
			$this->tabErreur[] = I18n::get('IMAGE_ERR_OUT_OF_MEMORY');
			return;
		}
		if (!imagecopyresampled($resDest, $resSrc, 0, 0, $xSrc, $ySrc, $largeurDest, $hauteurDest, $largeurSrc, $hauteurSrc)) {
			$this->tabErreur[] = I18n::get('IMAGE_ERR_OUT_OF_MEMORY');
			return;
		}
		if (!($this->type === IMAGETYPE_JPEG ? imagejpeg($resDest, $cheminDest, $qualite) : imagepng($resDest, $cheminDest, $qualite))) {
			$this->tabErreur[] = I18n::get('IMAGE_ERR_CANT_WRITE');
			return;
		}
		imagedestroy($resSrc);
		imagedestroy($resDest);
	}

}

