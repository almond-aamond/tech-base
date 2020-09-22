<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>個人ページ</title>
</head>
<body>

    <?php 
    
        //ユーザー名表示パート
        //getリクエストを受け取る
        $data=$_GET["data"];
        $data=rawurldecode($data);
        
        if($_GET["data"]){
            echo "ログイン中"."<br>";
        }
        
        // DB接続設定
	    $dsn = 'mysql:dbname=tb220110db;host=localhost';
	    $user = 'tb-220110';
	    $password = 'dmwRugZFPU';
	    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	    //4-1
	    
	    $id = $data ; // idがこの値のデータだけを抽出したい、とする

        $sql = 'SELECT * FROM users WHERE id=:id ';
        $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
        $stmt->execute();                             // ←SQLを実行する。
        $results = $stmt->fetchAll(); 
	    foreach ($results as $row){
		    //$rowの中にはテーブルのカラム名が入る
		    $name2=$row['name'];
		    echo $name2."さんのページです";
		    
	    echo "<hr>";
	    }
	    
	    
    ?>
    <?php
	$data=rawurlencode($data);
	$url="1-2.php";
	echo "<a href={$url}?data={$data}>"."みんなの記事を見る！！"."</a>"."<br>";
    ?>
    
    <?php
	$url="0-2.php";
	echo "<a href=$url>"."ログアウト"."</a>"."<br>";
    ?>
    
    <?php
    //データ挿入
    //ＳＱＬ初期設定
    
    // DB接続設定
	$dsn = 'mysql:dbname=tb220110db;host=localhost';
	$user = 'tb-220110';
	$password = 'dmwRugZFPU';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	
	
    //データベース内にテーブルを作成
	$sql = "CREATE TABLE IF NOT EXISTS article"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "title char(32),"
	. "name char(32),"
	. "time DATE,"
	. "content TEXT"
	.");";
	$stmt = $pdo->query($sql);
	
    
    
	//データベース内のテーブル一覧を表示
	$sql ='SHOW TABLES';
	$result = $pdo -> query($sql);
	foreach ($result as $row){
		echo $row[0];
		echo '<br>';
	}
	echo "<hr>";
 
    
    
    //作成したテーブルの構成要素を表示
    $sql ='SHOW CREATE TABLE article';
	$result = $pdo -> query($sql);
	foreach ($result as $row){
		echo $row[1];
	}
	echo "<hr>";
    

    //投稿機能+編集機能
    if($_POST["title"]&&$_POST["content"]){
        if($_POST['edinum']){
            $id = $_POST['edinum']; 
            //変更する投稿番号
            // idがこの値のデータだけを抽出したい、とする
            $sql = 'SELECT * FROM article WHERE id=:id ';
            $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
            $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
            $stmt->execute();                             // ←SQLを実行する。
            $results = $stmt->fetchAll();
            foreach ($results as $row){
		        if($name2==$row['name']){
	                $id = $_POST['edinum']; 
	                $title=$_POST["title"];
                    $time=date("Y-m-d");
                    $content=$_POST["content"];
	                //変更したい部分
	                
	                $sql = 'UPDATE article SET title=:title,time=:time,content=:content WHERE id=:id';
	                $stmt = $pdo->prepare($sql);
	                $stmt->bindParam(':title', $title, PDO::PARAM_STR);
	                $stmt->bindParam(':time', $time, PDO::PARAM_STR);
	                $stmt->bindParam(':content', $content, PDO::PARAM_STR);
	                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	                $stmt->execute();
                //編集機能                    
                }
	        }
            
        }else{
            //データの挿入 新規投稿部分
            $sql = $pdo -> prepare("INSERT INTO article (title, name, time, content)
            VALUES (:title, :name, :time, :content)");
	        $sql -> bindParam(':title', $title, PDO::PARAM_STR);
	        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
	        $sql -> bindParam(':time', $time, PDO::PARAM_STR);
	        $sql -> bindParam(':content', $content, PDO::PARAM_STR);
            $title=$_POST["title"];
            $name=$name2;
            $time=date("Y-m-d");
            $content=$_POST["content"];
	        $sql -> execute();
            }
        
    }

?>




<?php
    //削除機能
    if($_POST["del"]){
        $id = $_POST["del"] ; 
        $sql = 'SELECT * FROM article WHERE id=:id ';
        $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
        $stmt->execute();                             // ←SQLを実行する。
        $results = $stmt->fetchAll();
        foreach ($results as $row){
		    if($name2==$row['name']){
            $id = $_POST["del"];
        	$sql = 'delete from article where id=:id';
	        $stmt = $pdo->prepare($sql);
	        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	        $stmt->execute();

            }
	    }
	    
                       
    }
?>

<?php
    //編集機能　編集番号をフォームから受け取る
    if($_POST["edi"]){
        
        $id = $_POST["edi"] ; // idがこの値のデータだけを抽出したい、とする
        $sql = 'SELECT * FROM article WHERE id=:id ';
        $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
        $stmt->execute();                             // ←SQLを実行する。
        $results = $stmt->fetchAll();
        foreach ($results as $row){
		    if($name2==$row['name']){
                
                $oldtitle=$row['title'];
                $oldcontent=$row['content'];
                $edinum=$_POST["edi"];
                

            }
	    }
        
    }
?>

<?php
    //入力したデータレコードを抽出 表示部分

	$name = $name2 ; // nameがこの値のデータだけを抽出したい、とする

    $sql = 'SELECT * FROM article WHERE name=:name ';
    $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
    $stmt->bindParam(':name', $name, PDO::PARAM_STR); // ←その差し替えるパラメータの値を指定してから、
    $stmt->execute();                             // ←SQLを実行する。
    $results = $stmt->fetchAll(); 
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo "id:".$row['id'].'<br>';
		echo "タイトル:".$row['title'].'<br>';
		//echo "執筆者:".$row['name'].'<br>';
		echo "投稿時間:".$row['time'].'<br>';
		echo $row['content'].'<br>';
	echo "<hr>";
	}
?>

<?php
?>

<?php
?>


<form action="" method="post">
    <input type="text" name="title" placeholder="記事のタイトル"
    value="<?php if($oldtitle&&$oldcontent){
                    echo $oldtitle;
                 }
            ?>">
    <br>
    <br>
    <textarea name="content" placeholder="記事の内容">
    <?php if($oldtitle&&$oldcontent){
                    echo $oldcontent;
                 }
    ?></textarea>
    <br>
    <input type="hidden" name="edinum" placeholder="編集時"
    value="<?php if($oldtitle&&$oldcontent){
                    echo $edinum;
                 }
            ?>">
    <input type="submit" >
</form>


<form action="" method="post">
    <input type="text" name="edi" placeholder="編集したい番号" >
    <input type="submit" >
</form>


<form action="" method="post">    
    <input type="text" name="del" placeholder="削除したい投稿番号">
    <input type="submit" >
</form>


<form action="" method="post">
    <input type="text" name="name" placeholder="お名前"
    value="<?php if($oldname&&$oldstr){
                    echo $oldname;
                 }
            ?>">
    <input type="text" name="str" placeholder="コメント"
    value="<?php if($oldname&&$oldstr){
                    echo $oldstr;
                 }
            ?>">
    <input type="text" name="password" placeholder="パスワード"
    value="<?php if($oldname&&$oldstr){
                    echo $oldpass;
                 }
            ?>">    
    <input type="hidden" name="edinum" placeholder="編集時"
    value="<?php if($oldname&&$oldstr){
                    echo $edinum;
                 }
            ?>">       
    <input type="submit" >
</form>
   

    
    
</body>
</html>