<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ログイン成功or失敗</title>
</head>
<body>
    

    
    
    <?php 
    if($_GET["username"]&$_GET["password"]){
    	// DB接続設定
	    $dsn = 'mysql:dbname=tb220110db;host=localhost';
	    $user = 'tb-220110';
	    $password = 'dmwRugZFPU';
	    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	    //4-1
	
        
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
	    	if($row["password"]==$_GET["password"]){
	    	    echo $row['name']."さんログイン成功です"."<br>";
	    	    
	    	    //個人ページへ誘導
		        $data=$row["id"];
		        $data=rawurlencode($data);
		        $url="0-4.php";
		        echo "<a href={$url}?data={$data}>"."{$row['name']}さんのページへ"."</a>";
	    	}else{
	    	    echo "パスワードが間違っています";
	    	}
		    
	    echo "<hr>";
	    }
        
        
        
    }else{
        echo "入力ミスがあります";
    }
    
    
    ?>

    
    
    
    
</body>
</html>