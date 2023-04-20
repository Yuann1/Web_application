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

if (isset($_POST['signin'])) {
    $email = $_POST['email'];
    //$password = $_POST['password'];
    $hashed_password = hash('sha256', $_POST['password']); //按照sha256的形式来哈希密码

    $connection = connect();
    $query = "SELECT * FROM Users WHERE email='$email' AND password='$hashed_password'";
    $result = query($query);
    //检查在这个数据库中能否找到这个emali和password的name
    if ($result && mysqli_num_rows($result) == 1) {
        session_start(); //将用户名存储在这个session里
        $_SESSION['name'] = mysqli_fetch_assoc($result)['name'];
        header("Location: Main.html");
        exit();
    } else {
        echo "Invalid email or password.";
    }
}