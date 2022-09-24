<?php include 'db_connect.php' ?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">

					<div class="card-header">
						<b>Sales List</b> <br>
			<button class="col-md-2 float-right btn btn-primary btn-sm" id="new_sales"><i class="fa fa-plus"></i> New Sales</button>

					</div>
					<div class="card-body">
						<table class="table table-bordered">
							<thead>
								<th class="text-center">#</th>
								<th class="text-center">Reference #</th>
								<th class="text-center">Date/Time</th>
								<th class="text-center">Customer</th>
								<th class="text-center">Total Amount</th>
								<th class="text-center">Action</th>
							</thead>
							<tbody>
							<?php 
								$customer = $conn->query("SELECT * FROM customer_list order by name asc");
								while($row=$customer->fetch_assoc()):
									$cus_arr[$row['id']] = $row['name'];
								endwhile;
									$cus_arr[0] = "GUEST";

								$i = 1;
								// $sales = $conn->query("SELECT * FROM sales_list  order by date(date_updated) desc")
								 $sales = $conn->query("SELECT * FROM sales_list where date(date_updated)= '".date('Y-m-d')."' ");
			
								// order by name asc
								while($row=$sales->fetch_assoc()):

									
							?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class=""><?php echo $row['ref_no'] ?></td>
									<td class="">
										<?php
										 echo date('M d, Y || h:i a',strtotime($row['date_updated']))
										  ?>
									</td>  
									<!-- <td class="">
										<?php 
										// echo date($row['date_updated'])
										 ?>
									</td> -->
									<td class=""><?php echo isset($cus_arr[$row['customer_id']])? $cus_arr[$row['customer_id']] :'N/A' ?></td>
									<td class=""><?php echo $row ['total_amount']  ?>.00</td>
									<td class="text-center">
										<!-- <a class="btn btn-sm btn-primary" href="index.php?page=pos&id=
										<?php //echo $row['id'] ?>
										">Edit</a> -->
										<!-- <a class="btn btn-sm btn-primary" href="print_sales.php?id=
										<?php //echo $row['id'] ?>
										" >Print Receipt</a> -->

				<a class="btn btn-sm btn-primary" href="print_sales.php?id=<?php echo $row['id'] ?>"  
                  onclick="window.open('print_sales.php?id=<?php echo $row['id'] ?>', 
                         'newwindow', 
                         'width=400,height=500'); 
                  return false;"
 				>Print</a>
										<a class="btn btn-sm btn-danger delete_sales" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" >Delete</a>
									</td>
								</tr>
							<?php endwhile; ?>
							</tbody>
						</table>
					</div>
	

<div class="row-sm-6 offset">
	<div class="card bg-primary">
		<div class="card-body text-white">
			<p><b><large>Total Sales Today</large></b></p>
			<hr>
			<p class="text-right"><b><large><?php 
			include 'db_connect.php';
			$sales = $conn->query("SELECT SUM(total_amount) as amount FROM sales_list where date(date_updated)= '".date('Y-m-d')."'");
			echo $sales->num_rows > 0 ? number_format($sales->fetch_array()['amount'],2) : "0.00";
			?></large></b></p>
		</div>
	</div>

	<div class="card bg-success">
		<div class="card-body text-white">
			<p><b><large>Total Count of Transaction Today</large></b></p>
			<hr>
			<p class="text-right"><b><large><?php 
			include 'db_connect.php';
			$sales = $conn->query("SELECT * FROM sales_list where date(date_updated)= '".date('Y-m-d')."'");
			echo $sales->num_rows > 0 ? number_format($sales->num_rows) : "0";

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
	$('#new_sales').click(function(){
		location.href = "index.php?page=pos"
	})
	$('.delete_sales').click(function(){
		_conf("Are you sure to delete this data?","delete_sales",[$(this).attr('data-id')])
	})
	function delete_sales($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_sales',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}




	// $('#manage-sales').submit(function(e){
	// 	e.preventDefault()
	// 	start_load()
	// 	// if($("#list .item-row").length <= 0){
	// 	// 	alert_toast("Please insert atleast 1 item first.",'danger');
	// 	// 	end_load();
	// 	// 	return false;
	// 	// }
	// 	$.ajax({
	// 		url:'ajax.php?action=print_sales',
	// 	    method: 'POST',
	// 	    data: $(this).serialize(),
	// 		success:function(resp){
	// 			if(resp > 0){
	// 				end_load()
	// 				alert_toast("Data successfully submitted",'success')
	// 				var nw = window.open("print_sales.php?id="+resp,"_blank","height=700,width=900")
	// 					nw.print()
	// 					setTimeout(function(){
	// 						nw.close()
	// 						location.reload()
	// 					},700)

	// 			}
				
	// 		}
	// 	})
	// })

</script>