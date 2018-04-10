<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Order Controller
 *
 * @author Okyza Maherdy Prabowo
 */
class Order extends CI_Controller{

	function __construct()
    {
      parent::__construct();
	  $this->load->model('crud_tarif');
	  $this->load->model('crud_order');
	  $this->load->library('encrypt');
	  $this->load->library('email');
    }
    
    function createorder()
    {
        /*
        header("Access-Control-Allow-Origin: *");
        
        $key = pack("H*", "560d679e9b4db1121a54f3a16009f33a");
        $iv =  pack("H*", "75a74a0cfa1e56edcdc18bb605ed1b6a");

        //Now we receive the encrypted from the post, we should decode it from base64,
        $encrypted = base64_decode(file_get_contents("php://input"));
        $datas = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $encrypted, MCRYPT_MODE_CBC, $iv);

        $clean = preg_replace('/[^\PC\s]/u', '', $datas);
        
        $data = json_decode($clean);
        */
        echo True;
        
        /*
        $insertdata = array(
			'personPickup' => $data->email,
			'name' => md5($data->password),
            'email' => md5($data->password),
            'telepon' => md5($data->password),
            'name' => md5($data->password),
            'name' => md5($data->password),
		);
        
        
        if(!$this->crud_order->create('orders',$insertdata))
		{
                
        }
        
        else 
        {   
            echo "Email sudah terdaftar";
        }
        */
    }
    
    function requestpickup()
    {
        header("Access-Control-Allow-Origin: *");
    
        $key = pack("H*", "560d679e9b4db1121a54f3a16009f33a");
        $iv =  pack("H*", "75a74a0cfa1e56edcdc18bb605ed1b6a");

        //Now we receive the encrypted from the post, we should decode it from base64,
        $encrypted = base64_decode(file_get_contents("php://input"));
        $datas = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $encrypted, MCRYPT_MODE_CBC, $iv);

        $clean = preg_replace('/[^\PC\s]/u', '', $datas);
        
        $data = json_decode($clean);
        
