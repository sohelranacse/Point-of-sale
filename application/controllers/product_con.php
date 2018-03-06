<?php



	class Product_Con extends CI_Controller{
		
		public function __construct()
		{
			
		parent::__construct();
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->library("pagination");
		$this->load->database();	
		
		}
		public function create_product(){
		
		$this->load->model('product_model');
		
		
		$admin_user = $this->session->userdata('admin');
		$w=$this->session->userdata('wire');
		
		
		
		$id=$_POST['id'];
		$sell=$_POST['sell'];
		$cost=$_POST['cost'];
		$buy=$_POST['buy'];
		$opening=$_POST['opening'];
		$sort=$_POST['sort'];
		$unit=$_POST['unit'];
		$category=$_POST['category'];
		$ware=$_POST['ware'];
		$pname=$_POST['pname'];
		$pcode=$_POST['pcode'];
		$carton=$_POST['carton'];
		$ptype=$_POST['ptype'];
		$img=$_POST['img'];
		
		
		$check=$this->product_model->getPname('product_ledger','ware',$ware,'id','code',$pcode);
		
		$ara=null;
		if(!empty($check)){
			
			$ara=array("id" => 1);
		}
		else{
			
			
			
			
			$data=array(
			
				"name" => $pname,
				"code" => $pcode,
				"ware" => $ware,
				"category" => $category,
				"unit" => $unit,
				"sorting" => $sort,
				"opening_stock" => $opening,
				"buy_price" => $buy,
				"cost" => $cost,
				"carton" => $carton,
				"head" => $id,
				"uprice" => $buy,
				"selling_price" => $sell,
				"ptype" => $ptype,
				"img" => $img,
				"by" => $admin_user,
			
			);
			
			$this->db->insert('product_ledger',$data);
			$ara=array("id" => 2);
		}
		
		
		echo json_encode($ara);
		
	}
		public function upload(){
		
		//$this->load->database();
		$w = $this->session->userdata('wire');
		
		
		$config['upload_path'] = './file_upload/';

				$config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['max_size'] = '200000';
				$config['max_width'] = '1524000';
				$config['max_height'] = '1000000';

				$this->load->library('upload', $config);
				$this->load->library('image_lib');
					
		$upload = $this->upload->do_upload('photoimg');


					if($upload == true)
						{

					$data1 = array('upload_data' => $this->upload->data());
					$image= $data1['upload_data']['file_name'];

					$configBig = array();
					$configBig['image_library'] = 'gd2';
					$configBig['source_image'] = './file_upload/'.$image;
							
							
					$configBig['create_thumb'] = TRUE;
					$configBig['maintain_ratio'] = FALSE;
					$configBig['width'] = 50;
					$configBig['height'] = 50;
					$configBig['thumb_marker'] = "_big";
					$this->image_lib->initialize($configBig);
					$this->image_lib->resize();
					$this->image_lib->clear();
					unset($configBig);

				

					$filename1 = $data1['upload_data']['raw_name'].'_big'.$data1['upload_data']['file_ext'];
					
					
				
					

					

					
		$this->db->limit(1);
		$this->db->order_by("id", "desc"); 
		$query = $this->db->get("product_ledger");
		$row = $query->row();
		$rename = ($row->id+1)."-"."$w".".jpg";
				
				
				
				

					rename('./file_upload/' .$filename1, './file_upload/' .$rename);
					
					
					
					

				
				
					unlink('./file_upload/'.$image);
		
		
	$loc=base_url()."file_upload";
		
		
		echo "<img id='img' src=".$loc."/".$rename."  class='preview'>";
		
		
		
	
						}	
	}
		
		
		
		
		
		
		
		public function data_edit_update(){
		
		
		$id=$_POST['id'];
		$col=$_POST['col'];
		$datas=trim($_POST['data']);
		$tab=$_POST['tab'];
		
		$data=array(
		
		
		
			$col => $datas
		
		
		);
		
		$this->db->where('id',$id);
		
		
		if($tab == 2)
		$this->db->update('product_ledger',$data);
		else
		$this->db->update('ledger',$data);

		
		$ara=array(
		
			"id" => $datas
		
		
		);
		
		
				echo json_encode($ara);
		
		
		
		
		
		
		
		
		
	}
	
	
	public function product_all(){
		
		
		$admin = $this->session->userdata('admin');
		$t = $this->session->userdata('type');
		$w = $this->session->userdata('wire');
$this->load->model('product_model');
		
		$limit=$_POST['limit'];
		$start=$_POST['start'];
		
		$id=$_POST['id'];
		
		
	$row = $this->product_model->counts_all('product_ledger','head',$id);

		
		
		
		if(!empty($w))
		{
			$this->db->where("(ware='".$w."' OR ware='0')");
		}
		
		
		$this->db->where('head',$id);
		$this->db->limit($limit, $start);
		//$this->db->where('permission !=',1);
		$info=$this->db->get('product_ledger');
		$response["posts"]= array();
		$response["options"]= array();
		$response["ware"]= array();
		$response["tledger"]= array();
		
		
		foreach($info->result_array() as $val)
				{
					
				$post= array();
				$post["id"]= $val["id"];
				$post["name"]= $val["name"];
				$post["head"]= $id;
				$post["code"]= $val["code"];
				$post["carton"]= $val["carton"];
				$post["category"]= $val["category"];
				$post["ptype"]= $val["ptype"];
				$post["unit"]= $val["unit"];
				$post["sorting"]= $val["sorting"];
				$post["opening_stock"]= $val["opening_stock"];
				$post["buy_price"]= $val["buy_price"];
				$post["cost"]= $val["cost"];
				$post["selling_price"]= $val["selling_price"];
				$post["ware"]= $val["ware"];
				
				array_push($response["posts"], $post);

				}
				
				
			$post= array();
			$post["total"]= $row;	
			array_push($response["tledger"], $post);	
				
				
	
			$this->db->order_by('name','ASC');
			$cate=$this->db->get('category');
			foreach($cate->result_array() as $val)
				{
					
				$post= array();
				$post["id"]= $val["id"];
				$post["name"]= $val["name"];
				
				
				array_push($response["options"], $post);

				}


				if(!empty($w))
					{
						$this->db->where('id',$w);
					}


			//$this->db->where('ch !=','');
			$wires=$this->db->get('ware');
			
			foreach($wires->result_array() as $val)
				{
					$post= array();
					$post["id"]= $val["id"];
					$post["name"]= $val["name"];
					
					array_push($response["ware"], $post);
					
				}


				
				
				
		echo json_encode($response);
		
		
	}
	
	public function data_edit_updates(){
		
		
		$id=$_POST['id'];
		$col=$_POST['col'];
		$data=$_POST['data'];
		
		$data=array(
		
		
		
			$col => $data
		
		
		);
		
		$this->db->where('id',$id);
		$this->db->update('product_ledger',$data);
		
		
		
		$ara=array(
		
			"id" => 1
		
		
		);
		
		
				echo json_encode($ara);
		
		
		
		
		
		
		
		
	}
	
	public function ladger_all()
	{
		
		$this->load->model('product_model');
			$admin = $this->session->userdata('admin');
			$t = $this->session->userdata('type');
			$w = $this->session->userdata('wire');
		
		
	$limit=$_POST['limit'];
	$start=$_POST['start'];
	$id=$_POST['head'];
	
	
	
	
	$row = $this->product_model->counts_all('ledger','parent_head_id',$id);
			
				
		if(!empty($w))
		{
			//$this->db->where("(ware='".$w."' OR ware='0')");
			$this->db->where('ware',$w);
		}
	
		$this->db->where('parent_head_id',$id);
		$this->db->limit($limit, $start);
		$this->db->order_by('id', 'desc');
		$info=$this->db->get('ledger');
		
		
		$response["posts"]= array();
		$response["tledger"]= array();
		$response["ware"]= array();
		foreach($info->result_array() as $val)
				{
					
				$post= array();
				$post["id"]= $val["id"];
				$post["ledger_title"]= $val["ledger_title"];
				$post["head"]= $id;
				$post["bank_name"]= $val["bank_name"];
				$post["branch_address"]= $val["branch_address"];
				$post["bank_account_name"]= $val["bank_account_name"];
				$post["bank_account_no"]= $val["bank_account_no"];
				$post["opening_balance"]= $val["opening_balance"];
				$post["ware"]= $val["ware"];
				$post["type"]= $val["type"];
				$post["phone"]= $val["phone"];
				$post["remarks"]= $val["remarks"];
				array_push($response["posts"], $post);

				}
			$post= array();
			$post["total"]= $row;	
			array_push($response["tledger"], $post);


			if(!empty($w))
			{
				$this->db->where('id',$w);
			}


			//$this->db->where('ch !=','');
			$wires=$this->db->get('ware');
			
			foreach($wires->result_array() as $val)
				{
					$post= array();
					$post["id"]= $val["id"];
					$post["name"]= $val["name"];
					
					array_push($response["ware"], $post);
					
				}
				
				if($t == 1)
				{
					$post= array();
					$post["id"]= 0;
					$post["name"]= "Admin";
					
					array_push($response["ware"], $post);
				}
			
		echo json_encode($response);
		
	}
		public function create_ladger(){
		
		
		$this->load->model('product_model');
		
		
		$lg=$this->session->userdata('admin');		
		$w=$this->session->userdata('wire');
		
		$id=$_POST['id'];
		$title=$_POST['title'];
		$remark=$_POST['remark'];
		$date=date('Y-m-d');
		$balance=$_POST['balance'];
		$adress=$_POST['address'];
		$ac_no=$_POST['ac_no'];
		$ac_name=$_POST['ac_name'];
		$bname=$_POST['bname'];
		$wire=$_POST['wire'];
		$phone=$_POST['phone'];
		
		$check=$this->product_model->anyName('ledger','ware',$wire,'id','ledger_title',$title);

	
	

	if(!empty($check))
	{
		
		$ara=array("id" => 2);
		echo json_encode($ara);
	}
	else{
		
		
		$test=array();
		$test=$this->product_model->getChecking('setting','id',$id);
		//$da=date('Y-m-d',strtotime($date));	

		$sup="";
		$cus="";
		
		$length=count($test);
		
		for($i=$length-1;$i>=0;$i--)
			{
				if($test[$i] == 1 || $test[$i] == 3)
				{
					$type=1;
			
				}
				else if($test[$i] == 2 || $test[$i] == 4){
			
						$type=2;
					}
				else if($id == 77)
				{
					$sup="s";
				}
				else if($test[$i] == 77)
				{
					$sup="s";
				}
				else if($id == 76)
				{
					$cus="c";
				}
				else if($test[$i] == 76)
				{
					$cus="c";
				}
				
			}

		
		

			
		
		
		
		
		
		$info=array(
		
							"parent_head_id" => $id,
							"sub_head_id" => '',
							"ledger_title" => $title,
							"bank_name" => $bname,
							"branch_address" => $adress,
							"bank_account_name" => $ac_name,
							"bank_account_no" => $ac_no,
							"opening_balance" => $balance,
							"ware" => $wire,
							"type" => $type,
							"phone" => $phone,
							"date" => $date,
							"remarks" => $remark,
							"sup" => $sup,
							"cus" => $cus,
							"by" => $lg
		
					);
		
		
		$this->db->insert('ledger',$info);
		
		$ara=array("id" => 1);
		echo json_encode($ara);
		
	}
		
		
		
		
	
		
	
	
		}
		
		
	}




 ?>