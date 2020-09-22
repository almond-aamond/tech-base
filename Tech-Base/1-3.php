<!DOCTYPE html>

<html lang="ja">

<head>

<meta charset="UTF-8">
<title>個別記事</title>

<!-- CSS -->
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href="style.css" rel="stylesheet">

</head>

<body>
<?php
    //ＳＱＬ初期設定
    
    // DB接続設定
	$dsn = 'mysql:dbname=tb220110db;host=localhost';
	$user = 'tb-220110';
	$password = 'dmwRugZFPU';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	
?>
  <header class="page-header">
    <h1><a href="home.html"><img class="logo" src="logo.jpg" alt="ロゴ"></a></h1>
  </header>


<?php
        
        
        if($_GET["data"]){
            echo "ログイン中"."<br>";
        }else{
            echo "<ul>"."<li>"."<a href=0-0.php>"."新規登録"."</a>"."</li>";
            echo "<li>"."<a href=0-2.php>"."ログインページ"."</a>"."</li>"."</ul>";
        }
?>
<?php
	if($_GET["data"]){    
        $data=$_GET["data"];
        $data=rawurldecode($data);
		$data2=$data;
		//ログイン中のデータ
	    $url="0-4.php";
	    echo "<a href={$url}?data={$data2}>"."マイページへ"."</a>"."<br>";
	}
?>


<?php
	if($_GET["data"]){
		$data=$_GET["data"];
        $data=rawurldecode($data);
		$data2=$data;
		//ログイン中のデータ
	}
	$url="1-2.php";
	echo "<a href={$url}?data={$data2}>"."みんなの記事を見る！！"."</a>";
?>

  <div class="contents">
    <article>
      <ul>
        <?php
        //getリクエストを受け取る
        $data=$_GET["data"];
        $data=rawurldecode($data);
        
        $writer=$_GET["writer"];
        $writer=rawurldecode($writer);
        if($_GET["writer"]){
            echo $writer."さんのページ"."<br>";
        }
        

	    $name = $writer ; // nameがこの値のデータだけを抽出したい、とする

        $sql = 'SELECT * FROM article WHERE name=:name ';
        $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
        $stmt->bindParam(':name', $name, PDO::PARAM_STR); // ←その差し替えるパラメータの値を指定してから、
        $stmt->execute();                             // ←SQLを実行する。
        $results = $stmt->fetchAll(); 
	    foreach ($results as $row){
		    //$rowの中にはテーブルのカラム名が入る
		    echo "タイトル:".$row['title'].'<br>';
		    //echo "執筆者:".$row['name'].'<br>';
		    echo "投稿時間:".$row['time'].'<br>';
		    echo $row['content'].'<br>';
	    echo "<hr>";
	    }

        
        
        ?>
        
      </ul>

    </article>

    <aside>
      <h3>執筆者一覧</h3>
      <ul>
          <?php
          //入力したデータレコードを抽出
            $sql = 'SELECT * FROM users';
	        $stmt = $pdo->query($sql);
	        $results = $stmt->fetchAll();
	        foreach ($results as $row){
		        //$rowの中にはテーブルのカラム名が入る
		        $writer=$row["name"];
		        $writer=rawurlencode($writer);
		        //記事作成者
		        if($_GET["data"]){
		            $data=$_GET["data"];
                    $data=rawurldecode($data);
		            $data2=$data;
		            //ログイン中のデータ
		        }
		        $url="1-3.php";
		        echo "<li>"."<a href={$url}?data={$data2}&writer={$writer}>".$row['name']."</a>".'</li>';
		        echo "<br>";
	        }
          ?>
      </ul>
    </aside>

  </div>




  <footer>
    <p><small>&copy; 2020 Tech Base Intern3</small></p>
  </footer>


</body>
</html>