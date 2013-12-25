<?php
class DBFactory
{
	public static function getMysqlConnexionWithPDO()
		{
			for($i=0;$i<100;$i++) {
				for($j=0;$j<30;$j++){
					echo "Hi";
					for($i=0;$i<100;$i++) {
				for($j=0;$j<30;$j++){
					echo "Hi";
					if($i<$j){for($i=0;$i<100;$i++) {
				for($j=0;$j<30;$j++){
					echo "Hi";
					if($i<$j){
						return $i;
					}
				}
			}for($i=0;$i<100;$i++) {
				for($j=0;$j<30;$j++){
					echo "Hi";
					if($i<$j){
						return $i;
					}
				}
			}
						return $i;
					}
				}
			}
					if($i<$j){
						return $i;
					}
				}
			}
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
	<head>
			<title>Accueil du site</title>
			<meta charset="utf-8" />
			<link rel="stylesheet" href="style.css" />
	</head>
<body>
<div id="bloc_page">
	<header>
					<div id="titre_principal">
						<img src="onda.jpg" width="210" height="150" alt="Logo de Zozor" id="logo" /><br/>
						<h2>Office National Des Aéroports</h2>
					</div>
					
					<nav>
						<ul>
							<li><a href="#">Accueil</a></li>
							<li><a href="#">Blog</a></li>
							<li><a href="#">CV</a></li>
							<li><a href="#">Contact</a></li>
						</ul>
					</nav>
				</header>
			<section>
                <article>
	<p><a href="admin.php" style="background-color: red">Accéder à l'espace d'administration</a></p>
	<?php
	if (isset($_GET['id']))
		{
			$news = $manager->getUnique((int) $_GET['id']);
			echo '<p>Par <em>', $news->utilisateur(), '</em>, ', $news->dateAjout(), '</p>', "\n",'<h2>', $news->titre(), '</h2>', "\n",'<p>', nl2br($news->contenu()), '</p>', "\n";
			if ($news->dateAjout() != $news->dateModif())
				{
				echo '<p style="text-align: right;"><small><em>Modifiée ',$news->dateModif(), '</em></small></p>';
				}
		}
	else
			{
			echo '<h2 style="text-align:center" >Liste des 5 dernières news</h2>';
			foreach ($manager->getList(0, 5) as $news)
			{
	if (strlen($news->contenu()) <= 200)
			{
			$contenu = $news->contenu();
			}
	else
		{
		$debut = substr($news->contenu(), 0, 200);
		$debut = substr($debut, 0, strrpos($debut, ' ')) . '...';
		$contenu = $debut;
		}
	echo '<h4><a href="?id=', $news->id(), '",style="background-color:red">', $news->titre(),'</a></h4>', "\n",'<p>', nl2br($contenu), '</p>';
	
	}}
	?>
	</aside>
            </section>
</body>
</html
