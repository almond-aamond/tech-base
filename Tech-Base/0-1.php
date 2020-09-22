<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>登録成功or失敗</title>
</head>
<body>
    

    
    
    <?php 
    if($_GET["username"]&$_GET["name"]&$_GET["password"]){
    	// DB接続設定
	    $dsn = 'mysql:dbname=tb220110db;host=localhost';
	    $user = 'tb-220110';
	    $password = 'dmwRugZFPU';
	    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	    //4-1
	
        //データベース内にテーブルを作成
	    $sql = "CREATE TABLE IF NOT EXISTS users"
	    ." ("
	    . "id INT AUTO_INCREMENT PRIMARY KEY,"
	    . "username char(32),"
	    . "name char(32),"
	    . "password TEXT"
	    .");";
	    $stmt = $pdo->query($sql);
        //4-2
    
	    //データベース内のテーブル一覧を表示
	    $sql ='SHOW TABLES';
	    $result = $pdo -> query($sql);
	    foreach ($result as $row){
	    	echo $row[0];
		    echo '<br>';
	    }
	    echo "<hr>";
        //4-3
    
        //作成したテーブルの構成要素を表示
        $sql ='SHOW CREATE TABLE users';
	    $result = $pdo -> query($sql);
	    foreach ($result as $row){
	    	echo $row[1];
	    }
	    echo "<hr>";
        //4-4 
    
        //データの挿入
        $sql = $pdo -> prepare("INSERT INTO users (username, name, password) VALUES (:username, :name, :password)");
	    $sql -> bindParam(':username', $name, PDO::PARAM_STR);
	    $sql -> bindParam(':name', $username, PDO::PARAM_STR);
	    $sql -> bindParam(':password', $password, PDO::PARAM_STR);
	    $username = $_GET["username"];
	    $name = $_GET["name"];
	    $password = $_GET["password"]; 
	    $sql -> execute();
        //4-5
    
        //入力したデータレコードを抽出
        // usernameが$_GET["username"];のデータだけを抽出したい、とする
        $username=$_GET["username"];
        
        $sql = 'SELECT * FROM users WHERE username=:username ';
        $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
        $stmt->bindParam(':username', $username, PDO::PARAM_STR); // ←その差し替えるパラメータの値を指定してから、
        $stmt->execute();                             // ←SQLを実行する。
        $results = $stmt->fetchAll(); 
	    foreach ($results as $row){
	    	//$rowの中にはテーブルのカラム名が入る
		    echo $row['name']."さん登録おめでとうございます"."<br>";
		    //個人ページへ誘導
		    $data=$row["id"];
		    $data=rawurlencode($data);
		    $url="0-4.php";
		    echo "<a href={$url}?data={$data}>"."{$row['name']}さんのページへ"."</a>";
	    echo "<hr>";
	    }
        
        
        
    }else{
        echo "登録失敗しました";
    }
    
    
    ?>

    
    
    
    
</body>
</html>