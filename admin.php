<?php
	class DBFactory
	{
		 public static function getMysqlConnexionWithPDO()
	{
			       $db=new PDO('mysql:host=localhost;dbname=news','root','');
			       $db->setAttribute(PDO::AFTER_ERRMODE,PDO::ERRMODE_EXCEPTION);
			       return $db;
	}
		    public static function getMysqlConnexionWithMySQLi(){
			return new MYSQLi('localhost','root','','news');
		}
	}
?>
<?php
		       require 'lib/autoload.inc.php';
			   $db = DBFactory::getMysqlConnexionWithMySQLi();
			   $manager = new NewsManager_MySQLi($db);
		if (isset($_GET['modifier']))
				{
				$news = $manager->getUnique ((int) $_GET['modifier']);
				}
		if (isset($_GET['supprimer']))
				{
				     $manager->delete((int) $_GET['supprimer']);
				     $message = 'La news a bien été supprimée !';
				}
		if (isset($_POST['utilisateur']))
			{
			$news = new News(
			array(
			'utilisateur' => $_POST['utilisateur'],
			'titre' => $_POST['titre'],
			'contenu' => $_POST['contenu']
			)
			);
		if (isset($_POST['id']))
			{
			$news->setId($_POST['id']);
			}
		if ($news->isValid())
			{
			$manager->save($news);
			$message = $news->isNew() ? 'La news a bien été ajoutée !' : 'La news a bien été modifiée !<br/>';
			}
		else
			{
			$erreurs = $news->erreurs();
			}
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
	<title>Administration</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="style.css" />
</head>
<body>
	<p><a href="." style="background-color: red">Accéder à l'accueil du site</a></p>
	<form action="admin.php" method="post">
	<p style="text-align: center">
	<?php
		if (isset($message))
		{
		echo $message, '<br />';
	}?>
	<?php if (isset($erreurs) && in_array(News::UTILISATEUR_INVALIDE,$erreurs)) echo 'L\'utilisateur est invalide.<br />'; ?>
		<br/>
		<br/>
	Utilisateur :<input type="text" name="utilisateur" value="<?php if(isset($news)) echo $news->utilisateur(); ?>" /><br />
	              <?php if (isset($erreurs) && in_array(News::TITRE_INVALIDE,$erreurs)) echo 'Le titre est invalide.<br />'; ?>
	Titre :       <input type="text" name="titre" value="<?php if(isset($news)) echo $news->titre(); ?>" /><br />
	           <?php if (isset($erreurs) && in_array(News::CONTENU_INVALIDE, $erreurs)) echo 'Le contenu est invalide.<br />'; ?>
	Contenu :<br /><textarea rows="8" cols="60" name="contenu"><?php if (isset($news)) echo $news->contenu(); ?>
	     </textarea><br />
	<?php
	      if(isset($news) && !$news->isNew())
	{?>
		<input type="hidden" name="id" value="<?php echo $news->id(); ?>" />
		<input type="submit" value="Modifier" name="modifier" />
	<?php
		}else
		{?>
		<input type="submit" value="Ajouter" />
		<?php
	}?>
	</p>
	</form>
		<p style="text-align: center">Il y a actuellement <?php echo $manager->count(); ?> news. En voici la liste :</p>
	<table bgcolor="red">
	<tr><th>Utilisateur</th><th>Titre</th><th>Date d'ajout</th><th>Dernière modification</th><th>Action</th></tr>
	<?php
	foreach ($manager->getList() as $news)
		{
			echo '<tr><td>', $news->utilisateur(), '</td><td>', $news->titre(),'</td><td>', $news->dateAjout(), '</td><td>', ($news->dateAjout() ==$news->dateModif() ? '-' : $news->dateModif()), '</td><td><a href="?modifier=', $news->id(), '">Modifier</a> | <a href="?supprimer=',$news->id(), '">Supprimer</a></td></tr>', "\n";
		}
	?>
	</table>
</body>
</html>