PHP (signup.php):
```php
<?php


function connect ()
{
    $connect = mysqli_connect("localhost","user","asdasdasd"); //此处登录进database
    $db=mysqli_select_db($connect,"myData"); //此处选择table
    if(!$connect or !$db){
        exit(mysqli_error($connect));
    }
    return $connect; //此处的这个$connect是mysqlli_conncet函数连接到数据库后返回的一个对象
}
function query($query)
{
    $connection= connect();
    $query_result=mysqli_query( $connection,$query); //确保链接到该database后执行query指定的操作
    if (!$query_result) {
        die('Error: ' . mysqli_error($connection));
    }
    mysqli_close($connection);
    //echo "IT is ok . <br>";
    return $query_result;

}



if (isset($_POST['signup'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = hash('sha256', $password); //哈希密码

    $connection = connect();

    //检查是否存在相同的电子邮件地址或昵称
    $query = "SELECT * FROM Users WHERE email='$email'";
    $result = query($query);
    if (mysqli_num_rows($result) > 0) {
        echo "Email already exists.";
        exit();
    }

    $query = "INSERT INTO Users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
    query($query);

    session_start();
    $_SESSION['name'] = $name;
    header("Location: Main.html");
    exit();
}
