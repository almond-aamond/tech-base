<!DOCTYPE html>

<html lang="ja">

<head>

<meta charset="UTF-8">
<title>メインページ</title>

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
        //getリクエストを受け取る
        $data=$_GET["data"];
        $data=rawurldecode($data);
        
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


  <div class="contents">
    <article>
      <ul>
        <?php
        //入力したデータレコードを抽出
        $sql = 'SELECT * FROM article';
	    $stmt = $pdo->query($sql);
	    $results = $stmt->fetchAll();
	    foreach ($results as $row){
		    //$rowの中にはテーブルのカラム名が入る
		    //URLをエンコード
		    $data=$row["id"];
		    $data=rawurlencode($data);
		    $url="1-3.php";
		    echo $row["id"]."<br>";
		    echo "<li>"."<h2>"."タイトル："."<a href={$url}?data={$data}>".$row['title']."</a>"."</h2>";
		    echo "<p>"."投稿日時：".$row['time']."</p>";
		    echo "<p>"."執筆者：".$row['name']."</p>";
		    echo "<p>".$row['content']."</p>"."</li>";
		    echo "<br>";
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
    <p><small> &copy; 2020 Tech Base Intern3</small></p>
</footer>


</body>
</html>