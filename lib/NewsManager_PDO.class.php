<?php
class NewsManager_PDO extends NewsManager
{

	protected $db;
public function __construct(PDO $db)
	{
	$this->db = $db;}
protected function add(News $news)
	{
		$requete = $this->db->prepare('INSERT INTO news SET utilisateur =:utilisateur, titre = :titre, contenu = :contenu, dateAjout = NOW(),dateModif = NOW()');
		$requete->bindValue(':titre', $news->titre());
		$requete->bindValue(':utilisateur', $news->utilisateur());
		$requete->bindValue(':contenu', $news->contenu());
		$requete->execute();
	}

public function count()
	{
	return $this->db->query('SELECT COUNT(*) FROM news')->fetchColumn();
	}
public function delete($id)
	{
	$this->db->exec('DELETE FROM news WHERE id = '.(int)$id);
	}
public function getList($debut = -1, $limite = -1)
	{
	$sql = 'SELECT id, utilisateur, titre, contenu, DATE_FORMAT(dateAjout, \'le %d/%m/%Y à %Hh%i\') AS dateAjout, DATE_FORMAT(dateModif, \'le %d/%m/%Y à %Hh%i\') AS dateModif FROM news ORDER BY id DESC';
	if ($debut != -1 || $limite != -1)
		{
		$sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
		}
	$requete = $this->db->query($sql);
	$requete->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,'News');
	$listeNews = $requete->fetchAll();
	$requete->closeCursor();
	return $listeNews;
	}
public function getUnique($id)
	{
		$requete = $this->db->prepare('SELECT id, utilisateur, titre,contenu, DATE_FORMAT (dateAjout, \'le %d/%m/%Y à %Hh%i\') AS dateAjout, DATE_FORMAT (dateModif, \'le %d/%m/%Y à %Hh%i\') AS dateModif FROM news WHERE id = :id');
		$requete->bindValue(':id', (int) $id, PDO::PARAM_INT);
		$requete->execute();
		$requete->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,'News');
	return $requete->fetch();
	}
protected function update(News $news)
	{
	$requete = $this->db->prepare('UPDATE news SET utilisateur =:utilisateur,titre = :titre, contenu = :contenu, dateModif = NOW() WHERE id =:id');
	$requete->bindValue(':titre', $news->titre());
	$requete->bindValue(':utilisateur', $news->utilisateur());
	$requete->bindValue(':contenu', $news->contenu());
	$requete->bindValue(':id', $news->id(), PDO::PARAM_INT);
	$requete->execute();
	}
}
