<div id="page-wrapper">
    <div class="container-fluid">
			
       <div class="row">
           <div class="col-lg-12">
              <h4 class="page-header">Report</h4>
           </div>
                   
       </div>
	   <div class="row">
	   
	    <div class="col-sm-2 col-xs-2">
			
			
			
			</div>			
			<div class="col-sm-8 col-xs-8">
			
			<div class="row">
        <?php
	$this->db->where("id", $this->session->userdata('wire')); 
	$result = $this->db->get('ware');
	$row = $result->row();
        ?>		
					
	<h3 style="text-align:center;margin:0;padding:0"><?php echo $row->name; ?></h3>
<h5 style="text-align:center;margin:0;padding:0"><?php echo $row->theme; ?></h5>
<h5 style="text-align:center;margin:0;padding:0">Phone : <?php echo $row->phone; ?></h5>			
			
			</div>
					<div class="row" style="margin-bottom:10px;">
						

				<h5 style="text-align:center;margin:0;padding:0"><?php echo $row->address; ?></h5>
									
                    </div>
			
			</div>			
			<div class="col-sm-2 col-xs-2"></div>			
						
						
						
	   
	   
	  </div>
	   
	   <div class="row">
			
			
				<div class="col-sm-6 col-xs-6">
				
						<p>Invoice No : <?php echo $invoice;  ?></p>
						<p><?php

						if($type == 1 || $type == 2){
							
							echo "Supplier :".$name;
							
						}
						else{
							
						echo "Customer :".$name;	
							
						}
						
						
						
						?></p>
				
				</div>
				<div class="col-sm-6 col-xs-6">
				

					<div class='col-sm-6'></div>
					<div class='col-sm-6' style='text-align:right'>
					
									<p>Date : <?php echo $date;  ?></p>
						<p>Surved By :<?php

						
						echo $session;
						
						
						?></p>
				
					
					</div>
				
				
				
				</div>
			
			
			</div>
			
			
			
	<div class="row">
						 
							
							
							
							<table style='width:100%;border:1px solid;'>
                    <thead>
               <tr style='border:1px solid;'>
                
                        
                      <th style='padding:5px;border-right:1px solid;text-align:center;'>Product Code</th>
                        
                       <th style='padding:5px;border-right:1px solid;text-align:center;'>Product Name</th>
					    
                        <th style='padding:5px;border-right:1px solid;text-align:center;'>Qnt</th>
                        <th style='padding:5px;border-right:1px solid;text-align:center;'>Price</th>
                        <th style='padding:5px;border-right:1px solid;text-align:center;'>Total Price</th>
                        
                        

                        
					
                    </tr>
                    </thead>
                    <tbody style="background:white">
					
					
			<?php $amount=0; foreach($all as $val): ?>
		
			<tr style='border:1px solid;'>
		
		<?php 
		
		if($type == 2 || $type == 3){
			
			?>
			
					<td style='padding:5px;border-right:1px solid;text-align:center;'><?php 

				echo $val['c_id'];


				?></td>
			
			
			<?php
		}
		if($type == 1 || $type == 4){
			?>
			
					<td style='padding:5px;border-right:1px solid;text-align:center;'><?php 

				echo $val['d_id'];


				?></td>
			
			<?php
			
		}
			
		else if($type == 12)
		{
			?>
			
			<td style='padding:5px;border-right:1px solid;text-align:center;'></td>
			
			
			<?php
		}
		
		
		?>
		
		
		
		
		<?php 
		
		if($type == 2 || $type == 3){
			
			?>
			
					<td style='padding:5px;border-right:1px solid;text-align:center;'><?php 

						echo $this->report_model->anyName('product_ledger','code',$val['c_id'],'name');


				?></td>
			
			
			<?php
		}
		else if($type == 1 || $type == 4){
			?>
			
					<td style='padding:5px;border-right:1px solid;text-align:center;'><?php 

echo $this->report_model->anyName('product_ledger','code',$val['d_id'],'name');


				?></td>
			
			<?php
			
		}
			
		else if($type == 12){
			?>
			
					<td style='padding:5px;border-right:1px solid;text-align:center;'><?php 

					echo $this->report_model->anyName('ledger','id',$val['c_id'],'ledger_title');


				?></td>
			
			<?php
			
		}
		
		
		?>
		
		
		
			<td style='padding:5px;border-right:1px solid;text-align:center;'><?php echo $val['qun'] ?></td>
			<td style='padding:5px;border-right:1px solid;text-align:center;'><?php


			//$val['price'] 
			
													echo number_format(round($val['price'],2), 2, '.', ',');	
		
			
			?></td>
			<td style='padding:5px;border-right:1px solid;text-align:center;'><?php


		//echo $val['amount']; 
		$amount=$amount+$val['amount'];
												echo number_format(round($val['amount'],0), 2, '.', ',');	

		?></td>
		
		
		</tr>
		
			
						<?php endforeach; ?>
					
					
		<tr style='border:1px solid;'>
		
		
					<td colspan="4" style='padding:5px;'><strong>Net Amount</strong></td>
					<td style='padding:5px;text-align:center;'><strong><?php


				//	echo $amount
										echo number_format(round($amount,0), 2, '.', ',');	



					?></strong></td>
		
		</tr>
					
					
					</tbody>

