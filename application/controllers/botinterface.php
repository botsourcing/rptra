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
class Botinterface extends CI_Controller{

	function __construct()
    {
      parent::__construct();
      $this->load->model('mbotinterface');
    }

    public function Survey($id)
    {
    	$data['id'] = $id;
    	$this->load->view('survey',$data);
    }

    public function Thank()
    {
    	$data = $this->input->post();
    	
    	for ($i=1; $i < count($data); $i++) { 
    		$survey_item=
			   array(
			      'VolunteerTelegram' => $data[0] ,
			      'QuestionId' => $i,
			      'Answer' => $data[$i]
			);

			$this->db->insert('survey', $survey_item);
    	}

    	$this->load->view('thanksurvey');
    }

    
    
}