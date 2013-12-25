<?php
class News
{
protected $erreurs = array(),$id,$utilisateur,$titre,$contenu,$dateAjout,$dateModif;
	const UTILISATEUR_INVALIDE = 1;
	const TITRE_INVALIDE = 2;
	const CONTENU_INVALIDE = 3;
public function __construct($valeurs = array())
		{
		if (!empty($valeurs)) // Si on a spécifié des valeurs, alors on hydrate l'objet.
			{
			$this->hydrate($valeurs);
			}
}

public function hydrate($donnees)
		{
		foreach ($donnees as $attribut => $valeur)
		{
		$methode = 'set'.ucfirst($attribut);
		if (is_callable(array($this, $methode)))
		{
		$this->$methode($valeur);
		}
		}
}
public function isNew()
	{
	return empty($this->id);
	}
public function isValid()
	{
	return !(empty($this->utilisateur) || empty($this->titre) ||
	empty($this->contenu));
	}

public function setId($id)
	{
	$this->id = (int) $id;
	}
public function setUtilisateur($utilisateur)
	{
	if (!is_string($utilisateur) || empty($utilisateur))
	{
	$this->erreurs[] = self::UTILISATEUR_INVALIDE;
	}
else
	{
	$this->utilisateur =$utilisateur;
	}
}
public function setTitre($titre)
	{
	if (!is_string($titre) || empty($titre))
	{
	$this->erreurs[] = self::TITRE_INVALIDE;
	}
else
	{
	$this->titre = $titre;
	}
}
public function setContenu($contenu)
	{
	if (!is_string($contenu) || empty($contenu))
	{
	$this->erreurs[] = self::CONTENU_INVALIDE;
	}
else
	{
	$this->contenu = $contenu;
	}
}
public function setDateAjout($dateAjout)
	{
	if (is_string($dateAjout) && preg_match('`le [0-9]{2}/[0-9]{2}/[0-9]{4} à [0-9]{2}h[0-9]{2}`', $dateAjout))
	{
	$this->dateAjout = $dateAjout;
	}
}
public function setDateModif($dateModif)
	{
		if (is_string($dateModif) && preg_match('`le [0-9]{2}/[0-9]{2}/[0-9]{4} à [0-9]{2}h[0-9]{2}`', $dateModif))
	{
	$this->dateModif = $dateModif;
	}
}
public function erreurs()
	{
	return $this->erreurs;
	}
public function id()
	{
	return $this->id;
	}
public function utilisateur()
	{
	return $this->utilisateur;
	}
public function titre()
	{
	return $this->titre;
	}
public function contenu()
	{
	return $this->contenu;
	}
public function dateAjout()
	{
	return $this->dateAjout;
	}
public function dateModif()
	{
	return $this->dateModif;
	}
}