</table>



							
							
							
							
							
							
							
							
							
						
						
						
                    </div>	



					
			
			<div class="row">
				
				
				<div class="col-sm-12">
							
							
								<strong>(In words) : Taka 


									<?php
										try
											{
												echo convert_number($amount);
											}
										catch(Exception $e)
											{
												echo $e->getMessage();
											}
										?>

										only.</strong>


							
							
							
							</div>
				
				
				
				</div>	
			
		<div class="row">
	
	
			<div class="col-sm-6 col-xs-6"></div>
			<div class="col-sm-6 col-xs-6">
			
			
				<table style='width:100%;border:1px solid;'>
			
					<tbody>
					
						<?php foreach($inv as $val): ?>
						
						<tr style="border:1px solid;">
						
								<td style='padding:5px;border-right:1px solid;text-align:center;'> Net Payable </td>
								<td style='padding:5px;border-right:1px solid;text-align:center;'><?php


								//echo $val['gross_amount'] 
								
										echo number_format(round($val['gross_amount'],0), 2, '.', ',');	
			
								?></td>
						
						</tr>
						
						<tr style="border:1px solid;">
						
								<td style='padding:5px;border-right:1px solid;text-align:center;'> Discount </td>
								<td style='padding:5px;border-right:1px solid;text-align:center;'><?php


								//echo $val['gross_dis'] ;
					echo number_format(round($val['gross_dis'],0), 2, '.', ',');	
			
								
								$total=($val['due']+$previous);
								
								?></td>
						
						</tr>
						<tr style="border:1px solid;">
						
								<td style='padding:5px;border-right:1px solid;text-align:center;'> Cash</td>
								<td style='padding:5px;border-right:1px solid;text-align:center;'><?php


								//echo $val['cash'] 
								
echo number_format(round($val['cash'],0), 2, '.', ',');	
								
								
								
								?></td>
						
						</tr>
						
						
						<tr style="border:1px solid;">
						
								<td style='padding:5px;border-right:1px solid;text-align:center;'> Bkash</td>
								<td style='padding:5px;border-right:1px solid;text-align:center;'><?php


								//echo $val['bk_amount'] 
								
echo number_format(round($val['bk_amount'],0), 2, '.', ',');	
								
								
								
								?></td>
						
						</tr>
						
						
						<tr style="border:1px solid;">
						
								<td style='padding:5px;border-right:1px solid;text-align:center;'> Bank</td>
								<td style='padding:5px;border-right:1px solid;text-align:center;'><?php


								//echo $val['card'] 
								
