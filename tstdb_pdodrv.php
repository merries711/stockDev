<?php  
$database = "AdventureWorks";  
$server_ip = '192.168.1.7';
$uid = 'sa';
$pwd = '123';

$conn = new PDO("sqlsrv:server=$server_ip;Database=$database",$uid,$pwd);
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
//$conn->setAttribute( PDO::SQLSRV_ATTR_QUERY_TIMEOUT, 1 );  

//================================//

$contact = "Sales Agent";  
$stmt = $conn->prepare("select * from Person.ContactType where name = ?");  
$stmt->bindParam(1, $contact);  
$contact = "Owner";  
$stmt->execute();  
  
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {  
   print "$row[Name]\n\n";  
}  
  
$stmt = null;  
$contact = "Sales Agent";  
$stmt = $conn->prepare("select * from Person.ContactType where name = :contact");  
$stmt->bindParam(':contact', $contact);  
$contact = "Product Manager";  
$stmt->execute();  

  
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {  
   print "$row[Name]\n\n";  
} 
  
?>  