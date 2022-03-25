<?php
include("session.php");
include ('conn.php');
?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8"/>
	<title> Spare  Part I Super Admin </title>
<link href="css/bootstrap.min.css" rel="stylesheet" />
      <link href="css/bootstrap.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen" />
<link rel="icon" type="image/x-icon" href="../assets/img/favicon.png" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
	 <link rel="stylesheet" href="css/chatStyle.css" type="text/css" media="screen" />
	 
	 
	<script src="js/jquery-1.5.2.min.js" type="text/javascript"></script>
	<script src="js/hideshow.js" type="text/javascript"></script>
	<script src="js/jquery.tablesorter.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery.equalHeight.js"></script>
	<script type="text/javascript">
	$(document).ready(function() 
    	{ 
      	  $(".tablesorter").tablesorter(); 
   	 } 
	);
	$(document).ready(function() {

	//When page loads...
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content

	//On Click Event
	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});

});
    </script>
    <script type="text/javascript">
    $(function(){
        $('.column').equalHeight();
    });
</script>



<script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
<!-- WAA DHAMAADKA JQueryga CHaTTIng Ka-->

<script type="text/javascript">
// $(document).ready(function() {

// 	// load messages every 1000 milliseconds from server.
// 	load_data = {'fetch':1};
// 	window.setInterval(function(){
// 	 $.post('shout.php', load_data,  function(data) {
// 		$('.message_box').html(data);
// 		var scrolltoh = $('.message_box')[0].scrollHeight;
// 		$('.message_box').scrollTop(scrolltoh);
// 	 });
// 	}, 1000);
	
// 	//method to trigger when user hits enter key
// 	$("#shout_message").keypress(function(evt) {
// 		if(evt.which == 13) {
// 				var iusername = $('#shout_username').val();
// 				var imessage = $('#shout_message').val();
// 				post_data = {'username':iusername, 'message':imessage};
			 	
// 				//send data to "shout.php" using jQuery $.post()
// 				$.post('shout.php', post_data, function(data) {
					
// 					//append data into messagebox with jQuery fade effect!
// 					$(data).hide().appendTo('.message_box').fadeIn();
	
// 					//keep scrolled to bottom of chat!
// 					var scrolltoh = $('.message_box')[0].scrollHeight;
// 					$('.message_box').scrollTop(scrolltoh);
					
// 					//reset value of message box
// 					$('#shout_message').val('');
					
// 				}).fail(function(err) { 
				
// 				//alert HTTP server error
// 				alert(err.statusText); 
// 				});
// 			}
// 	});
	
// 	//toggle hide/show shout box
// 	$(".close_btn").click(function (e) {
// 		//get CSS display state of .toggle_chat element
// 		var toggleState = $('.toggle_chat').css('display');
		
// 		//toggle show/hide chat box
// 		$('.toggle_chat').slideToggle();
		
// 		//use toggleState var to change close/open icon image
// 		if(toggleState == 'block')
// 		{
// 			$(".header div").attr('class', 'open_btn');
// 		}else{
// 			$(".header div").attr('class', 'close_btn');
// 		}
		 
		 
// 	});
// });

</script>

<?php
 //$con = mysqli_connect('localhost','root','root','sps');
?>
<!DOCTYPE HTML>
<html>
<head>
 <meta charset="utf-8">

 <script type="text/javascript">
 google.load("visualization", "1", {packages:["corechart"]});
 google.setOnLoadCallback(drawChart);
 function drawChart() {
 var data = google.visualization.arrayToDataTable([

 ['line ','qnty'],
 <?php 
      $query = "SELECT products.name as name , users1.line as uline, Sum(details.qtyok) as quantity, Sum(products.price*details.qtyok) AS total FROM details  JOIN products ON details.product_id=products.id  JOIN sales ON sales.id=details.sales_id  JOIN users1 ON users1.id=sales.user_id WHERE MONTH(sales.sales_date)= MONTH(CURDATE()) AND details.detail_status=1  GROUP BY users1.line ";

       $exec = mysqli_query($con,$query);
       while($row = mysqli_fetch_array($exec)){

       echo "['".$row['uline']."',".$row['quantity']."],";
       }
       ?> 
 
 ]);

 var options = {
 title: 'Top Line Requested Quantity For <?php echo date("F", strtotime('m')); ?>',
  pieHole: 0.5,
          pieSliceTextStyle: {
            color: 'black',
          },
          legend: 'none'
 };
 var chart = new google.visualization.PieChart(document.getElementById("columnchart12"));
 chart.draw(data,options);
 }
  
    </script>

<!-- First Chart -->

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Product', 'Quantity'],

          <?php
          $result = mysqli_query($conn,"SELECT products.name as name , users1.line as uline, Sum(details.qtyok) as quantity, Sum(products.price*details.qtyok) AS total, sales.sales_date AS date FROM details  JOIN products ON details.product_id=products.id  JOIN sales ON sales.id=details.sales_id  JOIN users1 ON users1.id=sales.user_id WHERE MONTH(sales.sales_date)= MONTH(CURDATE()) AND details.detail_status=1  GROUP BY details.qtyok,products.name asc;");

          if(mysqli_num_rows($result) > 0){

          	while($row = mysqli_fetch_array($result)){

          		echo "['".$row['name']."','".$row['quantity']."'],";
          
          }

      }

