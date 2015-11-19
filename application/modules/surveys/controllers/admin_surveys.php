<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_surveys
 * ...
 * 
 * @package PenguinFW
 * @subpackage Survey
 * @version 1.0.0
 */
class Admin_surveys extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        $this->layout->set_layout("admin");

        $this->model_name = 'Survey';

        $this->lang->load('generate', lang_web());
        $this->lang->load('surveys', lang_web());

        $this->load->model('Survey');
        $this->load->model("Survey_question");
    }

    function index($cfn_id = 0)
    {

        // check permission
        $this->PG_ACL('r');

        // set title
        $this->layout->set_title(lang('Survey manager'));

        // get data
        $data = $this->_listView('index', $cfn_id);

        $data['total_records'] = $this->count_record;

        //save last url
        $this->session->set_flashdata('last_url', full_url());


        $this->parser->parse($this->router->class . '/index', $data);
    }

    private function _listView($action = 'index', $cfn_id = 0)
    {
        // set javascript to view
        $this->layout->set_javascript(array(
            'jquery.ui.core.min.js',
            'jquery.ui.datepicker.min.js'
        ));

        // set css to view
        $this->layout->set_rel(array(
            'jquery.ui.base.css',
            'jquery.ui.datepicker.css'
        ));

        // filter surveys
        // filter created from date
        $filter_from_date = $this->input->get('from_date');
        if($filter_from_date)
        {
            $this->paginator['where']['DATE(surveys.created) >='] = standar_date($filter_from_date, '-', '-');
        }

        // filter created end date
        $filter_to_date = $this->input->get('to_date');
        if($filter_to_date)
        {
            $this->paginator['where']['DATE(surveys.created) <='] = standar_date($filter_to_date, '-', '-');
        }

        //filter questions
        $filter_question = $this->input->get('survey_question_id');
        if($filter_question)
        {
            $this->paginator['where']['surveys.survey_question_id'] = $filter_question;

            //save question id to add or edit
            $this->session->set_flashdata('question_id', $filter_question);
        }


        // filter user name
        $filter_name = $this->input->get('survey_user_id');
        if($filter_name)
        {
            $this->paginator['where']['surveys.user_id'] = $filter_name;
        }

        // filter user result
        $filter_name = $this->input->get('survey_result');
        if($filter_name)
        {
            $this->paginator['where']['surveys.is_right'] = $filter_name;
        }

        //join with questions
        $this->paginator['leftjoin'] = array('survey_questions q' => 'surveys.survey_question_id=q.id',
            'survey_answers a' => 'surveys.survey_answer_id=a.id');
        $this->paginator['select'] = 'surveys.*, q.name as survey_question_id, a.name as survey_answer_id';


        // get Survey answer
        $survey_answers = $this->pagination(5);

        //get survey question 
        $questions = $this->Survey_question->find('all');

        //get survey answers
        $answerss = array();
        for($i = 0; $i < count($questions); $i++)
        {
            $answerss[$questions[$i]['id']] = $this->Survey->find('all', array(
                'from' => 'survey_answers',
                'where' => array('survey_question_id' => $questions[$i]['id']),
                    ));
        }

        //get Survey result
        $results[] = array('id' => 1, 'name' => "Right");
        $results[] = array('id' => 0, 'name' => "Wrong");

        //get survey user
        $options = array(
            'select' => "user_id, username",
            'groupby' => "user_id",
        );
        $users = $this->Survey->find("all", $options);


        // set data view
        return array(
            'list_views' => $survey_answers,
            'cfn_id' => $cfn_id,
            'questions' => $questions,
            'answerss' => $answerss,
            'users' => $users,
            'results' => $results,
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'View' => 'surveys/admin_surveys/view/',
            ),
            'pagination_link' => $this->getPaginationLink('/surveys/admin_surveys/' . $action . '/' . $cfn_id, 5)
        );
    }

}

?>