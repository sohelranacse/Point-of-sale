<div id="page-wrapper">
    <div class="container-fluid">
	
		<div class="panel panel-default heads">
		
			<div class="panel-heading">
			
			
				Stock Summary
			
			
			</div>
			<div class="panel-body">	
				<div class="row">
				
				<form class="form-horizontal bucket-form" method="post" action="<?php echo base_url(); ?>mains/stock_summary/<?php echo $head ?>">

				
				<div class="form-group">
                      <label class="col-sm-2 control-label">Start Date</label>
                        <div class="col-sm-2">
 <input type="text" value="<?php echo $start ?>" name="start_date" class="form-control tcal tcalInput">
                        </div>
						
						
						
			<label class="col-sm-1 control-label">End Date</label>				 
                        <div class="col-sm-2">
<input type="text" value="<?php echo $end ?>" name="end_date" class="form-control tcal tcalInput">
                        </div>



							 <div class="col-sm-2">
<input type="submit" class="form-control">
                        </div>
						
						
						
                    
				</div>

					</form>
				
				
				</div>
				
				
				
				
				
				<div class="row">
				
				
				
				
				
				<table  class="display table table-bordered" id="dynamic-table" >

		<thead>
		
			<tr>
			
			<?php 
					
					$cols=0;
				if($head != 0){
					?>
					<th>CATEGORY</th>
					<th>O/QTY</th>
					<th>P/QTY</th>
					<th>P R/QTY</th>
					<th>S/QTY</th>
					<th>S R/QTY</th>
					<th>C/QTY</th>
					<?php
					
		
				}


			?>
			
			</tr>
		
		</thead>


		<tbody>
		<?php if($head != 0): ?>
		
		
			<?php

				$sub=0;
				
				$subc=0;  
			
$data['all']=$this->report_model->getTrialBalance('setting','head',$head); 

			

			?>
			
			<?php

					if(empty($data['all'])){
						

$admin = $this->session->userdata('admin');

		
$ledger_id['all']=$this->report_model->getTrialBalance('product_ledger
','head',$head);
		
		
			$op_qun=0;
			$pur_qun=0;
			$pur_qunr=0;
			$sale_qun=0;
			$sale_qunr=0;
			$close_qun=0;
				
					
			foreach($ledger_id['all'] as $leg){

		?>
				<tr>
		<?php
		$data['start_date']=$start;
		$data['end_date']=$end;
		
		
		
$op_debit=$this->report_model->getQuantity('product','date',$start,$end,'d_id',$leg['code'],$admin);
		
		
$op_credit=$this->report_model->getQuantity('product','date',$start,$end,'c_id',$leg['code'],$admin);
		
		
$total_open_qun=$leg['opening_stock']+($op_debit-$op_credit);		
$op_qun=$op_qun+$total_open_qun;




$pur1=$this->report_model->getFinalDCValue2('product','d_id',$leg['code'],'qun',$start,$end,$admin,'1');

$pur_return1=$this->report_model->getFinalDCValue2('product','c_id',$leg['code'],'qun',$start,$end,$admin,'2');




$pur_qun=$pur_qun+$pur1;
$pur_qunr=$pur_qunr+$pur_return1;




$purs=$this->report_model->getFinalDCValue2('product','c_id',$leg['code'],'qun',$start,$end,$admin,'3','5');

$pur_returns=$this->report_model->getFinalDCValue2('product','d_id',$leg['code'],'qun',$start,$end,$admin,'4');



					
	$sale_qun=$sale_qun+$purs;
$sale_qunr=$sale_qunr+$pur_returns;


		
		



		

	
$op_debit=$this->report_model->getClosingQun('product','date',$start,$end,'d_id',$leg['code'],$admin);
		
		
$op_credit=$this->report_model->getClosingQun('product','date',$start,$end,'c_id',$leg['code'],$admin);
		
		
$total_close_qun=$leg['opening_stock']+($op_debit-$op_credit);


$close_qun=$close_qun+$total_close_qun;

					?>
					
		<td><?php

		
		if(!empty($leg['img'])){
			?>
		

		<img src="<?php echo base_url(); ?>file_upload/<?php echo $leg['img'] ?>">
		
			
			<?php
			
		}
		

		echo $leg['name']; 
		
		
		
		
		?></td>
		<td><?php echo $total_open_qun ?></td>
		<td><?php echo $pur1 ?></td>
		<td><?php echo $pur_return1 ?></td>
			<td><?php echo $purs ?></td>
		<td><?php echo $pur_returns ?></td>
		<td><?php echo $total_close_qun ?></td>


								</tr>

				<?php
	
					
		
				}


		?>

					<tr>

							<td><strong>Total -> </strong></td>
							<td><strong><?php echo $op_qun; ?></strong></td>
							<td><strong><?php echo $pur_qun; ?></strong></td>
							<td><strong><?php echo $pur_qunr;  ?></strong></td>
							<td><strong><?php echo $sale_qun; ?></strong></td>
							<td><strong><?php echo $sale_qunr; ?></strong></td>
							
							<td><strong><?php echo $close_qun; ?></strong></td>
							
							
					</tr>

				<?php
				
					}
					else{
						?>
						
						<?php $j=1; foreach($data['all'] as $ass): ?>
			
					<tr>
					
<td><a target="_blank" href="<?php echo base_url(); ?>mains/stock_summary_details/<?php echo $ass['id'] ?>/<?php echo $start ?>/<?php echo $end; ?>"><strong><?php echo $ass['name']; ?></strong></a>
							
							
	<?php 

	$test=array();
	$test=$this->report_model->getTrialValue('setting','head',$ass['id']);	
	$length=count($test);
$admin = $this->session->userdata('admin');
		
		$pur_total_qun=0;
		$pur_total_qunr=0;
		
		$sale_total_qun=0;
		$sale_total_qunr=0;
		
		

		$total_open_qun=0;
				

		$total_close_qun=0;
	
		for($i=$length-1;$i>=0;$i--){
				
			$ledger_id['all']=$this->report_model->getTrialBalance('product_ledger
','head',$test[$i]);
			
				foreach($ledger_id['all'] as $leg){


		$data['start_date']=$start;
		$data['end_date']=$end;
		
	
		
		
$op_debit=$this->report_model->getQuantity('product','date',$start,$end,'d_id',$leg['code'],$admin);
		
		
$op_credit=$this->report_model->getQuantity('product','date',$start,$end,'c_id',$leg['code'],$admin);
		
		
$total_open_qun=$total_open_qun+$leg['opening_stock']+($op_debit-$op_credit);		
		


				



$pur=$this->report_model->getFinalDCValue2('product','d_id',$leg['code'],'qun',$start,$end,$admin,'1');

$pur_return=$this->report_model->getFinalDCValue2('product','c_id',$leg['code'],'qun',$start,$end,$admin,'2');



$pur_total_qun=$pur_total_qun+$pur;
$pur_total_qunr=$pur_total_qunr+$pur_return;

$pur=$this->report_model->getFinalDCValue2('product','c_id',$leg['code'],'qun',$start,$end,$admin,'3','5');

$pur_return=$this->report_model->getFinalDCValue2('product','d_id',$leg['code'],'qun',$start,$end,$admin,'4');



$sale_total_qun=$sale_total_qun+$pur;
$sale_total_qunr=$sale_total_qunr+$pur_return;					
	


		
		
$op_debit=$this->report_model->getClosingQun('product','date',$start,$end,'d_id',$leg['code'],$admin);
		
		
$op_credit=$this->report_model->getClosingQun('product','date',$start,$end,'c_id',$leg['code'],$admin);
	
	
		
$total_close_qun=$total_close_qun+$leg['opening_stock']+($op_debit-$op_credit);



		//echo "cl->".$op_credit."<br>";





	
					
		
				}
			
			
			}

				


			?>
							

				<td><?php echo  $total_open_qun;?></td>
				<td><?php echo $pur_total_qun;?></td>
				<td><?php echo $pur_total_qunr;?></td>
				<td><?php echo $sale_total_qun;?></td>
				<td><?php echo $sale_total_qunr;?></td>
				<td><?php echo $total_close_qun; ?></td>

							
							
					
					</tr>
			
			<?php endforeach; ?>
			
			
			
						
						<?php
						
						
						
						
						
						
						
						
						
						$ledger_id['all']=$this->report_model->getTrialBalance('product_ledger
','head',$head);
		
		
			$op_qun=0;
			$pur_qun=0;
			$pur_qunr=0;
			$sale_qun=0;
			$sale_qunr=0;
			$close_qun=0;
				
					
			foreach($ledger_id['all'] as $leg){

		?>
				<tr>
		<?php
		$data['start_date']=$start;
		$data['end_date']=$end;
		
		
		
$op_debit=$this->report_model->getQuantity('product','date',$start,$end,'d_id',$leg['code'],$admin);
		
		
$op_credit=$this->report_model->getQuantity('product','date',$start,$end,'c_id',$leg['code'],$admin);
		
		
$total_open_qun=$leg['opening_stock']+($op_debit-$op_credit);		
$op_qun=$op_qun+$total_open_qun;




$pur1=$this->report_model->getFinalDCValue2('product','d_id',$leg['code'],'qun',$start,$end,$admin,'1');

$pur_return1=$this->report_model->getFinalDCValue2('product','c_id',$leg['code'],'qun',$start,$end,$admin,'2');




$pur_qun=$pur_qun+$pur1;
$pur_qunr=$pur_qunr+$pur_return1;




$purs=$this->report_model->getFinalDCValue2('product','c_id',$leg['code'],'qun',$start,$end,$admin,'3','5');

$pur_returns=$this->report_model->getFinalDCValue2('product','d_id',$leg['code'],'qun',$start,$end,$admin,'4');



					
	$sale_qun=$sale_qun+$purs;
$sale_qunr=$sale_qunr+$pur_returns;


		
		



		

	
$op_debit=$this->report_model->getClosingQun('product','date',$start,$end,'d_id',$leg['code'],$admin);
		
		
$op_credit=$this->report_model->getClosingQun('product','date',$start,$end,'c_id',$leg['code'],$admin);
		
		
$total_close_qun=$leg['opening_stock']+($op_debit-$op_credit);


$close_qun=$close_qun+$total_close_qun;

					?>
					
					<td><?php



						if(!empty($leg['img'])){
			?>
		

		<img src="<?php echo base_url(); ?>file_upload/<?php echo $leg['img'] ?>">
		
			
			<?php
			
		}
		

		echo $leg['name'];
					
					
					
					
					
					
					
					?></td>
					<td><?php echo $total_open_qun ?></td>
					<td><?php echo $pur1 ?></td>
					<td><?php echo $pur_return1 ?></td>
					<td><?php echo $purs ?></td>
					<td><?php echo $pur_returns ?></td>
					<td><?php echo $total_close_qun ?></td>


								</tr>

				<?php
	
					
		
				}


		?>

					<tr>

							<td><strong>Total -> </strong></td>
							<td><strong><?php echo $op_qun; ?></strong></td>
							<td><strong><?php echo $pur_qun; ?></strong></td>
							<td><strong><?php echo $pur_qunr;  ?></strong></td>
							<td><strong><?php echo $sale_qun; ?></strong></td>
							<td><strong><?php echo $sale_qunr; ?></strong></td>
							
							<td><strong><?php echo $close_qun; ?></strong></td>
							
							
					</tr>
						
						
						
						
						
						
						
						<?php
						
						
						
					}



			?>
			
			
			
			
			
		
		<?php endif; ?>
		
		
		
		</tbody>
					
					
					
					
	</table>				
			
				
				
				
				
				
				
				
				
				
				
				
				
				</div>
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
			</div>
			
	</div>
	
	

	
	
	
	<script src="<?php echo base_url(); ?>js/custom/tcal.js"></script>
	
	
	
	
	
	</div>
	</div>