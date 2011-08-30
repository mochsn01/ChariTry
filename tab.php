<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
<!--[if IE]>
<link rel="stylesheet" href="ie.css" type="text/css" />
<![endif]-->
<?php  error_reporting(0);
require 'config.php';

require 'facebook.php';

$facebook = new Facebook(array('appId'  => $app_id,
                               'secret' => $app_secret,
                               'cookie' => true,));

$signed_request = $facebook->getSignedRequest();

$page_id = $signed_request["page"]["id"];
$page_admin = $signed_request["page"]["admin"];
$like_status = $signed_request["page"]["liked"];
$country = $signed_request["user"]["country"];
$locale = $signed_request["user"]["locale"];
$user = $signed_request["user_id"];
 
?>
  
    <style>
#pop td{ cursor: pointer;
    
    height: 60px;
    
     float: left;
    height: 60px;
    margin: 1px;
    padding-bottom: 10px;

    width: 73px;
	}
#pop td a:hover{
	background-color: #6D84B4;
    border: 2px solid #3B5998;
    color: #FFFFFF;
    display: block;
    height: 56px;
    padding-bottom: 10px;
    width: 67px;
 }
 
 .selected{
	background-color: #6D84B4 !important;
    border: 2px solid #3B5998;
    color: #FFFFFF;
     width: 69px !important;
    height: 56px;
    padding-bottom: 10px;
 }
 
   	  h3{color:#fff;}
 </style><script>
	 var user = "<?=$user?>";
	 var formid=0;
     var friendsArray = new Array();
				 
				 
				var index=0;
 function selectfriendfirst(numFriends) {
			
			if(numFriends>1){
	 		return new LightFace({
	 			title: 'Too many friends selected!',
	 			content: "Sorry, you can only Challenge 1 friend at a time! ",
				draggable: true,
				width: 297,
				height: 38,
				buttons: [
				   	{
						title: 'Ok',
						event: function() { this.close(); }
					}
				]
	 		}).open();
			}
			else
			{
			return new LightFace({
	 			title: 'No friend selected!',
	 			content: 'Select at least one friend to post on their wall!',
				draggable: true,
				width: 297,
				height: 38,
				buttons: [
				   	{
						title: 'Ok',
						event: function() { this.close(); }
					}
				]
	 		}).open();	
			}
			
	 	}
 				function dump(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;
	
	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";
	
	if(typeof(arr) == 'object') { //Array/Hashes/Objects 
		for(var item in arr) {
			var value = arr[item];
			
			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Stings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;}
 
         		function Popup(popuptoclose,formid){
					popuptoclose.close();
					document.getElementById(formid).innerHTML = '';
			
			formid = formid+1;
			var closepop = formid;
		 
	var formstring ="<div align=center id='signupform"+formid+"'><form id=signup name=signup><div id=validation></div>";

     formstring = formstring + "<table cellpadding=3 cellspacing=2 width=90% border=0  id=form>";
	 
     formstring = formstring + "<tr><td colspan=3>Message*<br /><textarea id='message' name=message cols=30 rows=3 ></textarea></td> </tr>";
	 
	 formstring = formstring + "<tr><td>I&nbsp;Challenge you*<br /> <select id='game' name=game ><option value=swim>swim</option>";
		 
	 formstring = formstring + "<option value=bike>bike</option><option value=run>run</option></select></td><td>";
	 
	 formstring = formstring + "Miles*<br /> <select id=nom  name=nom ><option value=10>10</option><option value=20>20</option>";
	
	 
	 formstring = formstring + "<option value=30>30</option><option value=40>40</option><option value=50>50</option></select></td><td>in Days*<br />";
	 
	 formstring = formstring + " <select id=nod  name=nod ><option value=1>1</option><option value=10>10</option><option value=20>20</option>";
	 
	 formstring = formstring + "<option value=30>30</option><option value=45>45</option><option value=60>60</option></select></td></tr>";
	 
	 formstring = formstring + "<tr><td colspan=3>If&nbsp;So&nbsp;I&nbsp;will&nbsp;donate*<br /> <select id=charity  name=charity >";
	  
	 formstring = formstring + "<option value=charity1>charity 1</option><option value=charity>charity 2</option> ";
	 
	 formstring = formstring + "<option value=charity3>charity 3</option><option value=charity4>charity 4</option>";
	 
	 formstring = formstring + " <option value=charity5>charity 5</option><option value=charity6>charity 6</option>";
		
     formstring = formstring + "</td></tr></form> </div>";
	 		return lightbox = new LightFace({
	 			title: 'Build Your Challenge! ',
	 			content:formstring,
				draggable: true,
				buttons: [
					{ 
						title: 'Submit', 
						event: function() { do_ajax(formid,lightbox); },
						color: 'blue'
					},
					{
						title: 'Close',
						event: function() { this.close(); friendsArray = []; index=0; document.getElementById("signupform"+formid).innerHTML='';  }
					}
				]
	 		}).open();
			
		
	 	}
	
		var friendcontainer; 
           
		   var thnkyoupup;
		   var thnkyoupup1;
           var lightbox;
  
  
				
					
			function fbPost(listId){
				
				
				
				
				if(document.getElementById(listId).className!='selected')
				{
					document.getElementById(listId).className = 'selected';
					 
				 friendsArray[index]=listId; index++;
				}
				else
				{
				
					document.getElementById(listId).className = '';
						
						
							
						for(var i in friendsArray)
						{
							
							if(friendsArray[i]==listId)
							{
								
								friendsArray.splice(i,1); 
								
								index = index-1;
							}
							
						
						
						}
				}
				

			}	
		var friendspopup;
		var posto;
		function showfriends(selectlist1,dialog12) {
			 
	 		return friendspopup = new LightFace({
	 			title: 'Select a friend to Challenge him!',
	 			content: selectlist1,
				draggable: true,
				width: 483,
				height: 405,
				buttons: [
				   {  
						title: 'Challege Now!', 
						event: function() {
							
					 var numFriends = friendsArray.length; //alert(numFriends);
					
						if(numFriends > 1 || numFriends < 1){
							
						  selectfriendfirst(numFriends); //alert(' Friends '+dump(friendsArray));
						}
						else if(numFriends==1)
						{
						   
						     
							Popup(friendspopup,dialog12);
								
							//
							//index=0;
						}
						
						
						 
						
						},
						color: 'blue'
					},
					{
						title: 'Close',
						event: function() { this.close(); friendsArray = new Array(); index=0; document.getElementById(dialog12).innerHTML='';  }
					}
				]
	 		}).open();
	 	
		}
		
		
		   function share() {
			  
			  var dialog=Math.random()*20;
			      dialog = 'test'+dialog;
			   var selectlist = "<div id='"+dialog+"' style=' width:477px; margin-left:-34px; overflow: hidden;'><table  id='pop' style='margin-left:26px;width: 454px;'><tr>";

			
			    FB.api({
				method: 'fql.query',
				query: "SELECT name,pic_square,uid,first_name FROM user WHERE uid IN ( SELECT uid2 FROM friend WHERE uid1=me()) order by name asc"
					  }, function(result) {
							        
										var arraySize = result.length;
										var ij=0;
										var count =1;
										for (ij=0; ij<arraySize; ij++ )
											{
										var str = result[ij]['first_name'];
												
										 var found = str.search(' ');
										 if(found!=(-1))
										 {
										 var group = str.split(' ');
										 var firstname= group[0];
										 }
										 else
										  var firstname= str;
										 
	selectlist += " <td id='"+result[ij]['uid']+"' align=center ><a onClick='fbPost("+result[ij]['uid']+");'>";
	
	selectlist += firstname+"<br><img title='"+result[ij]['name']+"' src='"+result[ij]['pic_square']+"' width='50' height='50'></img></a></td>";	
						
						if(count%6==0)
						{
							selectlist += "</tr><tr>"; 
						}
						count++;
						}      
										 selectlist += "</table></div>"; 
										 
										 showfriends(selectlist,dialog);
											
                                 
									  }	);
				    
				   
					
				}
	</script>
</head> 

<body style="overflow:hidden; font-size:12px; font-family:'Lucida Grande','Lucida Sans Unicode', sans-serif"> 
<div id="fb-root"></div>
   
   <?php if($like_status) {?>
   <div align="center" style="background:url(<?=$cburl;?>images/background.png); background-repeat:no-repeat; width:520px; height:800px;">
<img style="float:right; margin-right:20px; position:absolute; cursor:pointer; top:220px;" src="<?=$cburl;?>images/challenge.png" onClick="askperm();" />
</div>
<br clear="all"/>
    
  <?php } else { ?>
<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>
			<img src="<?=$cburl;?>images/background.jpg" width="520"  height="784"  />
		</td>
	</tr>
</table>
<? }?>
 
       
 <script type="text/javascript">
	 
            window.fbAsyncInit = function() {
             FB.init({appId: <?=$app_id?>, status: true,cookie: true, xfbml: true});
 
            FB.Canvas.setAutoResize();
				};
            (function() {
                var e = document.createElement('script');
                e.type = 'text/javascript';
                e.src = document.location.protocol +
                    '//connect.facebook.net/en_US/all.js';
                e.async = true;
                document.getElementById('fb-root').appendChild(e);
            }());
				
		function askperm(){
		 FB.getLoginStatus(function(response) {
                    if (response.session) {
					  share();
                    }
					else
					{
						//
						//alert('not logged in');
						FB.login(function(response) {
			
			                       if (response.session)
								      {

										 FB.api({
				method: 'fql.query',
				query: "SELECT uid FROM user WHERE uid=me();"
					  }, function(result) {
						user = result[0]['user'];	        
					  });
					  
					  share();			             	
			                           }
								  
				                                    }, {perms:'publish_stream'});	
				
				
					}
                });	
		}
		
		var success1;
		function success(checkpost) {
			if(checkpost==1){
	 		return success1 = new LightFace({
	 			title: 'Success!',
	 			content: 'You have successfully challenged your friend!',
				draggable: true,
				width: 280,
				height: 80,
				buttons: [
				   	{
						title: 'Close',
						event: function() { this.close(); }
					}
				]
	 		}).open();
			}
			else
			{
			return success1 = new LightFace({
	 			title: 'Failed to Challenged this friend!',
	 			content: 'This friend does not allow any thing to be posted on his wall!',
				draggable: true,
				width: 280,
				height: 80,
				buttons: [
				   	{
						title: 'Close',
						event: function() { this.close(); }
					}
				]
	 		}).open();	
		    }
	 	}
		

		 function do_ajax(formnum,popupid)
		        { 
				
			     
				
				var message =document.getElementById("message").value;
				var game = document.getElementById('game').value;
			
				var nom = document.getElementById('nom').value;
				var nod = document.getElementById('nod').value;
				var charity = document.getElementById('charity').value;
								
				if(message==null || message=="")
				{
					document.getElementById('validation').innerHTML ="<span style='color:#f00'>   Please Enter your message.</span>";
					return false;
				}
				 
				if(game==null || game=="")
				{
					document.getElementById('validation').innerHTML ="<span style='color:#f00'>   Please select challenge type!</span>";
					return false;
				}
				
				
					if(nom==null || nom=="")
				{
					document.getElementById('validation').innerHTML ="<span style='color:#f00'>   Please Select number of miles to challange!</span>";
					return false;
				}
				 
				if(nod==null || nod=="")
				{
					document.getElementById('validation').innerHTML ="<span style='color:#f00'>   Please select number of days!</span>";
					return false;
				}
				
					if(charity==null || charity=="")
				{
					document.getElementById('validation').innerHTML ="<span style='color:#f00'>   Please select to which charity you will donate!</span>";
					return false;
				}
				
				var text =  "I challenge You to "+game+" "+nom+" miles in "+nod+" days!";
				
				
			   var params = {};
				var actions ={};
				actions['text'] = 'Accept the Challenge!';
     			actions['href'] = "<?=$canvas?>?uid="+user;
				params['message'] = '';
				params['name'] = text;
				params['link'] = "<?=$canvas?>?uid="+user;
				params['picture'] = '<?=$cburl?>images/post.jpg';
				params['caption'] = message;
				params['action_links'] = actions;
				  var key =0;
			 
				FB.api('/'+friendsArray[0]+'/feed', 'post', params, function(response) {
				  if (!response || response.error) {
					success(0);	//window.location.href ="http://jmp2.am/pw";
					popupid.close();
					var formdiv = 'signupform'+formnum;index=0;
				document.getElementById(formdiv).innerHTML ='';
				 
				  } else {
					success(1);//window.location.href ="http://jmp2.am/pw";//alert('Published to stream - you might want to delete it now!');
					friendsArray = new Array();index=0;
					popupid.close();
					var formdiv = 'signupform'+formnum;
				document.getElementById(formdiv).innerHTML ='';
				 
				  }
				});
			
			 }  
			
	
			</script>
 <style>
		@import "Assets/LightFace.css";
	</style>
	<link rel="stylesheet" href="Assets/lightface.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/mootools/1.3.0/mootools.js"></script>
	<script src="Source/LightFace.js"></script>
	<script src="Source/LightFace.js"></script>
	<script src="Source/LightFace.IFrame.js"></script>
	<script src="Source/LightFace.Image.js"></script>
	<script src="Source/LightFace.Request.js"></script>
    
    <script src="Source/LightFace.Static.js"></script>
    <script type="text/javascript">
</body>
</html>