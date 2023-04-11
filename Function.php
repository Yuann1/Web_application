<?php
define('HOSTNAME','localhost'); //给constant（HOSTNAME）赋值 localhost
define('USERNAME','user');
define('PASSWORD','asdasdasd');
define('DB','myData');






function connect ()
{
    $connect = mysqli_connect("localhost","user","asdasdasd"); //此处登录进database
    $db=mysqli_select_db($connect,"myData"); //此处选择table
    if(!$connect or !$db){
        exit(mysqli_error($connect));
    }
    return $connect; //此处的这个$connect是mysqlli_conncet函数连接到数据库后返回的一个对象
}
//$query 是sql指令
function query($query)
{
    $connection= connect();
    $query_result=mysqli_query( $connection,$query); //确保链接到该database后执行query指定的操作
    mysqli_close($connection);
   //echo "IT is ok . <br>";
    return $query_result;

}
function fetch()
{
    $connection = connect();
    $table = mysqli_query($connection, 'SELECT * FROM News');
    echo '<style>
            .row {
                display: flex;
                flex-wrap: wrap;
                margin-bottom: 10px;
            }
            .cell {
                flex: 1;
                border: 1px solid black;
                padding: 5px;
                text-align: center;
            }
            .header {
                font-weight: bold;
                background-color: #ddd;
            }
          </style>'; // 添加CSS样式
    echo '<div class="row header">';
    echo '<div class="cell">ID</div>';
    echo '<div class="cell">Author</div>';
    echo '<div class="cell">Age</div>';
    echo '<div class="cell">Book Name</div>';
    echo '<div class="cell">Publish Date</div>';
    echo '<div class="cell">Category</div>';
    echo '</div>';
    while ($array = mysqli_fetch_assoc($table))
    {
        echo '<div class="row">';
        foreach ($array as $value)//该方法可取的表中所有值（不包括键名）
//foreach($array as $key => $value) 该方法可取键名（列名）和值
            // foreach（$row as $key =>$value ）{ if ($key == 'Name') 然后echo $value}

        {
            echo '<div class="cell">' . $value . '</div>';
        }
        echo '</div>';
    }
}
//query($query1);




//$asd= "INSERT INTO `News` ( `AuthorName`, `BookName`, `PublicationDate`, `BookType`) VALUES ( 'asdasdCHen', 'asdad', '1592-02-02', 'asddd');";
//INSERT INTO `News` (`Id`, `AuthorName`, `Age`, `BookName`, `PublicationDate`, `BookType`) VALUES ('11', 'CHen', '23', 'sasd', '1592-02-02', 'asddd');


if(isset($_POST['delete'])) //delete page will send name属性是delete的东西的值
{  if(is_numeric($_POST['delete']))
    {
    $id = $_POST['delete'];
    $query = "Delete FROM News WHERE Id = '$id'";
    query($query);
    }
    else {
        $authorName= $_POST['delete'];
        $query = "Delete FROM News WHERE AuthorName = '$authorName'";
        query($query);
    }
}
if(isset($_POST['AuthorName']))
{
    $AuthorName = $_POST['AuthorName'];
    $BookName = $_POST['BookName'];
    $PublicationDate = $_POST['PublicationDate'];
    $BookType = $_POST['BookType'];
    $query = "INSERT INTO `News` ( `AuthorName`, `BookName`, `PublicationDate`, `BookType`) VALUES ( '$AuthorName', '$BookName', '$PublicationDate', '$BookType');";
    query($query);

}
fetch();


