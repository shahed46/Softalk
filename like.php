 <!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="assets/css/header.css">
</head>
<body>

	<style type="text/css">
		body{
			background-color: #fff;
		}	
		form{
			position: absolute;
			top: 0;
		}

	</style>
    <?php

		require 'config/config.php';
		include("includes/classes/User.php");
        include("includes/classes/Post.php");

		if(isset($_SESSION['username'])){
			$userloggedin=$_SESSION['username'];
			$user_info=mysqli_query($con,"SELECT * FROM users WHERE username='$userloggedin'");
			$user=mysqli_fetch_array($user_info);
		}
			else
			{
				header("Location:register.php");
			}


			 if(isset($_GET['post_id']))
				     {
				     	$post_id=$_GET['post_id'];
				     }
		$get_likes=mysqli_query($con, "SELECT likes, added_by FROM posts WHERE id='$post_id'");
		$row=mysqli_fetch_array($get_likes);
		$total_likes=$row['likes'];
		$user_likes=$row['added_by'];


		$user_details_query=mysqli_query($con,"SELECT * FROM users WHERE username='$user_likes'");
		$row=mysqli_fetch_array($user_details_query);


	 // like buttton
		if(isset($_POST['like_button']))
		{
			$total_likes++;
			$query=mysqli_query($con, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
			$insert_user=mysqli_query($con, "INSERT INTO likes VALUES('', '$userloggedin','$post_id')");
		}

		//unlike button
		if(isset($_POST['unlike_button']))
		{
			$total_likes--;
			$query=mysqli_query($con, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
			$insert_user=mysqli_query($con, "DELETE FROM likes WHERE username='$userloggedin' AND post_id='$post_id'");
		}

		//check for previous likes

		$check_query=mysqli_query($con,"SELECT * FROM likes WHERE username='$userloggedin' AND post_id='$post_id'");
		$num_rows=mysqli_num_rows($check_query);

		if($num_rows>0)
		{
			echo '<form action="like.php?post_id=' .$post_id .'" method="POST">

                 <input type="submit" class="comment_like" name="unlike_button" value="Unlike">
                 <div class="like_value">
                 '.$total_likes .' Likes

                 </div>
                 </form>
			';
		}
		else
		{
			echo '<form action="like.php?post_id=' .$post_id .'" method="POST">

                 <input type="submit" class="comment_like" name="like_button" value="Like">
                 <div class="like_value">
                 '.$total_likes .' Likes

                 </div>
                 </form>
			';
		}

	?>
</body>
</html>