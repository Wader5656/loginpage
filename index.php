<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form class="center" method="POST" action="index.php">
        <div id = "login_panel">
            <H1 id="header">Login page</H1>
            <div>
                <h2 id = "upper">Enter your username and password!<h2>
                <div>
                    <input id = "username" type="text" name="username" placeholder="username">
                </div>
                <div>
                    <input id = "password" type="password" name="password" placeholder="password">
                </div>
                <div>
                    <input type="submit" id="submit" value="login">
                </div>
            </div>
        </div>
    </form>



<?php

$myfile = fopen("password.txt", "r") or die("Unable to open file!");
$k = 1;
$userpass = "";
$users = array();





while (!feof($myfile))
{
    $karakter = fgets($myfile);
    
    for ($i = 0; $i < strlen($karakter); $i++)
    {
        if (ord($karakter[$i]) == 10)
        {
            $k = 1;
            break;
        }
      
        switch ($k)
        {
            case 1:
                $userpass.=chr(ord($karakter[$i])-5);
                $k++;
                break;
            case 2:
                $userpass .= chr(ord($karakter[$i])+14);
                $k++;
                break;
            case 3:
                $userpass .= chr(ord($karakter[$i])-31);
                $k++;
                break;
            case 4:
                $userpass .= chr(ord($karakter[$i])+9);
                $k++;
                break;
            case 5:
                $userpass .= chr(ord($karakter[$i])-3);
                $k = 1;
                break;
        }
    }
    $users[] = $userpass;
    $userpass = "";
   
}

fclose($myfile);

   $link = mysqli_connect("localhost", "root","","adatok")
   or die("nem sikerült kapcsolódni az adatbázishoz");
  
    $username=$_POST["username"] ??NULL;
    $password=$_POST["password"] ??NULL;

    
    if($result = $link -> query("Select titkos from tabla where Username = '$username'" )){
        $table = $result ->fetch_all();
    }
    $user = $username ."*" . $password;
    $usernames = array();
    for ($i = 0; $i < count($users);$i++){
        $sajatuser = "";
        for ($j = 0; $j < strlen($users[$i]);$j++){
            if($users[$i][$j] != '*'){
            $sajatuser .= $users[$i][$j];
            }
            else {
                $usernames[] = $sajatuser;
                break;
             }
        }
    }
    
    
    if ($username != NULL){
    if (in_array($username,$usernames)){
        if(in_array($user,$users)){
            $szin =  $table[0][0];
            echo "<body style='background-color:$szin'>";
            echo '<style type="text/css">
            #login_panel
                   {
                    display: none;
                   }
           </style>';
            echo '<script>alert("Sikeres bejelentkezés '. $username . '!")</script>';
        }
        else{
            echo "<body style='background-color:yellowgreen'>";
            echo '<style type="text/css">
            #login_panel
                   {
                    display: none;
                   }
           </style>';
            echo '<script>alert("Hibás jelszó!")</script>';
           header("refresh:3;url = http://www.police.hu/");
        }
    
    }
    else{
        echo "<body style='background-color:yellowgreen'>";
        echo '<script>alert("Nincs ilyen felhasználó!")</script>';
        
    }
    }
?>





</body>
</html>

