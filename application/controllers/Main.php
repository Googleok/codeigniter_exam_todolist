<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * todo 컨트롤러
 */
class Main extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('todo_m');
        $this->load->helper(array(
            'url',
            'date'
        ));
    }

    public function index()
    {
        $this->lists();
    }

    /*
     * todo 목록
     */
    public function lists()
    {
        $data['list'] = $this->todo_m->get_list();
        $this->load->view('todo/list_v', $data);
    }

    /*
     * todo 조회
     */
    public function view()
    {
        $id = $this->uri->segment(3);

        $data['views'] = $this->todo_m->get_view($id);

        $this->load->view('todo/view_v', $data);
    }

    /**
     * todo 입력
     */
    public function write()
    {
        if ($_POST) {
            $content = $this->input->post('content', TRUE);
            $created_on = $this->input->post('created_on', TRUE);
            $due_date = $this->input->post('due_date', TRUE);

            $this->todo_m->insert_todo($content, $created_on, $due_date);

            redirect('/main/lists/');

            exit();
        } else {
            $this->load->view('todo/write_v');
        }
    }

    /**
     * todo 삭제
     */
    public function delete()
    {
        // 게시물 번호에 해당하는 게시물 삭제
        $id = $this->uri->segment(3);
        $this->todo_m->delete_todo($id);
        redirect('/main/lists/');
    }
}