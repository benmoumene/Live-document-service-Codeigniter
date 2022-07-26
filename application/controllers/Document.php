<?php

/*
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */


class Document extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Document_model');
    }

    /*
     * Listing of documents
     */
    function index()
    {
       /* $params['limit'] = RECORDS_PER_PAGE;
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;

        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('document/index?');
        $config['total_rows'] = $this->Document_model->get_all_documents_count();
        $this->pagination->initialize($config); */

        $data['documents'] = $this->Document_model->get_all_documents($params);

        $data['_view'] = 'document/index';
        $this->load->view('layouts/main', $data);
    }


	
	function expired()
    {
        $params['limit'] = RECORDS_PER_PAGE;
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;

        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('document/expired?');
        $config['total_rows'] = $this->Document_model->get_expire_documents_count();
        $this->pagination->initialize($config);

        $data['documents'] = $this->Document_model->get_expire_documents_list($params);

        $data['_view'] = 'document/expired';
        $this->load->view('layouts/main', $data);
    }
	
	
	function expired30()
    {
        $params['limit'] = RECORDS_PER_PAGE;
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;

        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('document/expired30?');
        $config['total_rows'] = $this->Document_model->count_warning();
        $this->pagination->initialize($config);

        $data['documents'] = $this->Document_model->get_expire_documents_list30($params);

        $data['_view'] = 'document/expired30';
        $this->load->view('layouts/main', $data);
    }
	
	
	function expired60()
    {
        $params['limit'] = RECORDS_PER_PAGE;
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;

        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('document/expired60?');
        $config['total_rows'] = $this->Document_model->count_information();
        $this->pagination->initialize($config);

        $data['documents'] = $this->Document_model->get_expire_documents_list60($params);

        $data['_view'] = 'document/expired60';
        $this->load->view('layouts/main', $data);
    }
	
	
    function delete_brand_images()
    {

        $a_href = $this->input->post('a_href');
        if (!empty($a_href)) {

            $attachment = $this->db->get_where('documents_attachment', array('PK_MediaID' => $a_href))->row_array();

            $this->db->where('PK_MediaID', $a_href);
            $this->db->delete('documents_attachment');

            $file = './' . $attachment['attach'];

            if (file_exists($file)) {

                unlink($file);

            }

        }

    }


    /*
     * Adding a new document
     */
    function add()
    {
        if (!$this->auth->isAdd()) {
            redirect('/');
        }
        $this->load->library('form_validation');


        $this->form_validation->set_rules('doctype', 'Doctype', 'required');
        $this->form_validation->set_rules('dtype', 'Dtype', 'required');
        $this->form_validation->set_rules('comapnyid', 'Comapnyid', 'required');

        if ($this->form_validation->run()) {

            $_issue_date = $this->input->post('issuedate');
            if (isset($_issue_date) && !empty($_issue_date)) {
                // get hijri date
                $issuedate = date('Y-m-d', strtotime(str_replace('/', '-', $_issue_date)));
            }

            $_expire_date = $this->input->post('expiredate');
            if (isset($_expire_date) && !empty($_expire_date)) {
                $expiredate = date('Y-m-d', strtotime(str_replace('/', '-', $_expire_date)));
            }

            // require lib to convert hijir to Gregorian
            require_once APPPATH . 'vendor' . DIRECTORY_SEPARATOR .'autoload.php';

            if (!empty($issuedate)) {
                // convert issuedate from hijri to Gregorian
                $issuedate = explode('-', $issuedate);
                $issuedate = \GeniusTS\HijriDate\Hijri::convertToGregorian($issuedate[2], $issuedate[1], $issuedate[0])->toDateString();
            }

            if ($expiredate) {
                // convert expiredate from hijri to Gregorian
                $expiredate = explode('-', $expiredate);
                $expiredate = \GeniusTS\HijriDate\Hijri::convertToGregorian($expiredate[2], $expiredate[1], $expiredate[0])->toDateString();
            }


            /*// Attach_File_To_Customer
            $filess = array();
            $dtype = $this->input->post('dtype');
            $comapnyid = $this->input->post('comapnyid');
            if ($dtype == 1) {
                $filess = $this->db->get_where('customers', array('Customer_name' => $comapnyid))->row_array();
            }
            else {
                $filess = $this->db->get_where('company', array('Name' => $comapnyid))->row_array();
            }*/

            $comapnyid = $this->input->post('comapnyid');
            $filess = $this->db->get_where('company', array('Name' => $comapnyid))->row_array();


            if (!empty($filess)) {

                /* 		 echo"<pre>";
                         print_r($filess);
                         exit(); */

                $params = array(
                    'Remarks' => $this->input->post('Remarks'),
                    'comapnyid' => $filess['companyid'],
                    'doctype' => $this->input->post('doctype'),
                    'dtype' => $this->input->post('dtype'),
                    'docno' => $this->input->post('docno'),
                    'issuedate' => $issuedate,
                    'expiredate' => $expiredate,
                    'warndays' => $this->input->post('warndays'),
                );

                $document_id = $this->Document_model->add_document($params);
                $files = $this->input->post('files');
                $path = $this->input->post('path');

                if (!empty($path)) {


                    $extension = $this->input->post('extension');
                    $date = $this->input->post('date');
                    $orginal = $this->input->post('orginal');
                    $type = $this->input->post('type');

                    $count = count($files);

                    for ($x = 0; $x < $count; $x++) {
                        //echo "The number is: $x <br>";

                        $datas = array(
                            'FK_DocID' => $document_id,
                            'Path' => $path[$x],
                            'filename' => $files[$x],
                            'attach' => $orginal[$x],
                            'extension' => $extension[$x],
                            'date' => $date[$x],
                            'type' => $type[$x],
                        );


                        $this->db->insert('documents_attachment', $datas);

                    }


                }

            }


            redirect('document/index');
        } else {
            $this->load->model('Company_model');
            $data['all_company'] = $this->Company_model->get_all_company();

            $this->load->model('Doctype_model');
            $data['all_doctype'] = $this->Doctype_model->get_all_doctype();

            $this->load->model('Dcategory_model');
            $data['all_dcategory'] = $this->Dcategory_model->get_all_dcategory();

            $data['_view'] = 'document/add';
            $this->load->view('layouts/main', $data);
        }
    }

    /*
     * Editing a document
     */
    function edit($docid)
    {
        if (!$this->auth->isEdit()) {
            redirect('/');
        }
        // check if the document exists before trying to edit it
        $data['document'] = $this->Document_model->get_document($docid);
        /* 	echo"<pre>";
            print_r($data['document'] );
            exit(); */

        $data['attachment'] = $this->db->get_where('documents_attachment', array('FK_DocID' => $docid))->result_array();

        if (isset($data['document']['docid'])) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('doctype', 'Doctype', 'required');
            $this->form_validation->set_rules('dtype', 'Dtype', 'required');
            $this->form_validation->set_rules('comapnyid', 'Comapnyid', 'required');

            if ($this->form_validation->run()) {
                require_once APPPATH . 'vendor' . DIRECTORY_SEPARATOR .'autoload.php';

                $issuedate = $this->input->post('issuedate');
                if (!empty($issuedate)) {
                    $issuedate = date('Y-m-d', strtotime(str_replace('/', '-', $issuedate)));

                    // convert issuedate from hijri to Gregorian
                    $issuedate = explode('-', $issuedate);
                    $issuedate = \GeniusTS\HijriDate\Hijri::convertToGregorian($issuedate[2], $issuedate[1], $issuedate[0])->toDateString();
                }
                else {
                    $issuedate = NULL;
                }
                
                $expiredate = $this->input->post('expiredate');
                if (!empty($expiredate)) {
                    $expiredate = date('Y-m-d', strtotime(str_replace('/', '-', $expiredate)));

                    // convert expiredate from hijri to Gregorian
                    $expiredate = explode('-', $expiredate);
                    $expiredate = \GeniusTS\HijriDate\Hijri::convertToGregorian($expiredate[2], $expiredate[1], $expiredate[0])->toDateString();
                }
                else {
                    $expiredate = NULL;
                }

                /*// Attach_File_To_Customer
                $filess = array();
                $dtype = $this->input->post('dtype');
                $comapnyid = $this->input->post('comapnyid');
                if ($dtype == 1) {
                    $filess = $this->db->get_where('customers', array('Customer_name' => $comapnyid))->row_array();
                }
                else {
                    $filess = $this->db->get_where('company', array('Name' => $comapnyid))->row_array();
                }*/
		
		
                $comapnyid = $this->input->post('comapnyid');
                $filess = $this->db->get_where('company', array('Name' => $comapnyid))->row_array();


                if (!empty($filess)) {
                    $params = array(
                        'Remarks' => $this->input->post('Remarks'),
                        'comapnyid' => $filess['companyid'],
                        'doctype' => $this->input->post('doctype'),
                        'dtype' => $this->input->post('dtype'),
                        'docno' => $this->input->post('docno'),
                        'issuedate' => $issuedate,
                        'expiredate' => $expiredate,
                        'warndays' => $this->input->post('warndays'),
                    );

                    $this->Document_model->update_document($docid, $params);


                    $files = $this->input->post('files');
                    $path = $this->input->post('path');


                    if (!empty($path)) {


                        $extension = $this->input->post('extension');
                        $date = $this->input->post('date');
                        $orginal = $this->input->post('orginal');
                        $type = $this->input->post('type');

                        $count = count($files);

                        for ($x = 0; $x < $count; $x++) {
                            //echo "The number is: $x <br>";

                            $datas = array(
                                'FK_DocID' => $docid,
                                'Path' => $path[$x],
                                'filename' => $files[$x],
                                'attach' => $orginal[$x],
                                'extension' => $extension[$x],
                                'date' => $date[$x],
                                'type' => $type[$x],
                            );


                            $this->db->insert('documents_attachment', $datas);

                        }


                    }

                }


                redirect('document/index');
            } else {
                $this->load->model('Company_model');
                $data['all_company'] = $this->Company_model->get_all_company();

                $this->load->model('Doctype_model');
                $data['all_doctype'] = $this->Doctype_model->get_all_doctype();

                $this->load->model('Dcategory_model');
                $data['all_dcategory'] = $this->Dcategory_model->get_all_dcategory();

                $data['_view'] = 'document/edit';
                $this->load->view('layouts/main', $data);
            }
        } else
            show_error('The document you are trying to edit does not exist.');
    }

    /*
     * Deleting document
     */
    function remove($docid)
    {
        if (!$this->auth->isDelete()) {
            redirect('/');
        }
        $document = $this->Document_model->get_document($docid);

        // check if the document exists before trying to delete it
        if (isset($document['docid'])) {
            $this->Document_model->delete_document($docid);
            redirect('document/index');
        } else
            show_error('The document you are trying to delete does not exist.');
    }

}
