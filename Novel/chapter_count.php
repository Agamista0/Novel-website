<?php 
include 'php/db.php';

$stmt = $pdo->prepare("SELECT COUNT(*) FROM chapters ");
$stmt->execute();
$count = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo $count ;

?>
