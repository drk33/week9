<?php
$dsn = 'mysql:host=mysql01.ucs.njit.edu;dbname=drk33';
$username = 'drk33';
$password = 'uDV0XQgv';
  
try {
    $db = new PDO($dsn, $username, $password, array(PDO::ATTR_PERSISTENT => true));
    echo '<p>Connection Successful</p>' . '<br>';
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    echo "<p>An error occurred while connecting to
             the database: $error_message </p>" . "<br>";
}
class User {
    
    public function display() {
        global $db;
        $query = 'SELECT fname, lname, birthday, gender, password, phone, email 
                  FROM drk33.accounts;';
        $statement = $db->prepare($query);
        $statement->execute();
        $accountinfo = $statement->fetchAll();
        $statement->closeCursor();
        return $accountinfo;
    }
    public function insert($fname, $lname, $bday, $gender, $pass, $phone, $email) {
        global $db;
        $query = "INSERT INTO drk33.accounts
             (fname, lname, email, birthday, gender, phone, password)
          VALUES
             (:fname, :lname, :email, :birthday, :gender, :phone, :pass)";
        $statement = $db->prepare($query);
        $statement->bindValue(':fname', $fname);
        $statement->bindValue(':lname', $lname);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':birthday',$bday);
        $statement->bindValue(':gender', $gender);
        $statement->bindValue(':phone', $phone);
        $statement->bindValue(':pass', $pass);
        $statement->execute();
        $statement->closeCursor();
        echo 'User successfully added';
    }
    public function update($email, $pass) {   
        global $db;     
        $query = "UPDATE drk33.accounts
                  SET password = :pass
                  WHERE email = :email";
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':pass', $pass);
        $statement->execute();
        $statement->closeCursor();
        echo 'Password successfully updated.';

    }	
    public function delete($email) {
        global $db;
        $query = "DELETE FROM drk33.accounts
                  WHERE email = :email";
        	
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $statement->closeCursor();
        echo 'User successfully deleted';
    }
}

$me = new User();
$arr1 = $me->display();
?>

<html>
<head>
  <style>
  table, th, td{
  border: 1px solid black;
  border-collapse: collapse;}
  table {width: 50%}
  th, td {padding: 15px;}
  </style>
  
    <title>Week 9 Practice</title>
</head>
<table>
  <tr>
    <th style="text-align:left">E-Mail</th> 
    <th style="text-align:left">First Name</th>
    <th style="text-align:left">Last Name</th>
    <th style="text-align:left">Birthday</th> 
    <th style="text-align:left">Gender</th>
    <th style="text-align:left">Password</th>
  </tr>
<?php foreach ($arr1 as $account) : ?>
<html>
<body>
  <tr>
    <td><?php echo $account['email']; ?></td>
    <td><?php echo $account['fname']; ?></td>
    <td><?php echo $account['lname']; ?></td>
    <td><?php echo $account['birthday']; ?></td>
    <td><?php echo $account['gender']; ?></td>
    <td><?php echo $account['password']; ?></td>
  </tr>

<?php endforeach;?>
</table>

<?php
$testname = 'Test';
$me->insert('Test', 'User', '01-01-0001', 'female', '01234', '000-000-0000', 'test@njit.edu');
$query = 'SELECT fname, lname, birthday, gender, password, phone, email 
                  FROM drk33.accounts
                  WHERE fname = :name';
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $testname);
        $statement->execute();
        $insertTest = $statement->fetch();
        $statement->closeCursor();
        ?>
<table>
  <tr>
    <th style="text-align:left">E-Mail</th> 
    <th style="text-align:left">First Name</th>
    <th style="text-align:left">Last Name</th>
    <th style="text-align:left">Birthday</th> 
    <th style="text-align:left">Gender</th>
    <th style="text-align:left">Password</th>
  </tr>
<body>
  <tr>
    <td><?php echo $insertTest['email']; ?></td>
    <td><?php echo $insertTest['fname']; ?></td>
    <td><?php echo $insertTest['lname']; ?></td>
    <td><?php echo $insertTest['birthday']; ?></td>
    <td><?php echo $insertTest['gender']; ?></td>
    <td><?php echo $insertTest['password']; ?></td>
  </tr>
</table>

<?php
$myemail = 'drk33@njit.edu';
$me->update('drk33@njit.edu', '1234');
$query = 'SELECT fname, lname, birthday, gender, password, phone, email 
                  FROM drk33.accounts
                  WHERE email = :email';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $myemail);
        $statement->execute();
        $updateTest = $statement->fetch();
        $statement->closeCursor();
        ?>
<table>
  <tr>
    <th style="text-align:left">E-Mail</th> 
    <th style="text-align:left">First Name</th>
    <th style="text-align:left">Last Name</th>
    <th style="text-align:left">Birthday</th> 
    <th style="text-align:left">Gender</th>
    <th style="text-align:left">Password</th>
  </tr>
<body>
  <tr>
    <td><?php echo $updateTest['email']; ?></td>
    <td><?php echo $updateTest['fname']; ?></td>
    <td><?php echo $updateTest['lname']; ?></td>
    <td><?php echo $updateTest['birthday']; ?></td>
    <td><?php echo $updateTest['gender']; ?></td>
    <td><?php echo $updateTest['password']; ?></td>
  </tr>
</table>

<?php
$testemail = 'test@njit.edu';
$me->delete('test@njit.edu');
?>

<table>
  <tr>
    <th style="text-align:left">E-Mail</th> 
    <th style="text-align:left">First Name</th>
    <th style="text-align:left">Last Name</th>
    <th style="text-align:left">Birthday</th> 
    <th style="text-align:left">Gender</th>
    <th style="text-align:left">Password</th>
  </tr>
<?php foreach ($arr1 as $account) : ?>
<html>
<body>
  <tr>
    <td><?php echo $account['email']; ?></td>
    <td><?php echo $account['fname']; ?></td>
    <td><?php echo $account['lname']; ?></td>
    <td><?php echo $account['birthday']; ?></td>
    <td><?php echo $account['gender']; ?></td>
    <td><?php echo $account['password']; ?></td>
  </tr>

<?php endforeach;?>
</table>