?>
        ]);

        var options = {
          chart: {
            title: 'Stock Out Details For <?php echo date("F", strtotime('m')); ?>',
            
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>

 <!-- End Chart Data By Product -->
     

 

</head>


<body>
	
<div id="content-wrap">		
	<section id="secondary_bar">
		
            <nav><!-- Defining the navigation menu -->
                <ul>
                    <li class="selected"><a href="index.php">Home</a></li>
                    <li><a href="users_modal.php">Add User</a></li>
                    <li><a href="admin_modal.php">Add Admin</a></li>
            
                    <li><a href="report.php">View Reports</a></li>
                    <li class="logout"> <span class="check"> <?php echo "Welcome Batch ID :   ". "<font color='##fa5400'><i><b>".$_SESSION['empID']."</b></i></font>" ;?> </span></li>
					
                </ul>
				
            </nav>
		
	</section><!-- end of secondary bar -->
	
	   	
<aside id="sidebar" class="column">
				
		<hr/>
	    <h3> Spare Part Database Backup:</h3>
		<ul class="toggle">
		    <li class="icn_folder"><a href="backup.php">Backup Database</a></li>
		</ul>
		
		<h3>Reports:</h3>
		<ul class="toggle">
		    <li class="icn_settings"><a href="report.php">Report</a></li>
		    <li class="icn_settings"><a href="products_print.php">Inventory Report</a></li>

     		
		</ul>


		
		<h3>Administrator:</h3>
		<ul class="toggle">
		    <li class="icn_add_user"><a href="users.php">View Employees</a></li>
			<li class="icn_photo"><a href="products.php">View Product</a></li>
			<!-- <li class="icn_tags"><a href="add_warehouse.php">Add Warehouse</a></li>
			<li class="icn_new_article"><a href="add_category.php">Add Category</a></li> -->
		
		</ul>
		
        <!-- <h3>Tables:</h3>
		<ul class="toggle">
		    <li class="icn_categories"><a href="order.php">Order Detial</a></li>
     		<li class="icn_categories"><a href="customerTable.php">Customer Detail</a></li>
		</ul> -->

		<h3>Admin</h3>
		<ul class="toggle">
      

			<li class="icn_jump_back"><a href="logout.php">Logout</a></li>
		</ul>
	
	</aside><!-- end of sidebar -->
	
	<section id="main" class="column">
		
		<h4 class="alert_info"><strong> Welcome To Spare Store Super Admin Panel </strong> </h4> 
		<div class="content-wrap">

		    <div id="columnchart_material" style="width: 1200px; height: 500px;"></div>

<div class="row">

 <div class="column">
 <div id="columnchart12" style="width: 100%; height: 400px;"></div>
</div>


</div>
		</div>





		

        <!-- DataTables -->
 

  <!-- Bootstrap core JavaScript-->
 <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
					
		<?php
$result = mysqli_query($conn,"SELECT p.name as prodname, d.qtyok as quantity, p.price AS price, u.firstname as firstname, u.lastname as lastname, u.empid as empid, u.line as line , s.sales_date as date FROM details d LEFT JOIN sales s ON s.id=d.sales_id LEFT JOIN users1 u ON u.id=s.user_id LEFT JOIN products p ON p.id=d.product_id  WHERE MONTH(s.sales_date)= MONTH(CURDATE()) AND d.detail_status=1 ORDER BY u.line DESC;");
?>
<br><br>
      			

 <div class="container">  
                <div class="table-responsive">  
                     <table id="example" class="table table-striped table-bordered">  
      <thead>
			<thead><th colspan="7"> Stock Out For <?php echo date("F", strtotime('m'));   ?> </th></thead>
		<thead>
			</tr>

    	     <th>Product Name</th>
             <th>Quantity</th>	
	  <th>Total</th>
    		 <th>Emp Name</th>
		     <th>Emp ID</th>	
             <th>Line</th>
             <th>Time</th>					
    		
			</tr>
		</thead>
		<tbody>
<?php while($row = mysqli_fetch_array($result))
  {?>
    <?php
$total = $row['price'] * $row['quantity'];
?>

    <tr>
    <td><?Php echo $row['prodname']; ?></td>
    <td><?Php echo $row['quantity']; ?></td>
    <td><?Php echo 'RM ' .number_format($total,2); ?></td>
    <td><?php echo $row['firstname']. ' '.$row['lastname']; ?></td>
    <td><?php echo $row['empid']; ?></td>
	<td><?php echo $row['line']; ?></td>
	<td><?Php echo date('M d, Y h:ia', strtotime($row['date'])); ?></td>


	

    </tr>

  <?php }mysqli_close($conn);?>
</tbody>
</table>


			</div><!-- end of #tab2 -->
			



	  <!--    <div class="shout_box">
            <div class="header"> live Discussion of SomStore <div class="close_btn">&nbsp;</div></div>
           <div class="toggle_chat">
           <div class="message_box">
           </div>
           <div class="user_info" class="admin">
           <input name="shout_username"  id="shout_username" type="text" placeholder="Your Name" maxlength="15" />
          <input name="shout_message" id="shout_message" type="text" placeholder="Type Message Hit Enter" maxlength="100" /> 
          </div>
           </div>
        </div> -->
		 

		
		<div class="clear"></div>

		<div class="spacer"></div>


	</section>
       </div>
</div>
</div>
 <script>  
$(document).ready(function() {
    $('#example').DataTable( {
   //   dom :'<"pull-left" f><t>',
      "responsive" : false,
       "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "scrollX" : true,

 

    } );
} );
 </script>
</body>

</html>
