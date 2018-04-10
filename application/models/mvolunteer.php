<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of orderModel
 *
 * @author Temmy Rustandi Hidayat
 */
class Mvolunteer extends CI_Model
{

	function __construct()
    {
      parent::__construct();
	  
    }

	function getAllVolunteer()
	{
		$get = $this->db->get('koordinator');
		return $get->result();
	}

	function getByVolunteerTelegramId($id)
	{
		$this->db->select('*')
					->from('koordinator')
					->where('KoordinatorTelegram', $id);
				 
		$get = $this->db->get();
		
		if($get->num_rows() > 0)
        {
            return $get->result();
        }
        else
        {
            return 0;
        }
	}

	function getSurveyResults($questionId)
	{
		$this->db->select('*')
					->from('survey')
					->where('QuestionId', $questionId)
					->group_by('Answer');
				 
		$get = $this->db->get();
		
		if($get->num_rows() > 0)
        {
            return $get->result();
        }
        else
        {
            return 0;
        }
	}

	function getSurveyResultsByUser($telegramUser)
	{
		$this->db->select('*')
					->from('survey')
					->where('VolunteerTelegram', $telegramUser)
					->order_by('QuestionId');
				 
		$get = $this->db->get();
		
		if($get->num_rows() > 0)
        {
            return $get->result();
        }
        else
        {
            return 0;
        }
	}

	function getAnswerParam($questionId, $answerParam)
	{
		$this->db->select('*')
					->from('survey')
					->where('QuestionId', $questionId)
					->where('Answer', $answerParam);
				 
		$get = $this->db->get();
		
		if($get->num_rows() > 0)
        {
            return $get->num_rows();
        }
        else
        {
            return 0;
        }
	}

}