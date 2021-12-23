<?php
// POSTデータ確認
//var_dump($_POST);
//exit();

if (
  !isset($_POST['todotwitter']) || $_POST['todotwitter']=='' ||
  !isset($_POST['deadline']) || $_POST['deadline']==''
) {
  exit('ParamError');
}

$todo = $_POST['todotwitter'];
$deadline = $_POST['deadline'];

// 各種項目設定
$dbn ='mysql:dbname=gsacy_d01_08;charset=utf8mb4;port=3306;host=localhost';
$user = 'root';
$pwd = '';

// DB接続
try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}

// 「dbError:...」が表示されたらdb接続でエラーが発生していることがわかる．

// SQL作成&実行
$sql = 'INSERT INTO twitter (idtwitter, todotwitter, deadline, createdtwitter_at, updatedtwitter_at) VALUES (NULL, :todotwitter, :deadline, now(), now())';

$stmt = $pdo->prepare($sql);

// バインド変数を設定
$stmt->bindValue(':todotwitter', $todotwitter, PDO::PARAM_STR);
$stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);

// SQL実行（実行に失敗すると `sql error ...` が出力される）
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}