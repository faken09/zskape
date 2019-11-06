<!DOCTYPE html>
<html>
 <head>
  <link href="stylesheets/stylesheet.css" rel="stylesheet" type="text/css" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link type="image/x-icon" rel="shortcut icon" href="images/icon/favicon_0001.ico">
  <title>zskape - gathering of news</title>
 </head>
 <body>
  <div id="global">
   <div id="top_stuff">
    <div id="bg_top">
	</div>
	<div id="header">
	 <div id="personal">
	 </div>
	</div>
	<div id="page_top">
	 <div id="nav">
	  <ul>
	   <li><a href="#">Check out our <b>forums</b></a></li>
	   <li><a href="#">read</a></li>
	   <li><a href="#">rate</a></li>
	   <li><a href="#">discuss</a></li>
	   <li><a href="#"><b>more...</b></a></li>
	   <li><p>the web for you, by <b>you</b></p></li>
	  </ul>
	 </div>
	 <div id="login_menu">
	  <form action="login_attempt.php" method='POST' id="logon" >
	   <table class="menu">
	    <tr>
		 <td>Username:</td>
		 <td>Password:</td>
		</tr><tr>
		 <td><input type="text" name="myusername" id="username" class="login" AUTOCOMPLETE="OFF"/> </td>
		 <td><input type="password" name="mypassword" id="password" class="login" AUTOCOMPLETE="OFF"/> </td>
		</tr><tr>
		 <td><input type="checkbox"> Remember me?</td>
		 <td style="padding-top:5px;"><a href="#">Forgot it?</a></td>
		</tr><tr>
		 <td colspan="2"><input type="submit" class="btn_login" name="login" value="Log in"/></td>
		</tr>
	   </table>
	  </form>
	 </div>
	 <div id="search_bar">
	  <div id="logo">
	  </div>
	  <div id="search_menu_bar">
	   <div class="search_menu">
		<form action="#" method='POST' id="search" >
		 <table class="search_menu">
		  <tr>
		   <td><input type="text" name="bar" size="30"  maxlength="255" placeholder="Search for stuff"
				onclick="if(this.value=='Fullname') { this.value='' }"  class="menubar" AUTOCOMPLETE="OFF"> </td>
	
		   <td><input type="submit" class="btn" style="width:60px;" name="search" value="Search"></td>
		  </tr>
		 </table>
		</form>
	   </div>
	  </div>
	 </div>		
	</div>
   </div>
   <div id="page_container">
    <div id="content_container">
	 <div id="content">
	  <div class="new_story">
	   <div class="rank">
	    <span class="first">#1</span>
	   </div>
	   <div class="vote">
	    <div class="like">
		 <ul>
		  <li>
		   <a href="#"><img src="images/plus.gif" alt="" style="width:10px;"/>Like</a>
		  </li>
		 </ul>
		</div>
		<div class="score">
		 <span class="unvoted">1232</span>
		</div>
		<div class="dont_like">
		 <ul>
		  <li><a href="#"><img src="images/minus.gif" alt="" style="width:10px;"/>Dislike</a></li>
		 </ul>
		</div>
	   </div>
	   <div class="user_display">
	    <ul>
		 <li><a href="#"><img src="images/seb.jpg" alt=""/></a></li>
		</ul>
	   </div>
	   <div class="entry">
	    <div class="author">
         <a class="user" href="#">Faken09</a> 
		</div>
		<div class="title">
		 <a href="#">Esther Mengel lugter af lort</a>
		</div>
		<div class="comments">
		 <ul>
		  <li>7 hours ago in <a class="addcat" href="#">[fun]</a></li>
		  <li><a href="#"> comments(503)</a></li>
		 </ul>
		</div>
	   </div>
	  </div>	
	  <div class="new_story">
	   <div class="rank">
	    <span class="number">#2</span>
	   </div>
	   <div class="vote">
	    <div class="like">
		 <ul>
		  <li><a href="#"><img src="images/plus.gif" alt="" style="width:10px;"/>Like</a></li>
		 </ul>
	    </div>
		<div class="score">
		 <span class="unvoted">1132</span>
		</div>
		<div class="dont_like">
		 <ul>
		  <li><a href="#"><img src="images/minus.gif" alt="" style="width:10px;"/>Dislike</a></li>
		 </ul>
		</div>
	   </div>
	   <div class="user_display">
	    <ul>
		 <li><a href="#"><img src="images/nico.jpg" alt="" /></a></li>
		</ul>
	   </div>
	   <div class="entry">
		<div class="author">
		 <a class="user" href="#">Nicolaj</a>
		</div>
		<div class="title">
		 <a href="#">My roommate is lonly! and listen to akon atm</a>
		</div>
		<div class="comments">
		 <ul>
		  <li>9 hours ago in <a class="addcat" href="#">[fun]</a></li>
		  <li><a href="#"> comments(203)</a></li>
		 </ul>
		</div>
	   </div>
	  </div>
	 </div>
	 <div id="sidebar">
	  <div id="right_menu">
	   <div id="signup_menu">
		<ul>
		 <li>New to zSkape? Create a free profile</li>
		</ul>
		<form action="#" name="register" method="POST" class="signon">
		 <table class="signup">
		  <tr>
		   <td><p>Username:</p></td>
		   <td><input type="text" name="username" 
				placeholder="Username" size="30" AUTOCOMPLETE="OFF" class="create" 
				onclick="if(this.value=='Fullname') { this.value='' }"></td>
		  </tr><tr>
		   <td><p>Email:</p></td>
		   <td><input type="text" name="email" 
				placeholder="Email" size="30" AUTOCOMPLETE="OFF" class="create" 
				onclick="if(this.value=='Email') { this.value='' }">
		   </td>
		  </tr><tr>
		   <td><p>Password:</p></td>
		   <td><input type="password" name="password" AUTOCOMPLETE="OFF" placeholder="Password" 
				size="30" class="create" id="pwd" onblur="if(this.type=='') {this.value='Password' }" 
				onclick="if(this.value=='Password')  { this.value=''}  " >
		   </td>	
		  </tr>
		 </table>
		</form>
	   </div>
	   <div id="buttons">
		<form>
		 <table class="button">
		  <tr>
		   <td><input type="submit" class="btn_create" name="Create" value="Create"></td>	
		  </tr>
		 </table>
		</form>
	  </div>
	 </div>
	 <div id="post">
	  <div class="date_break">New posts</div>
	   <ul>
	    <li><a href="#"> Tyrefægning gone right? (23)</a></li>
		<li><a href="#"> ny mobil: Hvilken (12)</a></li>
		<li><a href="#"> Hard Reset/deus ex/space (140)</a></li>
		<li><a href="#"> Min computer fryser og vil ikk... (11)</a></li>
		<li><a href="#"> S: højydende og støj PC (13)</a></li>
		<li><a href="#"> Hjælp til at finde sang? (6)</a></li>
		</ul>
	   <div class="date_break">Most daily discuess
	   </div>
	   <div class="date_break">Videos
	   </div>
	   <div class="date_break">Pictures
	   </div>
	   <div class="date_break">LOL
	   </div>
	  </div>
	 </div>
	</div>
   </div>
   <div id="bottom_stuff">
	<div id="footer">
	 <ul>
	  <li>&copy;2011 zskape v.1.02</li>
	  <li><a href="#">About</a></li>
	  <li><a href="#">Terms</a></li>
	  <li><a href="#">Privacy</a></li>
	  <li><a href="#">Advertisers</a></li>
	  <li><a href="#">Resources</a></li>
	  <li><a href="#">Media</a></li>
	  <li><a href="#">Status</a></li>
	 </ul>
	</div>
   </div>
  </div>		
 </body>
</html>