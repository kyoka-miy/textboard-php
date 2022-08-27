<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-5</title>
</head>
<body>
    <?php
            $name = $_POST["name"];
            $comment=$_POST["comment"];
            $filename="m3-5.txt";
            $date=date("Y年m月d日　H:i:s");
            $num=count(file($filename))+1;
            //新規パスワード
            $pass=$_POST["pass"];
            $data=$num."<>".$name."<>".$comment."<>".$date."<>".$pass."<>";
            $deleteNum=$_POST["deleteNum"];
            //削除対象番号
            $editNum=$_POST["editNum"];
            //削除機能のパスワード
            $deletePass=$_POST["deletePass"];
            //編集機能のパスワード
            $editPass=$_POST["editPass"];
            
            
                if(!empty($editNum)){
                    $lines=file($filename, FILE_IGNORE_NEW_LINES);
                    $fp=fopen($filename,"r");
                
                    foreach($lines as $line){
                        $post=explode("<>",$line);
                        if($post[0]==$editNum && $post[4]==$editPass){
                        //イコールの場合はその投稿の名前とコメントを取得
                            $editName=$post[1];
                            $editCom=$post[2];
                            $newNum=$post[0];
                        
                    //echo $newNum;//$newNumの確認
                        }
                    }
                } 
            
            $secretNum=$_POST["secretNum"];
            /*echo $secretNum;//$secretNumの確認*/
        
            //削除機能
            if(!empty($deleteNum) && !empty($deletePass)){
                //ファイル関数でファイルの中身を配列変数に代入 
                $lines=file($filename, FILE_IGNORE_NEW_LINES);
                //ファイルを開く
                //wでファイルの中身をリセット&追加書き込み出来るようにする
                $fp=fopen($filename,"w");
                
                    foreach($lines as $line){
                        $post=explode("<>",$line);
                    //投稿番号と削除番号を比較
                    //投稿番号と削除番号が一致しなかったら入力
                    
                    //パスワードが一致したときだけ削除機能が動くようにしたいが、パスワードが一致した行だけ残ってあとは全て消える
    
                        if($post[0]!=$deleteNum or $post[4]!=$deletePass){
                        
                        fwrite($fp, $line.PHP_EOL);
                        }
                    
                    //ファイルを閉じる 
                    } fclose($fp);
            }  
                        
        
            if(!empty($name) && !empty($comment) && empty($secretNum) && !empty($pass)){
                $fp=fopen($filename,"a");
                fwrite($fp,$data.PHP_EOL);
                fclose($fp);
            
            }elseif(!empty($secretNum)){
                //テキストファイルの中身を取り出し
                $lines=file($filename, FILE_IGNORE_NEW_LINES);
                //ファイルを一度空にして書き込み準備
                $fp=fopen($filename,"w");
                /*var_dump($lines);//$linesの確認*/
                
                //１行ごとに検証
                foreach($lines as $line){
                    //区切り文字で分割して投稿番号を取得
                    $post=explode("<>",$line);
                    
                    //各行の投稿番号と一致したときのみフォームから送信された値と差し替える
                    if($post[0]==$secretNum){
                       
                       fwrite($fp, $post[0]."<>".$name."<>".$comment."<>".$date.PHP_EOL);
                    }else{
                        fwrite($fp, $line.PHP_EOL);
                    }
                }fclose($fp);
                
            }
                
            
             
    ?>
    <form action="" method="post">
        <input type="text" name="name" placeholder="Name" value="<?php if(isset($editName)){echo $editName; }?>"><br>
        <input type="text" name="comment" placeholder="Comment" value="<?php if(isset($editCom)){echo $editCom; }?>"><br>
        <input type="password" name="pass" placeholder="Password">
        <input type="hidden" name="secretNum"  value="<?php  if(!empty($newNum)){echo $newNum; }?>">
        
        <input type="submit" name="submit" value='Post'><br>
        <br>
        <input type="text" name="deleteNum" placeholder="Delete Number"><br>
        <input type="password" name="deletePass" placeholder="Password">
        <input type="submit" name="delete" value='Delete'><br><br>
        <input type="text" name="editNum" placeholder="Edit Number"><br>
        <input type="password" name="editPass" placeholder="Password">
        <input type="submit" name="edit" value='Edit'><br>
        
    </form>
     
     <?php   
         //表示機能
            if(file_exists($filename)){
                $lines=file($filename, FILE_IGNORE_NEW_LINES);
                
                foreach($lines as $line){
                    $post=explode("<>",$line);
                    
                        echo $post[0]." ".$post[1]." ".$post[2]." ".$post[3];
                    
                    echo "<br>";
                }
                
            }  
            
     ?>  
    
</body>