        //echo "Sukses Order";
        $data = $this->crud_tarif->get_tarif();
        echo json_encode($data);
        //kirim notif email dan mqtt ke kurir
    }
    
    function get_tarif_order()
    {
        header("Access-Control-Allow-Origin: *");
    
        //echo "Sukses Order";
        $data['tarif'] = $this->crud_tarif->get_tarif();
        echo json_encode($data);
    }
    
    function status_order_by_customer()
    {
    
    }
    
    function status_order()
    {
        header("Access-Control-Allow-Origin: *");
        $data = json_decode(file_get_contents("php://input"));
        $status_delv_id = $data->id;
    
        //update masing masing step status_delv_id
        /*
        0 - Request -> dari user
        1 - On-Waiting -> admin pada saat tunggu respon terima dari kurir
        2 - PickUp -> dari kurir
        3 - Delivered -> dari kurir
        4 - Rejected -> dari kurir
        5 - Retour -> dari kurir
        6 - Retour Delivered -> dari kurir
        7 - Rejected Delivered -> dari kurir
        8 - Financial Acceptance -> admin  
        9 - Completed -> admin
        */
    
    }

	//show order data
	function index()
	{
		$data['order'] = $this->crud_order->get_data();
		$data['param'] = 'orders/show';
		//print_r($this->db->last_query());
		$this->load->view('home',$data);
	}
	
	function proses($id)
	{
		$longlat = current($this->crud_order->get_longlat($id));
		if($longlat->courier_id == '0')
		{
			$couriers = $this->crud_order->get_couriers();
		}
		else
		{
			$couriers = $this->crud_order->get_couriers($longlat->courier_id);
		}
		
		$this->load->library('googlemaps');
        $config['center'] = $longlat->longlat_pickup;
        $config['zoom'] = '15';
        $this->googlemaps->initialize($config);
		
		$key = 'SumApaLAp05';
		
		foreach($couriers as $courier)
		{
			$id = array(
				'order' => $longlat->order_id,
				'courier' => $courier->courier_id
			);
			$msg = "<div align='center'><center><b>".ucfirst($courier->nama)."</center><br><a class='btn btn-primary' href='".base_url()."order/take_curs/$id[order]?courier=$id[courier]'>Assign Me</a></div>";

			$marker = array();
			$marker['position'] = $courier->longlat;
			$marker['icon'] = base_url()."img/courier-2.png";
			$marker['infowindow_content'] = $msg;
			$this->googlemaps->add_marker($marker);
		}
		
		$circle = array();
		$circle['center'] = $longlat->longlat_pickup;
		$circle['radius'] = '500';
		$this->googlemaps->add_circle($circle);
		
        $marker = array();
        $marker['position'] = $longlat->longlat_pickup;
		$marker['icon'] = base_url()."img/Box-icon.png";
		$marker['infowindow_content'] = $longlat->nama;
        $this->googlemaps->add_marker($marker);
        $data['map'] = $this->googlemaps->create_map();
		//print_r($couriers);
		$data['param'] = 'maps/show';
        
		$this->load->view('home', $data);
	}
	
	function take_curs($id)
	{
		$data['courier_id'] =  $this->input->get('courier');
		$data['id'] = $id;
		
		$data2['status_delv_id'] = 1;
		$data2['order_id'] = $id;
		$this->crud_order->create('order_logs',$data2);
		
		$data1['status_delv_id'] = 1;
		$this->crud_order->update($id,'order_id',$data1,'orders');
		
		$get = current($this->crud_order->get_email($this->input->get('courier')));
		$order = current($this->crud_order->get_detail($id));
		
		$code = implode("/",$data);
		$key = 'POSkurir@email123';

		$string = $this->encrypt->encode($code, $key);
		$url = base64_encode($string);
		$url_param = rtrim($url, '=');
		
		$msg  = "<p>Hi <b>".$get->nama."</b>, ada customer yang ingin mengirim dokumen atau barang, <br><br>";
		$msg .= "Alamat PickUp : ".$order->alamat_pickup."<br><br>";
		$msg .= "Alamat Delivery : ".$order->alamat_delivery."<br><br>";
		$msg .= "Detail Barang : ".$order->detail_barang."<br><br>Tolong,<br><br>";
		$msg .= "klik ini bila menerima orderan <br> <a href='".base_url()."order/receive/".$url_param."'><button>Terima</button></a><br><br>";
		$msg .= "klik ini bila menolak orderan <br> <a href='".base_url()."order/reject/".$url_param."'><button>Tolak</button></a>";
		
		$config = array();
		 
		$config['charset'] = 'utf-8';
		$config['useragent'] = 'Codeigniter';
		$config['protocol']= "smtp";
		$config['mailtype']= "html";
		$config['smtp_host']= "ssl://smtp.gmail.com";
		$config['smtp_port']= "465";
		$config['smtp_timeout']= "5";
		$config['smtp_user']= "pos.smtp@gmail.com";
		$config['smtp_pass']= "sumapala";
		$config['crlf']="\r\n"; 
		$config['newline']="\r\n"; 
				
		$this->email->initialize($config);
		$this->email->from('pos.smtp@gmail.com','PT POS INDONESIA');  
		$this->email->to($get->email);
		$this->email->bcc('pos.smtp@gmail.com'); 
		$this->email->subject('POS Kurir');  
		$this->email->message($msg);  
		$this->email->send();
		
		$kurir = $this->input->get('courier');
		
		redirect("order/send_notif/$id?kurir=$kurir");
		
	}
	
	function send_notif($id)
	{
		$order = current($this->crud_order->get_detail($id));
		$delv = $this->crud_order->get_delivery($order->email_delivery);
		$pick = $this->crud_order->get_delivery($order->email_pickup);
		$get = current($this->crud_order->get_email($this->input->get('kurir')));
		
		//CUSTOMERS
		
		$msg2  = "<p>Ini adalah detail pengiriman barang dari POS KURIR, <br><br>";
		$msg2 .= "Nama Kurir : <b>".$get->nama."</b><br><br>";
		$msg2 .= "Nama Customer : <b>".$order->cust_name."</b><br><br>";
		$msg2 .= "Nama Pengirim : <b>".$pick->nama."</b><br><br>";
		$msg2 .= "Nama Penerima : <b>".$delv->nama."</b><br><br>";
		$msg2 .= "Alamat PickUp : ".$order->alamat_pickup."<br><br>";
		$msg2 .= "Alamat Delivery : ".$order->alamat_delivery."<br><br>";
		$msg2 .= "Detail Barang : ".$order->detail_barang."<br><br>";
		$msg2 .= "Status : ".$this->status($order->status_delv_id)."<br><br>";
		$msg2 .= "Terimakasih, telah menggunakan jasa POS Kurir Indonesia.";
		
		$config2 = array();
		 
		$config['charset'] = 'utf-8';
		$config['useragent'] = 'Codeigniter';
		$config['protocol']= "smtp";
		$config['mailtype']= "html";
		$config['smtp_host']= "ssl://smtp.gmail.com";
		$config['smtp_port']= "465";
		$config['smtp_timeout']= "5";
		$config['smtp_user']= "pos.smtp@gmail.com";
		$config['smtp_pass']= "sumapala";
		$config['crlf']="\r\n"; 
		$config['newline']="\r\n"; 
				
		$this->email->initialize($config);
		$this->email->from('pos.smtp@gmail.com','PT POS INDONESIA');  
		$this->email->to($order->email_pickup);
		$this->email->cc($order->email_delivery);
		$this->email->bcc('pos.smtp@gmail.com'); 
		$this->email->subject('POS Kurir');  
		$this->email->message($msg2);  
		$this->email->send();
		
		redirect("order");
		
	}
	
	function status($id)
	{
		switch($id)
		{
			case '0';
			$a = 'Request';
			break;
			
			case '1';
			$a = 'On Assignment';
			break;
			
			case '2';
			$a = 'On Waitting';
			break;
			
			case '3';
			$a = 'Pick Up';
			break;
			
			case '4';
			$a = 'Delivered';
			break;
			
			case '5';
			$a = 'Rejected';
			break;
			
			case '6';
			$a = 'Return';
			break;
			
			case '7';
			$a = 'Return Delivered';
			break;
			
			case '8';
			$a = 'Rejected Delivered';
			break;
			
			case '9';
			$a = 'Financial Acceptance';
			break;
			
			case '10';
			$a = 'Completed';
			break;
		}
		
		return $a;
	}
	
	function order_detail($id)
	{
		$kurir = current($this->crud_order->get_detail($id));
		
		if($kurir->courier_id == 0)
		{
			$data['order'] = $this->crud_order->get_detail($id);
			$data['delv'] = $this->crud_order->get_delivery($kurir->email_delivery);
			$data['pick'] = $this->crud_order->get_delivery($kurir->email_pickup);
		}
		else
		{
			$data['order'] = $this->crud_order->order_detail($id);
			$data['delv'] = $this->crud_order->get_delivery($kurir->email_delivery);
			$data['pick'] = $this->crud_order->get_delivery($kurir->email_pickup);
		}
		$data['param'] = 'orders/details';
		$this->load->view('home',$data);
	}
	
	function search()
	{
		if($this->input->post('status') == ' ')
		{
			redirect("order");
		}
		$data['stat'] = $this->input->post('status');
		$data['order'] = $this->crud_order->get_src($this->input->post('status'));
		$data['param'] = 'orders/show';
		$this->load->view('home',$data);
	}
	
	function reject($id)
	{
		$key = 'POSkurir@email123';
		
		$url_param = $id . str_repeat('=', strlen($id) % 4);
		$url = base64_decode($url_param);
		
		$code = explode("/",$this->encrypt->decode($url, $key));
		
		$order_id = $code[1];
		
		$data1['courier_id'] = $code[0];
		$data1['status_delv_id'] = 0;
		$this->crud_order->update($order_id,'order_id',$data1,'orders');
		
		
		echo TRUE;
	}
	
	function receive($id)
	{
		$key = 'POSkurir@email123';
		
		$url_param = $id . str_repeat('=', strlen($id) % 4);
		$url = base64_decode($url_param);
		
		$code = explode("/",$this->encrypt->decode($url, $key));
		
		$order_id = $code[1];
		
		$data['status_delv_id'] = 2;
		$data['order_id'] = $order_id;
		$this->crud_order->create('order_logs',$data);
		
		$data1['courier_id'] = $code[0];
		$data1['status_delv_id'] = 2;
		$this->crud_order->update($order_id,'order_id',$data1,'orders');
		
		echo TRUE;
	}
}