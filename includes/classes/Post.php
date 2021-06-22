<?php 

class Post{

    private $user_obj;
    private $con;


    public function __construct($con,$user){

    	$this->con=$con;
    	
    	$this->user_obj=new User($con,$user);

     }


    // posting from newsfeed

    public function submitPost($body,$user_to){
      
      $date_added= date("Y-m-d H:i:s");
      $added_by=$this->user_obj->getUsername();
   

      if($user_to==$added_by)
      {

      	$user_to="none";
      }

      // inserting post into database

      $query=mysqli_query($this->con,"INSERT INTO posts VALUES('','$body','$added_by','$user_to','$date_added','no','no','0')");
        
    }	


    public function loadPostsFriends(){

        
    	$str="";

    	$data=mysqli_query($this->con,"SELECT * FROM posts WHERE deleted='no' ORDER BY id DESC");

    	while($row=mysqli_fetch_array($data))
    	{
	          $id=$row['id'];
	          $body=$row['body'];
	          $added_by=$row['added_by'];
	          $date_time=$row['date_added'];

	          if($row['user_to']=="none")
	          {
	          	$user_to="";
	          }
	          else
	          {

	          	$user_to_obj=new User($con,$row['user_to']);
	          	$user_to_name=$user_to_obj->getFirstAndLastName();
	          	$user_to="<a href='" .$row['user_to']. "' >".$user_to_name."</a>";
	          }

	        
             // getting only friends posts


              if($this->user_obj->isFriend($added_by))
	             
	              {

		          $user_details_query=mysqli_query($this->con,"SELECT first_name,last_name,profile_pic FROM users WHERE username='$added_by'");
		          $user_row=mysqli_fetch_array($user_details_query);
		          $first_name=$user_row['first_name'];
		          $last_name=$user_row['last_name'];
		          $profile_pic=$user_row['profile_pic'];

		          ?>

		          <script >
		          	
		          	function toggle<?php echo $id; ?>(){
						var element=document.getElementById("toggleComment<?php echo $id;?>");
						if(element.style.display=="block")
							element.style.display="none";
						else
						element.style.display="block";

		            }
		          </script>

		          <?php

		          $comments_check=mysqli_query($this->con, "SELECT * FROM comments WHERE post_id='$id'");
		          $comments_check_num=mysqli_num_rows($comments_check);

		          // time counting


		          $date_time_now=date("Y-m-d H:i:s");
		          $start_date=new DateTime($date_time); //time of post
		          $end_date=new DateTime($date_time_now); //current time
		          $interval=$start_date->diff($end_date);
		          if($interval->y >=1){
		          	if($interval->y==1)
		          	{
		          		$time_message=$interval->y."year ago";
		          	}
		          	else
		          	{
		          		$time_message=$interval->y. "years ago";

		          	}

		          }
		          else if($interval->m >=1)
		          {
		          	if($interval->d ==0)
		          	{
		          		$days= "ago";
		          	}
		          	else if($interval->d ==1)
		          	{
		          		$days=$interval->d. "day ago";
		          	}
		          	else
		          	{
		          		$days=$interval->d. "days ago";
		          	}

		          	if($interval->m ==1)
		          	{
		          		$time_message=$interval->m. "month". $days;
		          	}
		          	else
		          	{
		          		$time_message=$interval->m. "months". $days;
		          	}

		          }

		          else if($interval->d>=1)
		          {
		          	 if($interval->d ==1)
		          	{
		          		$time_message="yesterday";
		          	}
		          	else
		          	{
		          		$time_message=$interval->d. "days ago";
		          	}

		          }

		         else if($interval->h>=1)
		          {

		            if($interval->h ==1)
		          	{
		          		$time_message=$interval->h ."hour ago";
		          	}
		          	else
		          	{
		          		$time_message=$interval->h. "hours ago";
		          	}

		          }

		          else if($interval->i>=1)
		          {

		            if($interval->i ==1)
		          	{
		          		$time_message=$interval->i ."minute ago";
		          	}
		          	else
		          	{
		          		$time_message=$interval->i. "minutes ago";
		          	} 



		    	}
		    	else{
		    		$time_message="Just now";
		    	}
		    	


			    	$str.="<div class='status_post' onClick='javascript: toggle$id()'>
			    	              <div class='post_profile_pic'>
			    	                 <img src='$profile_pic' width='50'>
			    	                 </div>

			                       <div class='posted_by' style='color:#ACACAC'>
			                       <a href='$added_by'>$first_name $last_name</a> $user_to
			                            $time_message
			                        </div>
			                        <div id='post_body'>
			                            $body
			                            <br>
			                            <br>
			                            <br>

			                         </div>   

			                         <div class='newsfeedPostOptions'>

                                        comments($comments_check_num)
                                        <iframe src='like.php?post_id=$id' scrolling='no'><iframe>

			                         </div>     


			    	           </div>
			    	           <div class='post_comment' id='toggleComment$id' style='display:none;' >
			    	           <iframe src='comment_frame.php?post_id=$id' id='comment_iframe'></iframe>

			    	           </div>
			    	           <hr>"; 
		    	  } 

    	                 

    	
    } //end of while loop
    echo $str;


} //end of loadPostsFriends()


} //end of Post class


?>
