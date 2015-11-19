<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_music_reports
 * ...
 * 
 * @package PenguinFW
 * @subpackage Music
 * @version 1.0.0
 * 
 * @property Music_report_type      $Music_report_type
 * @property Music_report           $Music_report
 * @property Music                  $Music
 */
 
class Admin_music_reports extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Music_report';
        
        // layout
        $this->layout->set_layout('admin');
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('musics', lang_web());
            
        $this->load->model('Music_report');
    }
    
    /**
     * show list music
     * 
     * @param int $type_id 
     */
    public function index($type_id = 0)
    {
        // check permission
        $this->PG_ACL('r');

        // set title
        $this->layout->set_title(lang('Music report manager'));
        
        // type_id
        $type_id = ($this->input->post('type_id')) ? $this->input->post('type_id') : $type_id;
        
        if (!is_numeric($type_id) || $type_id == 0)
        {
            show_error(lang('Error params'));
        }
        
        // post data
        if ($this->input->post())
        {
            $orders = $this->input->post('order');
            
            foreach ($orders as $id => $weight)
            {
                $this->Music_report->update(array('weight' => $weight), array('id' => $id));
            }
            
            $this->session->set_flashdata('success_message', lang('Update order music success'));
            redirect("musics/admin_music_reports/index/$type_id");
        }
        
        // filter
        // filter music name
        $filter_name = $this->input->get('name');
        if ($filter_name)
        {
            $this->paginator['where']['m.name like'] = '%' . $filter_name . '%';
        }
        
        // get music on report
        // set pagination
        $this->paginator['select'] = 'rpt.*, m.name as music';
        $this->paginator['from'] = 'music_reports rpt';
        $this->paginator['join'] = array(
            'musics m' => 'm.id = rpt.music_id'
        );
        $this->paginator['where']['rpt.type_id'] = $type_id;
        $this->paginator['order'] = array('rpt.weight' => 'asc');
        
        $reports = $this->pagination(5);
        
        // set data
        $data = array(
            'reports' => $reports,
            'type_id' => $type_id,
                                    
            'pagination_link' => $this->getPaginationLink('/musics/admin_reports/index/' . $type_id, 5)
        );

        // set template
        $this->parser->parse($this->router->class . '/index', $data);
    }        
    
    /**
     * Add music to report
     * 
     * @param int $type_id 
     */
    public function add($type_id = 0)
    {
        // check permission
        $this->PG_ACL('w');

        // set title
        $this->layout->set_title(lang('Add music report'));
        
        // lib
        $this->load->model('Music');
        
        // type_id
        $type_id = ($this->input->post('type_id')) ? $this->input->post('type_id') : $type_id;
        
        if (!is_numeric($type_id) || $type_id == 0)
        {
            show_error(lang('Error params'));
        }
        
        // post data
        if ($this->input->post())
        {
            $music_ids = $this->input->post('listViewId');
            
            $totals = $this->input->post('total');
            
            $listens = $this->input->post('listen');
            $votes = $this->input->post('vote');
            $sms_votes = $this->input->post('sms_vote');
            
            if (!empty ($music_ids) && $type_id)
            {
                $i = 0;
                foreach ($music_ids as $music_id)
                {
                    $i ++; 

                    $report_save = array(
                        'music_id' => $music_id,
                        'type_id' => $type_id,
                        'total_count' => $totals[$music_id],
                        'listen_count' => $listens[$music_id],
                        'vote_count' => $votes[$music_id],
                        'sms_count' => $sms_votes[$music_id],
                        'weight' => $i
                    );
                    
                    $this->Music_report->create($report_save);
                }
                
                $this->session->set_flashdata('success_message', lang('Add music success'));
                redirect("musics/admin_music_reports/index/$type_id");
            }
        }
        
        // get limit
        $limit = 100;
        if ($this->input->get('limit'))
        {
            $limit = $this->input->get('limit');
        }
                
        // get music
        // get select
        $select = $this->_getSelectReport();
        
        $musics = $this->Music->find('all', array(            
            'select' => $select,
            'order' => array(
                'total' => 'desc'
            ),                
            'limit' => $limit
        ));
        
        $data = array(
            'musics' => $musics,
            'type_id' => $type_id
        );
        
        $this->parser->parse($this->router->class . '/add', $data);
    }
    
    /**
     * Add music to report
     * 
     * @param int $music_id
     * @param int $type_id 
     */
    public function add_music($music_id, $type_id)
    {
        // layout
        $this->layout->set_layout('empty');
        
        // check permission
        if (!$this->isACL('w'))
        {
            echo json_encode(array(
                'status' => 'error',
                'message' => lang('Not allow access')
            ));
            exit();
        }
        
        // lib
        $this->load->model('Music_report_type');
        $this->load->model('Music');
        
        // get report type
        $type = $this->Music_report_type->get(array('id' => $type_id));
        
        if (!$type)
        {
            echo json_encode(array(
                'status' => 'error',
                'message' => lang('Error prams')
            ));
            exit();
        }
        
        // get music
        // get select
        $select = $this->_getSelectReport();
        
        $music = $this->Music->get_select($select, array('id' => $music_id));
        
        if (!$music)
        {
            echo json_encode(array(
                'status' => 'error',
                'message' => lang('Error prams')
            ));
            exit();
        }
        
        // add to report
        $report_save = array(
            'music_id' => $music_id,
            'type_id' => $type_id,
            'total_count' => $music->total,
            'listen_count' => $music->listen_point,
            'vote_count' => $music->vote_point,
            'sms_count' => $music->sms_vote_point            
        );

        $this->Music_report->create($report_save);
        
        echo json_encode(array(
            'status' => 'success',
            'message' => lang('Add music to report is success')
        ));
        exit();
    }
    
    /**
     * clear report
     * 
     * @param int $type_id 
     */
    public function clear($type_id = 0)
    {
        // check permission
        $this->PG_ACL('d');
        
        if (!is_numeric($type_id) || $type_id == 0)
        {
            show_error(lang('Error params'));
        }
        
        // delete
        $this->Music_report->deleteRecord(array('type_id' => $type_id));
        
        $this->session->set_flashdata('success_message', lang('Clear music success'));
        redirect("musics/admin_music_reports/index/$type_id");
    }
    
    /**
     * Export data
     * 
     * @param int $type_id 
     */
    public function report($type_id = 0)
    {
        // check permission
        $this->PG_ACL('r');
        
        $this->layout->disable_layout();
        
        if (!is_numeric($type_id) || $type_id == 0)
        {
            show_error(lang('Error params'));
        }
                        
        // lib
        $this->load->model('Music_report_type');
        $this->load->library('Write_exel');
        
        // report type
        $report_type = $this->Music_report_type->get(array('id' => $type_id));
        
        if (!$report_type)
        {
            show_error(lang('Error params'));
        }
        
        // get report
        $reports = $this->Music_report->find('all', array(
            'select' => '
                rpt.weight as order_music, 
                m.name as music,
                rpt.total_count, 
                rpt.listen_count,
                rpt.vote_count,
                rpt.sms_count
            ',
            'from' => 'music_reports rpt',
            'join' => array(
                'musics m' => 'm.id = rpt.music_id'
            ),
            'where' => array(
                'rpt.type_id' => $type_id
            )
        ));
        
        // export
        $this->write_exel->write($reports, make_slug($report_type->name) . '_' . date('Y_m_d_H'));        
        exit();
    }
    
    /**
     * import vote for music
     */
    public function import_point()
    {
        // check permission
        $this->PG_ACL('w');
        
        // set title
        $this->layout->set_title(lang('Import vote'));
        
        // set javascript to view
        $this->layout->set_javascript(array(
            'jquery-ui.min.js',
            'ajaxupload.js',
            'musics/upload_import.js'            
        ));
        
        // process data
        if ($this->input->post())
        {
            // get link file
            $file = FPENGUIN . 'media/uploads/musics/' . $this->input->post('exel_file');
            
            // check file
            if (is_file($file))
            {
                // lib model
                $this->load->model('Music');
                // lib reader exel
                $this->load->library('Read_exel');
                // get exel content
                $exel_content = $this->read_exel->read($file);
                
                // insert vote to db
                foreach ($exel_content as $content)
                {
                    // get music id
                    $music_exel_id = (int) $content[0];
                    // get point sms
                    $sms_point = (int) $content[1];
                    
                    // add point to music
                    $this->Music->incrementField(array('id' => $music_exel_id), MUSIC_SMS_VOTE_COUNT, $sms_point);
                    $this->Music->incrementField(array('id' => $music_exel_id), MUSIC_SMS_VOTE_POINT, $sms_point);
                }
                // set flash
                $this->session->set_flashdata('success_message', lang('Import success'));
            } else 
            {
                $this->session->set_flashdata('error_message', lang('Import error'));
            }
            
            // redirect            
            redirect('musics/admin_music_reports/import_point');
        }
        
        $this->parser->parse($this->router->class . '/import_point', array(
            
        ));
    }
    
    /**
     * select point report
     * 
     * @return string
     */
    private function _getSelectReport()
    {
        // get total listen_point, vote_point, sms_vote_point
        $total_point = $this->Music->get_select('SUM(listen_point) AS t_listen, SUM(vote_point) AS t_vote, SUM(sms_vote_point) AS t_sms');
        $t_listen = $total_point->t_listen;
        $t_vote = $total_point->t_vote;
        $t_sms = $total_point->t_sms;
        
        // get music
        // get select
        $select = sprintf('id, name, listen_point, vote_point, sms_vote_point, username, 
            (listen_point*%d/%d + vote_point*%d/%d + sms_vote_point*%d/%d) as total', 
            ConstMusicGlobal::ListenPercent, $t_listen, 
            ConstMusicGlobal::VotePercent, $t_vote, 
            ConstMusicGlobal::SmsPercent, $t_sms
        );
        
        return $select;
    }
}
                
?>