echo number_format(round($val['card'],0), 2, '.', ',');	
								
								
								
								?></td>
						
						</tr>
							<tr style="border:1px solid;">
						
								<td style='padding:5px;border-right:1px solid;text-align:center;'> Previous Due</td>
								<td style='padding:5px;border-right:1px solid;text-align:center;'><?php


								//echo $previous 
				
    $de_am=$this->report_model->getPreviousBalance('product_trans','',"invoice_id <",$val["invoice"],'dr',$val["supplier"]);
   $cr_am=$this->report_model->getPreviousBalance('product_trans','',"invoice_id <",$val["invoice"],'cr',$val["supplier"]);
	$opening=$this->report_model->anyName('ledger',"id",$val["supplier"],"opening_balance");
	                

		$pre=(($de_am+$opening) - $cr_am);					

				
								
							echo number_format(round((($de_am+$opening) - $cr_am),0), 2, '.', ',');	
								
								
								
								?></td>
						
						</tr>
					<tr style="border:1px solid;">
						
								<td style='padding:5px;border-right:1px solid;text-align:center;'>Due</td>
								<td style='padding:5px;border-right:1px solid;text-align:center;'><?php


								//echo $val['due'] 
								
echo number_format(round($val['due']  ,0), 2, '.', ',');	
								
								
								
								
								?></td>
						
						</tr>
						
						
						
						<tr style="border:1px solid;">
						
								<td style='padding:5px;border-right:1px solid;text-align:center;'>Total Due</td>
								<td style='padding:5px;border-right:1px solid;text-align:center;'><?php

								//echo $previous+$val['due']


echo number_format(round($pre+$val['due'] ,0), 2, '.', ',');	

								?></td>
						
						</tr>
						
						
					

<tr style="border:1px solid;">
						
								<td style='padding:5px;border-right:1px solid;text-align:center;'> Remarks </td>
								<td style='padding:5px;border-right:1px solid;text-align:center;'><?php echo $val['remarks'] ?>
						
						</tr>




						
						<?php endforeach; ?>
					
					</tbody>
			
			
			</table>
					
			
			
			
			</div>
	
	
	</div>	


<div class="row" style="margin-top:60px;">

<div class="col-sm-3 col-xs-3">
	
	
	
	
		<p style='border-top:2px solid;'><strong>Customer Signature</strong></p>
	
	
	
	</div>


	<div class="col-sm-3 col-xs-3"></div>
			
		<div class="col-sm-3 col-xs-3"></div>

	<div class="col-sm-3 col-xs-3">
	
	
	
	<p style='border-top:2px solid;text-align:right;'><strong>Authorise Signature</strong></p>
	
	
	</div>


</div>












	
<script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
				   
	   
	</div>
	
</div>
<?php

function convert_number($number) 
{ 
    if (($number < 0) || ($number > 999999999)) 
    { 
    throw new Exception("Number is out of range");
    } 

    $Gn = floor($number / 100000);  /* Millions (giga) */ 
    $number -= $Gn * 100000; 
    $kn = floor($number / 1000);     /* Thousands (kilo) */ 
    $number -= $kn * 1000; 
    $Hn = floor($number / 100);      /* Hundreds (hecto) */ 
    $number -= $Hn * 100; 
    $Dn = floor($number / 10);       /* Tens (deca) */ 
    $n = $number % 10;               /* Ones */ 

    $res = ""; 

    if ($Gn) 
    { 
        $res .= convert_number($Gn) . " Lac"; 
    } 

    if ($kn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($kn) . " Thousand"; 
    } 

    if ($Hn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($Hn) . " Hundred"; 
    } 

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
        "Nineteen"); 
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
        "Seventy", "Eigthy", "Ninety"); 

    if ($Dn || $n) 
    { 
        if (!empty($res)) 
        { 
            $res .= " and "; 
        } 

        if ($Dn < 2) 
        { 
            $res .= $ones[$Dn * 10 + $n]; 
        } 
        else 
        { 
            $res .= $tens[$Dn]; 

            if ($n) 
            { 
                $res .= "-" . $ones[$n]; 
            } 
        } 
    } 

    if (empty($res)) 
    { 
        $res = "zero"; 
    } 

    return $res; 
} 
?>