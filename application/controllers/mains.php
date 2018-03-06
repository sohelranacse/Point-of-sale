<?php


	class Mains extends CI_Controller{
		
		public function __construct()
		{
			parent::__construct();
			$this->load->model('report_model');
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->library("pagination");
			

	$admin_user = $this->session->userdata('admin');
		if(empty($admin_user))
		{	
		redirect('member/adminlogin');
		}
			
		}
		public function indi_invoice(){
		
		$data['type']=0;
		$data['edit']=0;
		$data['links']='';
		$this->load->view('home/headar',$data);
		
		$inv=$this->input->post('inv');
		$ware=$this->session->userdata('wire');
		$type=$this->session->userdata('type');
		$admin = $this->session->userdata('admin');
		
		if(empty($admin))
			redirect('admin');
		
		
	$data['all']=$this->report_model->getindInvoice('invoice','invoice',$inv);
	
	$data['start_date']=date('Y-m-d');	
	$data['end_date']=date('Y-m-d');	
	$this->load->view('report/daily_sale_report',$data);
	$this->load->view('home/footer');
		
	}


public function cs()
		{
			
			$ware=$this->session->userdata('wire');
		$type=$this->session->userdata('type');
		$admin = $this->session->userdata('admin');
		
		
		 $this->load->model('setting');
		
		
		if(empty($admin))
				redirect('admin');
		
		
		$data['type']=0;

			$this->load->view('home/headar',$data);

		
			$this->load->view('report/cs');
		
	//$data['max']=$this->setting->getMax('invoice','invoice');
	////$data['bank']=$this->setting->getBank('ledger');	
	//$this->load->view('admin/purchase',$data);
		
		
		
		
		
		
		$this->load->view('home/footer');
			
			
		}
		
		public function invoice_edit($id,$ltype,$sup){
		
		
		$admin=$this->session->userdata('admin');
		$w=$this->session->userdata('wire');
		$type=$this->session->userdata('type');
		
		if(empty($admin))
			redirect('admin');
		
		$data['type']=0;
		
		/*if($type == 3)
				{
					$data['all2']=$this->report_model->getMenuData($t,$admin);
					$this->load->view('main/header2',$data);
				
				}
				else{
					*/
				$this->load->view('home/headar',$data);	
					
				//}
		
		
		
		
		
		$data['col']=null;
		$data['col2']=null;
		$table=null;
		
		$data['type']=$ltype;
		$data['invoice']=$id;
		$data['date']=$this->report_model->anyName('invoice','invoice',$id,'date','ware',$w);
		
		
		if((int)$ltype == 1){
			
			$data['col']="cr";
			$data['col2']="d_id";
			$table="supplier";
		}
		else if((int)$ltype == 2){
			
			$data['col']="dr";
			$data['col2']="c_id";
		$table="supplier";
			}
		else if((int)$ltype == 3 || (int)$ltype == 12){
			
			$data['col']="dr";
			$data['col2']="c_id";
			$table="customer";
		}
		else if((int)$ltype == 4)
			{
			
				$table="customer";
				$data['col']="cr";
				$data['col2']="d_id";
			}
		

		$check=$this->report_model->anyName('invoice','invoice',$id,'date');
		
		$data['date']=$check;
		$data['cus']=$this->report_model->anyName('ledger','id',$sup,'ledger_title')."*".$sup;


		
		//$w = $this->session->userdata('wire');
		
		
	
		
		$this->db->where('issu',(int)$ltype);

		$this->db->where('ware',$w);
		$this->db->where('invoice',$id);
		$invoice=$this->db->get('invoice');
		
		
		$data['invo']=$invoice->result_array();

		$data['bank']=$this->report_model->getBank('ledger');
		
		
		
		
		if((int)$ltype != 5){
			
			
			
			
		$this->db->where('ware',$w);
		$this->db->where('trans_id',$id);
		$this->db->where('type',$ltype);
		$info=$this->db->get('product');
		
		
		$data['product']=$info->result_array();	
		$this->load->view('admin/invoice_edit',$data);

			
		}
	
		else{
			
			$data['type']=3;
			
			$this->db->where('ware',$w);
		$this->db->where('trans_id',$id);
		$info=$this->db->get('issu');
		
		
		$data['product']=$info->result_array();
			
		$this->load->view('admin/issu_edit',$data);	
	
			
		}



		$this->load->view('home/footer');
		
		
	}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		public function invoice_delete($id)
		{
			$w=$this->session->userdata('wire');
			
			if(empty($w))
				redirect('admin');
			
			$this->db->where('ware',$w);
			$this->db->where('invoice',$id);
			$this->db->delete('invoice');
			
			
			
			$this->db->where('ware',$w);
			$this->db->where('trans_id',$id);
			$this->db->delete('issu');
			
			
			
			$this->db->where('ware',$w);
			$this->db->where('trans_id',$id);
			$this->db->delete('product');
			
			
			
			$this->db->where('ware',$w);
			$this->db->where('invoice_id',$id);
			$this->db->delete('product_trans');
			
			
			
			redirect('mains/daily_sale_report');
			
		}
		
	public function daily_sale_report($types=null,$starts=null,$ends=null)
	{
		
		$ware=$this->session->userdata('wire');
		$type=$this->session->userdata('type');
		$admin = $this->session->userdata('admin');
		
		if(empty($admin))
			redirect('admin');
		
		
		
		
		$data['type']=0;
		/*
		if($type == 3)
				{
					$data['all2']=$this->news_model->getMenuData($ware,$admin);
					$this->load->view('main/header2',$data);
				
				
			$data['edit']=1;	
				
				
				
				
				}
				else{
					*/
				$data['edit']=0;

				
			$this->load->view('home/headar',$data);
					
				//}
		
	
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('start_date','start_date', 'required');
		$this->form_validation->set_rules('end_date','end_date', 'required');
	
	if ($this->form_validation->run() === FALSE)
	{	
	
		$data['start_date']=date('Y-m-d');
		$data['end_date']=date('Y-m-d');
		
		//$data['type']=$this->input->post('type');

	}
	else{
		
		
		
		$start_date=$this->input->post('start_date');
		$end_date=$this->input->post('end_date');
		
		$data['type']=$this->input->post('type');
		
		$data['start_date']=$start_date;
		$data['end_date']=$end_date;	
		
		
		
		
	}
	

             if((int)$data['type'] == 6)
	                              {
		
		
		
	$data['all']=$this->report_model->getPending('invoice',$data['start_date'],$data['end_date'],'','noti','0');
		
		
		
		
	                               }
                                       else{




		$config = array();
        $config["base_url"] = base_url() . "mains/daily_sale_report";
		$config["total_rows"] = $this->report_model->all_count('invoice','','',$data['start_date'],$data['end_date'],$data['type']);
         $config["per_page"] = 15;
		$config['num_links'] = 5;
		$config['use_page_numbers'] = TRUE;
		
		
		if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
		
		
		
		$config['first_link'] = 'First';
        $config["uri_segment"] = 3;
$config['last_link'] = 'LAST';
$config['next_link'] = '...NEXT';
		$config['prev_link'] = 'PREV...';

				$config['full_tag_open'] = '<div id="pagination">';
$config['full_tag_close'] = '</div>';
$config['anchor_class'] = 'class="number" ';
		$config['use_page_numbers'] = TRUE;
		
        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
		
		$limit = $config["per_page"];
	 if ($page!=0)
            {
              $page = ($page * $limit)-$limit;
            }
            else
            {
              $page= 0;
            }
	
     
	
	
	
	
	$data['all']=$this->report_model->pagination('invoice','','',$config["per_page"], $page,$data['type']);







                                                }




	
		

	$data["links"] = $this->pagination->create_links();

	
	$this->load->view('report/daily_sale_report',$data);
	$this->load->view('home/footer');	
		
	}	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
public function product_report(){
		
		
		$ware=$this->session->userdata('wire');
		$type=$this->session->userdata('type');
		$admin=$this->session->userdata('admin');
		
		
		if(empty($admin))
			redirect('admin');

		$data['type']=0;
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('ledger_id','ledger_id', 'required');
		$this->form_validation->set_rules('start_date','start_date', 'required');
		$this->form_validation->set_rules('end_date','end_date', 'required');
		if ($this->form_validation->run() === FALSE)
			{
		
			/*if($type == 3)
				{
					$data['all2']=$this->news_model->getMenuData($ware,$admin);
					$this->load->view('main/header2',$data);
				
				}
				else{
					*/
	$this->load->view('home/headar',$data);
				//}	
		$data['start']=date('Y-m-d');
		$data['end']=date('Y-m-d');
		
			
			$this->load->view('report/product_ledger',$data);
			$this->load->view('home/footer');
		
		
		
		
			}
		else{
			
				
			
			
			$code=explode('*',$this->input->post('ledger_id'));
			
			$data['start']=$this->input->post('start_date');
			$data['end']=$this->input->post('end_date');
			
			
	$data['name']=$code[0];
	$data['code']=$code[1];
	
	$data['all']=$this->report_model->getAllProductTransList('product',$code[1],$data['start'],$data['end']);
	
	
	

	
			$this->load->view('report/report_header2');
			
			$this->load->view('admin/product_report_prints',$data);

			
			$this->load->view('home/footer');
			
			
		}
		
	}

		
		public function stock_report_details($head=null,$start,$end,$one=null,$two=null,$th=null,$fo=null,$h=null)
		{
		
			$admin = $this->session->userdata('admin');
			$type = $this->session->userdata('type');

				if(empty($admin)){
					
					
					redirect('admin');
				}
	$data['type']=0;
	
	
	/*if($type == 3)
				{
					$data['all2']=$this->news_model->getMenuData($ware,$admin);
					$this->load->view('main/header2',$data);
				
				}
				else{
					*/
			$this->load->view('home/headar',$data);
					
				//}
		
	
		$data['start']=$start;
		$data['end']=$end;
		$data['head']=$head;
			$data['head2']=$h;
		$data["ch"]=array(
		
		$one,
		$two,
		$th,
		$fo,
		
		
		);
		
		

	$data['check']=1;
	$this->load->view('report/stock_by_value',$data);	
		
		
	$this->load->view('home/footer');

		

	
		
	}
	
		public function stock_summary_details($head=null,$start,$end){
		
			$admin = $this->session->userdata('admin');

				if(empty($admin)){
					
					
					redirect('admin');
				}
	$data['type']=0;
	$this->load->view('home/headar',$data);
	
	
		$data['start']=$start;
		$data['end']=$end;
		$data['head']=$head;
		
		

	$this->load->view('report/stock_by_summary',$data);	
		
		
	$this->load->view('home/footer');

		

	
		
	}
		
	public function stock_summary($head=null){
		
		
		$ware=$this->session->userdata('wire');
		$type=$this->session->userdata('type');
		$admin = $this->session->userdata('admin');

				if(empty($admin)){
					
					
					redirect('admin');
				}
		
	$data['type']=0;
	
	/*if($type == 3)
				{
					$data['all2']=$this->news_model->getMenuData($ware,$admin);
					$this->load->view('main/header2',$data);
				
				}
				else{
					*/
			$this->load->view('home/headar',$data);
					
				//}
	
	
	$this->load->helper('form');
	$this->load->library('form_validation');
	$this->form_validation->set_rules('start_date','start_date', 'required');
	$this->form_validation->set_rules('end_date','end_date', 'required');
		if($this->form_validation->run() === FALSE)
		{


			$data['start']=date('Y-m-d',strtotime('01-04-2016 '));
			$data['end']=date('Y-m-d');
			$data['head']=83;
		

		}
		else{
		
			$data['start']=$this->input->post('start_date');
			$data['end']=$this->input->post('end_date');
			$data['head']=$head;

			}
	
	$this->load->view('report/stock_by_summary',$data);	
		
		
	$this->load->view('home/footer');
	
		
	}	
		
		
		
		
		
		public function stock_report($head=null,$h=null){
		
		$admin = $this->session->userdata('admin');
		$ware=$this->session->userdata('wire');
		$type=$this->session->userdata('type');
		
		
				if(empty($admin))
					{

						redirect('admin');
						
					}
				
	$data['type']=0;
	
	/*if($type == 3)
				{
					$data['all2']=$this->news_model->getMenuData($ware,$admin);
					$this->load->view('main/header2',$data);
				
				}
				else{
					*/
			$this->load->view('home/headar',$data);
					
				//}
	
	

	$this->load->helper('form');
	$this->load->library('form_validation');
	$this->form_validation->set_rules('start_date','start_date', 'required');
	$this->form_validation->set_rules('end_date','end_date', 'required');
	
	if ($this->form_validation->run() === FALSE)
	{


		$data['start']=date('Y-m-d');
		$data['end']=date('Y-m-d');
		$data['check']=0;
		$data['head']=83;
		$data['head2']=0;
		$data["ch"]=array(
		
			1,
			2,
			3,
			4,
		
		
		);

	}
	else{
		
		$data['start']=$this->input->post('start_date');
		$data['end']=$this->input->post('end_date');
		$data['head']=$head;
		$data['head2']=$h;
		$data["ch"]=array(
		
		$this->input->post('open'),
		$this->input->post('pur'),
		$this->input->post('sale'),
		$this->input->post('close'),
		
		
		);
		
		

		$data['check']=1;
		
		
		
	}
	
	$config = array();
        $config["base_url"] = base_url() . "mains/stock_report";
        $config["total_rows"] = $this->report_model->all_count('invoice');
       $config["per_page"] = 1;
		$config['num_links'] = 5;
		$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'First';
        $config["uri_segment"] = 5;
		$config['last_link'] = 'LAST';
		$config['next_link'] = '...NEXT';
		$config['prev_link'] = 'PREV...';
		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';
		$config['anchor_class'] = 'class="number" ';
		$config['use_page_numbers'] = TRUE;
		
        $this->pagination->initialize($config);

        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        
		
		if($page > 1)
		{
		
			
			$page=($page -1) * $config["per_page"];
		}
		else{
			
			$page=0;
		}
	
	
	
	
	$this->load->view('report/stock_by_value',$data);	
		
		
	$this->load->view('home/footer');
	
		
		
	}
	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		public function income_statement(){
		
		
		//$ware=$this->session->userdata('wire');
		
		$data['type']=0;
		$data['ware']=$ware=$this->session->userdata('wire');
		
		$type=$this->session->userdata('type');
		$admin = $this->session->userdata('admin');
		
		
		/*if($type == 3)
				{
					$data['all2']=$this->news_model->getMenuData($ware,$admin);
					$this->load->view('main/header2',$data);
				
				}
				else{
					*/
					$this->load->view('home/headar',$data);
				//}

				
		//$this->load->view('main/header',$data);
	
	$this->load->helper('form');
	$this->load->library('form_validation');
	$this->form_validation->set_rules('start_date','start_date', 'required');
	$this->form_validation->set_rules('end_date','end_date', 'required');
	
	if ($this->form_validation->run() === FALSE)
	{

		$data['start']=date('Y-m-d');
		$data['end']=date('Y-m-d');

		
		$data['start_b']= date('Y-m-d',strtotime('01-04-2016'));
		$data['end_b']= date('Y-m-d',strtotime('01-04-2016'));
	}
	else{
		
		$data['start']=$this->input->post('start_date');
		$data['end']=$this->input->post('end_date');
		
		
		$data['start_b']= date('Y-m-d',strtotime('01-04-2016'));
		$data['end_b']= date('Y-m-d',strtotime('01-04-2016'));
		
	}
		
	
		
	$this->load->view('admin/income_statement',$data);
	$this->load->view('home/footer');
		
	}
		
		public function balance_sheet_details($id=null,$type=null,$s=null,$e=null)
		{
			
			$data['ware']=$ware=$this->session->userdata('wire');
		$type=$this->session->userdata('type');
		$admin=$this->session->userdata('admin');
		
		
		if(empty($admin))
			redirect('admin');

		$data['type']=0;
		/*if($type == 3)
				{
					$data['all2']=$this->news_model->getMenuData($ware,$admin);
					$this->load->view('main/header2',$data);
				
				}
				else{*/
					
			$this->load->view('home/headar',$data);
					
				//}
			
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('start_date','start_date', 'required');
	
	if ($this->form_validation->run() === FALSE)
	{


  


		if(!empty($s)){
			
			$data['start']= date('Y-m-d',strtotime($s));
			$data['end']= date('Y-m-d',strtotime($e));
			
		}
		else{
			
			$data['start']= date('Y-m-d',strtotime('01-04-2016'));
			$data['end']=date('Y-m-d');
			
			
			
			
			
		}

		

		
		
		$data['start_b']= date('Y-m-d',strtotime('01-03-2016'));
		$data['end_b']= date('Y-m-d',strtotime('01-03-2016'));
	}
	else{
		
		$data['start']=date('Y-m-d',strtotime('01-04-2016'));
		$data['end']=$this->input->post('start_date');
		
		
		$data['start_b']= date('Y-m-d',strtotime('01-04-2016'));
		$data['end_b']= date('Y-m-d',strtotime('01-04-2016'));
		
	}
			
			
			$data['id']=$id;
			$data['type']=$type;
			
			$this->load->view('admin/balance_sheet_details',$data);
			$this->load->view('home/footer');	
			
			
		}
		
		
		
		
		
		
		
		
		public function income_statement2()
	{
		
		$data['ware']=$ware=$this->session->userdata('wire');
		$type=$this->session->userdata('type');
		$admin=$this->session->userdata('admin');
		
		
		if(empty($admin))
			redirect('admin');

		$data['type']=0;
		/*if($type == 3)
				{
					$data['all2']=$this->news_model->getMenuData($ware,$admin);
					$this->load->view('main/header2',$data);
				
				}
				else{*/
					
			$this->load->view('home/headar',$data);
					
				//}
	
	$this->load->helper('form');
	$this->load->library('form_validation');
	$this->form_validation->set_rules('start_date','start_date', 'required');
	
	if ($this->form_validation->run() === FALSE)
	{

		$data['start']='2015-1-1';
		$data['end']=date('Y-m-d');

		
		$data['start_b']= date('Y-m-d',strtotime($data['start'] . ' - 1 year'));
		$data['end_b']= date('Y-m-d',strtotime($data['end'] . ' - 1 year'));
	}
	else{
		
		$data['start']='2015-1-1';
		$data['end']=$this->input->post('start_date');
		
		
		$data['start_b']= date('Y-m-d',strtotime($data['start'] . ' - 1 year'));
		$data['end_b']= date('Y-m-d',strtotime($data['end'] . ' - 1 year'));
		
	}
		
	
		
	$this->load->view('admin/income_statement2',$data);
	$this->load->view('home/footer');
	}
		
		
		
		public function balance_sheet_details_nav($id=null,$typss=null,$head,$start=null,$end=null)
			{
			
			$ware=$this->session->userdata('wire');
		$type=$this->session->userdata('type');
		$admin=$this->session->userdata('admin');
		
		$data['id']=$id;
			
			$data['head']=$head;
			
			
			
			
			
		if(empty($admin))
			redirect('admin');

		$data['type']=0;
		/*if($type == 3)
				{
					$data['all2']=$this->news_model->getMenuData($ware,$admin);
					$this->load->view('main/header2',$data);
				
				}
				else{*/
					
			$this->load->view('home/headar',$data);
					
				//}
			
			$data['type']=$typss;
			
			$data['start']=date('Y-m-d',strtotime($start));
			$data['end']=date('Y-m-d',strtotime($end));
		
		
		
			$this->load->view('admin/balance_sheet_details_nav',$data);
			$this->load->view('home/footer');
			
			}
			
			
		public function balance_sheet2(){
		
		$data['ware']=$ware=$this->session->userdata('wire');
		$type=$this->session->userdata('type');
		$admin=$this->session->userdata('admin');
		
		
		if(empty($admin))
			redirect('admin');

		$data['type']=0;
	/*	if($type == 3)
				{
					$data['all2']=$this->news_model->getMenuData($ware,$admin);
					$this->load->view('main/header2',$data);
				
				}
				else{
					*/
			$this->load->view('home/headar',$data);
					
				//}
	
	$this->load->helper('form');
	$this->load->library('form_validation');
	$this->form_validation->set_rules('start_date','start_date', 'required');
	
	if ($this->form_validation->run() === FALSE)
	{

		$data['start']='2015-1-1';
		$data['end']=date('Y-m-d');

		
		$data['start_b']= date('Y-m-d',strtotime($data['start'] . ' - 1 year'));
		$data['end_b']= date('Y-m-d',strtotime($data['end'] . ' - 1 year'));
	}
	else{
		
		$data['start']='2015-1-1';
		$data['end']=$this->input->post('start_date');
		
		
		$data['start_b']= date('Y-m-d',strtotime($data['start'] . ' - 1 year'));
		$data['end_b']= date('Y-m-d',strtotime($data['end'] . ' - 1 year'));
		
	}
		
	
		
	$this->load->view('admin/balance_sheet2',$data);
	$this->load->view('home/footer');	
		
	}
		
		
		
		
		
		public function trial_details($head,$type,$start=null,$end=null){
		
		$admin = $this->session->userdata('admin');
		
		$data['type']=0;
		
		$this->load->view('home/headar',$data);
	
	$this->load->helper('form');
	$this->load->library('form_validation');
	$this->form_validation->set_rules('start_date','start_date', 'required');
	$this->form_validation->set_rules('end_date','end_date', 'required');
	
	if ($this->form_validation->run() === FALSE)
	{

		$data['start']=$start;
		$data['end']=$end;

	}
	else{
		
		$data['start']=$this->input->post('start_date');
		$data['end']=$this->input->post('end_date');
		
	}
		
$data['assets']=$this->report_model->getTrialBalance('setting','id',$head);	
	$data['type']=$type;	
	$data['head']=$head;	
	$this->load->view('admin/trial_balance_details',$data);
	$this->load->view('home/footer');

		
	}
		public function trial_balance(){
		
		$ware=$this->session->userdata('wire');
		$type=$this->session->userdata('type');
		$admin=$this->session->userdata('admin');
		
		
		if(empty($admin))
			redirect('admin');

		$data['type']=0;
		/*if($type == 3)
				{
					$data['all2']=$this->news_model->getMenuData($ware,$admin);
					$this->load->view('main/header2',$data);
				
				}
				else{*/
					
			$this->load->view('home/headar',$data);
					
				//}
		
	
		
		//$this->load->view('main/header',$data);
	
	$this->load->helper('form');
	$this->load->library('form_validation');
	$this->form_validation->set_rules('start_date','start_date', 'required');
	$this->form_validation->set_rules('end_date','end_date', 'required');
	
	if ($this->form_validation->run() === FALSE)
	{

		$data['start']=date('Y-m-d');
		$data['end']=date('Y-m-d');

	}
	else{
		
		$data['start']=$this->input->post('start_date');
		$data['end']=$this->input->post('end_date');
		
	}
		
$data['assets']=$this->report_model->getTrialBalance('setting','head',0);	
		
	$this->load->view('admin/trial_balance',$data);
	$this->load->view('home/footer');		
		
		
	}
	
	
	
	
		
		public function service_ledger($ids=null,$types=null,$starts=null,$ends=null)
	{
		
		$ware=$this->session->userdata('wire');
		$type=$this->session->userdata('type');
		$admin=$this->session->userdata('admin');
		
		
		if(empty($admin))
			redirect('admin');

		$data['type']=0;

		
			
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('ledger_id','ledger_id', 'required');
		$this->form_validation->set_rules('start_date','start_date', 'required');
		$this->form_validation->set_rules('end_date','end_date', 'required');
	
	if ($this->form_validation->run() === FALSE)
	{	

	
			
			
			$data['type']=0;
		
			/*if($type == 3)
				{
					$data['all2']=$this->news_model->getMenuData($ware,$admin);
					$this->load->view('main/header2',$data);
				
				}
				else{
					*/
					$this->load->view('home/headar',$data);
				//}	
		
		
			
			$this->load->view('report/service_ledger');
			$this->load->view('home/footer');
		//}
		
		
		
		


	}
	else{
		
		$this->load->view('report/report_header2');
		
		
		$ledger=explode('*',$this->input->post('ledger_id'));
		$start_date=$this->input->post('start_date');
		$end_date=$this->input->post('end_date');
		
		
		$data['start_date']=$start_date;
		$data['end_date']=$end_date;
		
		
		
	$data['ledger_name']=$ledger[0];	
	$data['type']=$type;	
$data['all']=$this->report_model->getProductLedger('product','date',$ledger[1],$start_date,$end_date);



		
	$this->load->view('report/service_report_print',$data);	
		
		
	$this->load->view('home/footer');	
		
		
	}
		
		
		
		
		
	}
		
		
	public function report_ledger($ids=null,$types=null,$starts=null,$ends=null){
		
		$ware=$this->session->userdata('wire');
		$type=$this->session->userdata('type');
		$admin=$this->session->userdata('admin');
		
		
		if(empty($admin))
			redirect('admin');

		$data['type']=0;

		
			
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('ledger_id','ledger_id', 'required');
		$this->form_validation->set_rules('start_date','start_date', 'required');
		$this->form_validation->set_rules('end_date','end_date', 'required');
	
	if ($this->form_validation->run() === FALSE)
	{	

		
		if(!empty($ids)){
			
$this->load->view('report/report_header2');
		
		
		$start_date=$starts;
		$end_date=$ends;
		
		
		$data['start_date']=$start_date;
		$data['end_date']=$end_date;
		
		
		$data['debit']=$this->report_model->getBalance('product_trans','date',$start_date,$end_date,'dr',$ids,$admin);
		
		
		$data['credit']=$this->report_model->getBalance('product_trans','date',$start_date,$end_date,'cr',$ids,$admin);
		
		
		
		
		
		$type=$this->report_model->anyName('ledger','id',$ids,'type');
		
		
	$opening=$this->report_model->anyName('ledger','id',$ids,'opening_balance');
	
	
	$data['l_id']=$ids;

	
	$data['ledger_name']=$this->report_model->anyName('ledger','id',$ids,'ledger_title');
	

   
	
		if((int)$types == 1){
			
			$data['op']=$opening;
			$data['oc']=0;
			
			//$data['balance_bd']=$opening+($data['debit'] - $data['credit']);
		}
		else if((int)$types == 2){
			
		///$data['balance_bd']=$opening+($data['credit'] - $data['debit']);
	
		 $data['oc']=$opening;
			$data['op']=0;
		}
		
		
		
	$data['type']=$types;	
$data['all']=$this->report_model->getLedgerReport('product_trans','date',$start_date,$end_date,$ids,$admin);



		
	$this->load->view('report/ledger_report_print',$data);	
		
		
	$this->load->view('home/footer');	
	
	
	
	
	
	
	
	
	
		}
		else{
			$data['type']=0;
		
			/*if($type == 3)
				{
					$data['all2']=$this->news_model->getMenuData($ware,$admin);
					$this->load->view('main/header2',$data);
				
				}
				else{
					*/
					$this->load->view('home/headar',$data);
				//}	
		
		
			
			$this->load->view('report/report_header');
			
			$this->load->view('home/footer');
		}
		
		
		
		


	}
	else{
		
		$this->load->view('report/report_header2');
		
		
		$ledger=explode('*',$this->input->post('ledger_id'));
		$start_date=$this->input->post('start_date');
		$end_date=$this->input->post('end_date');
		
		
		$data['start_date']=$start_date;
		$data['end_date']=$end_date;
		// echo $data['start_date']."  f ".$data['end_date'];
		
		$data['debit']=$this->report_model->getBalance('product_trans','date',$start_date,$end_date,'dr',$ledger[1],$admin);
		
		
		$data['credit']=$this->report_model->getBalance('product_trans','date',$start_date,$end_date,'cr',$ledger[1],$admin);
		
		
		
		
		
		$type=$this->report_model->anyName('ledger','id',$ledger[1],'type');
		
		
	$opening=$this->report_model->anyName('ledger','id',$ledger[1],'opening_balance');
	
	
	$data['l_id']=$ledger[1];

	
	$data['ledger_name']=$ledger[0];


         



		if($type == 1){
			
			$data['op']=$opening;
			$data['oc']=0;
			
			//$data['balance_bd']=$opening+($data['debit'] - $data['credit']);
		}
		else if($type == 2){
			
		//$data['balance_bd']=$opening+($data['credit'] - $data['debit']);
	
		        $data['oc']=$opening;
			$data['op']=0;
		}
		
		
		
	$data['type']=$type;	
$data['all']=$this->report_model->getLedgerReport('product_trans','date',$start_date,$end_date,$ledger[1],$admin);



	
	$this->load->view('report/ledger_report_print',$data);	
		
		
	$this->load->view('home/footer');	
		
		
	}
		
		
		
		
		
	}	
		
		
		
		
	public function getCashPaymentAll()
	{
		
		
	
		
		$w=$this->session->userdata('wire');
		
		$col=null;
		$col2=null;
		$id=$_POST['v'];
		$type=$_POST['type'];
		
		
		
		
		$this->db->where('ware',$w);
		$this->db->where('type',$type);
		$this->db->where('invoice_id',0);
		$this->db->where('voucher',$id);
		$this->db->order_by('id','DESC');

		$info=$this->db->get('product_trans');
		
		
		
		
		
		$test=1;
		$response["posts"]= array();
		foreach($info->result_array() as $val)
				{
				

			$test=0;
				
	$post= array();
	$post["id"]= $val["id"];
	$post["date"]= $val["date"];
	
		$post["cheque_date"]= $val["cheque_date"];
	$post["cheque_no"]= $val["cheque_no"];
	
	
	
	if($type == 6)
		{
			
			$post["debit"]= $this->report_model->anyName('ledger','id',$val['dr'],'ledger_title');
	$post["credit"]= $this->report_model->anyName('ledger','id',192,'ledger_title');
		}
		else if($type == 7){
			
			
			$post["debit"]= $this->report_model->anyName('ledger','id',192,'ledger_title');
	$post["credit"]= $this->report_model->anyName('ledger','id',$val['cr'],'ledger_title');
		}
		else if($type == 10){
			
			
			$post["voucher_no"]= $val["voucher"];
			
			$post["type"]= $val["d_c"];
			$post["ledger"]=$this->report_model->anyName('ledger','id',$val["l_type"],'ledger_title');

		}
		else if($type == 8 || $type == 9){
			
			
			$post["debit"]= $this->report_model->anyName('ledger','id',$val['dr'],'ledger_title');
	$post["credit"]= $this->report_model->anyName('ledger','id',$val['cr'],'ledger_title');
		}
	
	$post["amount"]= $val["amount"];
	$post["description"]= $val["description"];
				
				array_push($response["posts"], $post);
				
				
				}
				
				
		if(!empty($test)){
			
	$this->db->where("ware", $w); 	
	$this->db->order_by("voucher", "DESC");
	$this->db->limit(1);
	$query = $this->db->get("product_trans");
	$row = $query->row();
			
			$data=array(
			
				"id" => 1,
				"v" => $row->voucher+1,
			
			);
			
			echo json_encode($data);
			
		}
		else{
			
			echo json_encode($response);
			
		}
				
				
	
					
				
		
		
		
		
				
		
		
	}	
	public function geTransJValue()
	{
		
		$id=$_POST['id'];
		$id2=$_POST['id2'];
		$fdate=$_POST['fdate'];
		$ldate=$_POST['ldate'];
		
		$data['all']=$this->report_model->getTransValue('product_trans',$fdate,$ldate,$id,$id2);
		
		
		
		$response["posts"]= array();
		foreach($data['all'] as $val)
		{

		
			$post= array();
			$post["id"]= $val["id"];
			$post["debit"]= $this->report_model->anyName('ledger','id',$val['dr'],'ledger_title');
			$post["credit"]= $this->report_model->anyName('ledger','id',$val["cr"],'ledger_title');
			$post["amount"]= $val["amount"];
			$post["date"]= $val["date"];
			$post["description"]= $val["description"];
				
				array_push($response["posts"], $post);
		
		
		
		}
		
		echo json_encode($response);
		
	}	
		
	public function daily_sale_report_print($invoice=null,$type=null,$sup){

	
	$data['type']=0;
	
		$this->load->view('home/headar',$data);
		
		
		
		$admin = $this->session->userdata('admin');
		
		
	$data['name']=$this->report_model->anyName('ledger','id',$sup,'ledger_title');
	$t=$this->report_model->anyName('ledger','id',$sup,'type');
	
	
	
	$de_am=$this->report_model->getBalance2('product_trans','',date('Y-m-d'),date('Y-m-d'),'dr',$sup);
	$cr_am=$this->report_model->getBalance2('product_trans','',date('Y-m-d'),date('Y-m-d'),'cr',$sup);
	
	$op=$this->report_model->anyName('ledger','id',$sup,'opening_balance');
	
	
	if((int)$t == 1)
		$data['closing']=$op+($de_am - $cr_am);
	else
		$data['closing']=$op+($cr_am - $de_am);
	
	$data['session']=$this->report_model->anyName('password','id',$admin,'user');
	
	
	
	$data['previous']=$this->report_model->getPreviousDue('invoice','supplier',$sup,'due','invoice !=',$invoice);
	
	
	
	
	$data['date']=$this->report_model->anyName('product_trans','invoice_id',$invoice,'date');
	
	
	$data['invoice']=$invoice;
	$data['type']=$type;
	
	
	$data['inv']=$this->report_model->getAll('invoice','invoice',$invoice);
	
	
	
	

		if($type == 5){
			
	$data['all']=$this->report_model->getInvoiceData('issu',$invoice);
		
	$this->load->view('report/daily_sale_report_view',$data);		
		
		
		
		}
		
		else if($type == 1 || $type == 2){
			
	$data['all']=$this->report_model->getInvoiceDataWOIssu('product',$invoice,'type',$type);
		
	$this->load->view('report/product_report_view',$data);		
			
			
		}
		else if($type == 3 || $type == 4 || $type == 12){
			
$data['all']=$this->report_model->getInvoiceDataWOIssu('product',$invoice,'type',$type);
	


	
	$this->load->view('report/product_report_view',$data);					
			
		}
		
		
		
		
		$this->load->view('home/footer');		
		
		
		
	}	
		
		
	}


 ?>