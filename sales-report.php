<?php 
	include 'db_connect.php';
	include_once 'header.php';
	include_once 'ajax.php';
	//include_once 'admin_class.php';
	
	include_once 'topbar.php';
	
?>
<div class="container-fluid">
	<div class="col-lg-12">
		<!-- <div class="row">
		</div> -->
		<div class="row">
			<div class="col-md-9 offset-md-3">
				<div class="card" >
		
<div class="row">	
	<?php
		include_once 'navbar.php';
	?>
</div>


<div class="card-header">
	<!-- <button><a href="index.php?page=home" class="text-center">Go Back</a></button> -->
	<h2 class="text-center "> <b>SALES REPORT</b> </h2> 
	<form action="sales-report.php" method="GET">

				<div class="col-md-14 form-group form-inline">
				<label class="font-weight-bold" for="">From Date :</label>
				<input type="date" required  class="form-control" name="from_date"  >
				

				<label class="font-weight-bold" for="">To Date :</label>
				<input type="date" required class="form-control" name="to_date" >
				
				
				<button class="btn btn-danger" onclick="location.reload();"><i class="fa fa-refresh"></i></button>
				<!-- <input type="submit" class="col-md-2 float-right btn btn-primary"  value="Generate Report" > -->
                 <button class="col-md-2 float-right btn btn-primary">  
				<i class="fa fa-plus"></i>
				Generate Report
                </button> <br>

				<!-- <button class="col-md-2 btn">  
				<i class="fa fa-plus"></i>
				Generate Report
                </button> <br> -->
			 
			</div>
	</form>
</div>


					<div class="card-body">
						<table class="table table-bordered">
							<thead>
								<th class="text-center">#</th>
								<th class="text-center">Reference #</th>
								<th class="text-center">Date/Time</th>
								<th class="text-center">Customer</th>
								<th class="text-center">Total Amount</th>
								<th class="text-center">Actions</th>
							</thead>
							<tbody>
							<?php 
                              
								if(isset($_GET['from_date']) && isset($_GET['to_date'])){
                                     $from_date = $_GET['from_date'];
                                     $to_date = $_GET['to_date'];

									 $customer = $conn->query("SELECT * FROM customer_list order by name asc");
									 while($row=$customer->fetch_assoc()):
										 $cus_arr[$row['id']] = $row['name'];
									 endwhile;
										 $cus_arr[0] = "GUEST";
	 
									 $i = 1;
                                    $query = "SELECT * FROM sales_list WHERE date(date_updated) BETWEEN '$from_date' AND '$to_date' ";
                                    $query_run = mysqli_query($conn, $query);

                                    if(mysqli_num_rows($query_run)>0){
                                        foreach($query_run as $row){
                                           ?>
                                            <tr>
                                            <td class="text-center"><?php echo $i++ ?></td>
                                            <td class=""><?php echo $row['ref_no'] ?></td> 
                                            <td class=""><?php echo date('M d, Y || h:i a',strtotime($row['date_updated']))?>
											</td>
                                            <td class=""><?php echo isset($cus_arr[$row['customer_id']])? $cus_arr[$row['customer_id']] :'N/A' ?></td>
                                            <td class=""><?php echo $row['total_amount']  ?>.00</td>
											<td class="text-center">
											<a class="btn btn-sm btn-primary" href="print_sales.php?id=<?php echo $row['id'] ?>"  
												onclick="window.open('print_sales.php?id=<?php echo $row['id'] ?>', 
														'newwindow', 
														'width=400,height=500'); 
												return false;"
												>Print</a>

										<!-- <a class="btn btn-sm btn-danger delete_sales" href="javascript:void(0)" data-id="<?php
										//	echo $row['id'] ?>" >Delete</a> -->
											</td>
                                            </tr> 
                                   <?php 
                                        }
                                    }else{
										echo '<span style="color:red;text-align:center;">Request has been Returned. No Record Found!</span>';

                                       // echo "<p text-color='red'>No Record Found</p>";
                                    }
                                }

							        ?>
							</tbody>
						</table>
					</div>
	

<div class="row-sm-6 offset">
	<div class="card bg-primary">
		<div class="card-body text-white">
			<p><b><large>
				Transaction From - ( <?php if(isset($_GET['from_date'])) {echo $_GET['from_date'];}else{	echo '<span style="color:red;text-align:center;">N/A</span>';}  ?>)
				 To - ( <?php if(isset($_GET['to_date'])) {echo $_GET['to_date'];}else{echo '<span style="color:red;text-align:center;">N/A</span>';}  ?>)
			</large></b></p>
			<hr>
			<p class="text-right"><b><large>
			<?php 
			include 'db_connect.php';
			if(isset($_GET['from_date']) && isset($_GET['to_date'])){
			$sales = $conn->query("SELECT SUM(total_amount) as amount FROM sales_list where date(date_updated) BETWEEN '$from_date' AND '$to_date'");
			echo $sales->num_rows > 0 ? number_format($sales->fetch_array()['amount'],2) : "0.00";
			}else {
				echo '<span style="color:red;text-align:center;">Not Available!</span>';
				//echo "N/A";
			}
			?>
	</large></b></p>
		</div>
	</div>

	<div class="card bg-success">
		<div class="card-body text-white">
			<p><b><large>
			Total Count of Transaction  From - ( <?php if(isset($_GET['from_date'])) {echo $_GET['from_date'];}else{echo '<span style="color:red;text-align:center;">N/A</span>';}  ?>)
			 To - ( <?php if(isset($_GET['to_date'])) {echo $_GET['to_date'];}else{echo '<span style="color:red;text-align:center;">N/A</span>';}  ?>)
			</large></b></p>
			<hr>
			<p class="text-right"><b><large><?php 
			include 'db_connect.php';
			if(isset($_GET['from_date']) && isset($_GET['to_date'])){
			$sales = $conn->query("SELECT * FROM sales_list where date(date_updated) BETWEEN '$from_date' AND '$to_date'");
			echo $sales->num_rows > 0 ? number_format($sales->num_rows) : "0";
			}else {
				//echo "N/A";
				echo '<span style="color:red;text-align:center;">Not Available!</span>';
			}
				?></large></b></p>
		</div>
	</div>

</div>


				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$('table').dataTable()

	

</script>