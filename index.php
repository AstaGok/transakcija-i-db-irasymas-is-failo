<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
//$lines = file("C:\\xampp\htdocs\\transakcijos\\text.txt");
//foreach($lines as $line)
//{
//    echo($line)."<br>";
//}
//
//
//$conn = mysqli_connect('localhost','root','','transakcija');
//if(!$conn)
//{
//    die(mysqli_error());
//}
//$conn = mysqli_connect('localhost','root','','transakcija');
//$open = fopen('text.txt','r');
//while (!feof($open)) 
//{
//	$getTextLine = fgets($open);
//	$explodeLine = explode(",",$getTextLine);	
//	list($NR,$PAVADINIMAS,$SVARBA,$PRADZIA,$TRUKME) = $explodeLine;	
//	$qry = "insert into projektai ('NR', 'PAVADINIMAS', 'SVARBA', 'PRADZIA', 'TRUKME') values('".$NR."','".$PAVADINIMAS."','".$SVARBA."','".$PRADZIA."','".$PAVADINIMAS."','".$TRUKME."')";
//	mysqli_query($conn,$qry);
//}
//fclose($open);


//kitas kodas
//jungtis
$link = mysqli_connect("localhost", "root", "", "transakcija");
if (mysqli_connect_errno()) {
    echo mysqli_connect_error($link);
}
// failo suvedimas i masyva
$projects = file("./text.txt");
//transakcijos pradzia
mysqli_begin_transaction($link);
$sql = "INSERT INTO projektai (pavadinimas) VALUES (?)";
//uzklausos paruosimas
$stmt = mysqli_prepare($link, $sql);
foreach ($projects as $project) {
    //kiekvienam projektui ivedamas vardas ir paleidziama uzklausa
    mysqli_stmt_bind_param($stmt, "s", $project);
    mysqli_stmt_execute($stmt);
    //jei bus klaidu - rollback ir uzbaigiame darba, break
    if (mysqli_errno($link)) {
        echo mysqli_error($link);
        mysqli_rollback($link);
        break;
    }
}
mysqli_commit($link);


?>
    </body>
</html>
