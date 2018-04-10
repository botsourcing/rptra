<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct()
    {
      parent::__construct();
	  $this->load->model('mvolunteer');
    }

	public function index()
	{
		$this->load->library('googlemaps');


		$vs = $this->mvolunteer->getAllVolunteer();

		$config['center'] = '-6.1751, 106.8650';
		$config['zoom'] = '10';
		$this->googlemaps->initialize($config);

		foreach($vs as $v)
		{
			$marker = array();
			$id['telegram'] = $v->KoordinatorTelegram;

			$msg = "<a href='".base_url()."index.php/Welcome/DetailAnswer/".$v->KoordinatorTelegram.">".ucfirst($v->KoordinatorName)."</a>";
			$msd = "<a href='index.php/Welcome/DetailAnswer/$id[telegram]'>".ucfirst($v->KoordinatorName)."</a>";
			$latlong = $v->KoordinatorLat.','.$v->KoordinatorLong;
			$marker['position'] = $latlong;
			$marker['infowindow_content'] = $msd;
			$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=V|9999FF|000000';
			$this->googlemaps->add_marker($marker);
		}

		$data['map'] = $this->googlemaps->create_map();
		$this->load->view('welcome_message', $data);
	}

	public function DetailAnswer($id)
	{
		$data['koordinator'] = $vs = $this->mvolunteer->getByVolunteerTelegramId($id);
		$data['answer'] = $this->mvolunteer->getSurveyResultsByUser($id);
		$this->load->view('detail', $data);
	}

	public function Home()
	{
		Header("Location: http://bot.sumapala.com/rptra");
	}

	public function getQuestionById($questionId)
	{
		header('Access-Control-Allow-Origin: *');
		$rq = $this->mvolunteer->getSurveyResults($questionId);
		header("Content-Type: application/json");
		// to json
		$responce->cols[] = array( 
            "id" => "", 
            "label" => "Topping", 
            "pattern" => "", 
            "type" => "string" 
        ); 
        $responce->cols[] = array( 
            "id" => "", 
            "label" => "Total", 
            "pattern" => "", 
            "type" => "number" 
        ); 
        foreach($rq as $cd) 
            { 
            $responce->rows[]["c"] = array( 
                array( 
                    "v" => $cd->Answer, 
                    "f" => null 
                ) , 
                array( 
                    "v" => (int)$this->mvolunteer->getAnswerParam($questionId, $cd->Answer), 
                    "f" => null 
                ) 
            ); 
            } 
 
        echo json_encode($responce); 


	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */