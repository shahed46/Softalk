<?php 
include ("includes/header.php");
include("includes/classes/User.php");
include("includes/classes/Post.php");


// posting from newsfeed page

if(isset($_POST['post'])){

	$post=new Post($con,$userloggedin);
	$post->submitPost($_POST['post_text'],'none');

}
 

 ?>
 <style type="text/css">
 	
 	.wrapper{
 		margin-left: 0px;
        padding-left: 0px;
 	}
 </style>

<div class="user_details column">
	<a href="<?php echo $user['username']; ?>"><img src="<?php echo $user['profile_pic']; ?>"></a>


<a href="<?php echo $user['username']; ?>">
	<?php echo $user['first_name']." ".$user['last_name']; ?>
	</a>
</div>

<!-- newsfeed column -->


<div class="main_column column">
	
	<form class="post_form" action="index.php" method="POST">
		<textarea name="post_text" id="post_text" placeholder="Whats on your mind <?php echo $user['first_name'] ?>?"></textarea>
		<input type="submit" name="post" id="post_button" value="Post">
		<hr>
		
	</form>
	
	
	 <?php 
	 $posts = new Post($con, $userloggedin);
     $posts->loadPostsFriends();
      ?>
	
	
</div>




</div>



</body>
</html>