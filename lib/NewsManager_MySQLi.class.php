<?php
class NewsManager_MySQLi extends NewsManager
{
protected $db;
public function __construct(MySQLi $db)
	{
	$this->db = $db;
	}
protected function add(News $news)
	{
	$requete = $this->db->prepare('INSERT INTO news SET utilisateur = ?,titre = ?, contenu = ?, dateAjout = NOW(), dateModif = NOW()');
	$requete->bind_param('sss', $news->utilisateur(), $news->titre(),$news->contenu());
	$requete->execute();
	}
public function count()
	{
	return $this->db->query('SELECT id FROM news')->num_rows;
	}
public function delete($id)
	{
	$id = (int) $id;
	$requete = $this->db->prepare('DELETE FROM news WHERE id = ?');
	$requete->bind_param('i', $id);
	$requete->execute();
	}
public function getList($debut = -1, $limite = -1)
{
$listeNews = array();
	$sql = 'SELECT id, utilisateur, titre, contenu, DATE_FORMAT(dateAjout, \'le %d/%m/%Y à %Hh%i\') AS dateAjout, DATE_FORMAT(dateModif, \'le %d/%m/%Y à %Hh%i\') AS dateModif FROM news ORDER BY id DESC';
if ($debut != -1 || $limite != -1)
	{
	$sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
	}
$requete = $this->db->query($sql);
while ($news = $requete->fetch_object('News'))
	{
	$listeNews[] = $news;
	}
	return $listeNews;
}

public function getUnique($id)
	{
	$id = (int) $id;
	$requete = $this->db->prepare('SELECT id, utilisateur, titre,contenu, DATE_FORMAT (dateAjout, \'le %d/%m/%Y à %Hh%i\') AS dateAjout, DATE_FORMAT (dateModif, \'le %d/%m/%Y à %Hh%i\') AS dateModif FROM news WHERE id = ?');
	$requete->bind_param('i', $id);
	$requete->execute();
	$requete->bind_result($id, $utilisateur, $titre, $contenu,$dateAjout, $dateModif);
	$requete->fetch();
	return new News(array(
		'id' => $id,
		'utilisateur' => $utilisateur,
		'titre' => $titre,
		'contenu' => $contenu,
		'dateAjout' => $dateAjout,
		'dateModif' => $dateModif
	));
	}
protected function update(News $news)
		{
		$requete = $this->db->prepare('UPDATE news SET utilisateur = ?, titre= ?, contenu = ?, dateModif = NOW() WHERE id = ?');
		$requete->bind_param('sssi', $news->utilisateur(), $news->titre(),$news->contenu(), $news->id());
		$requete->execute();
		}
}
