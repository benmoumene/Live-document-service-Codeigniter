<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Customer extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model');
        $this->load->model('Company_model');
        $this->load->model('Employee_model');
        $this->load->model('Document_model');
        
    } 

    /*
     * Listing of customers
     */
    function index()
    {
        /* $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('customer/index?');
        $config['total_rows'] = $this->Customer_model->get_all_customers_count();
        $this->pagination->initialize($config); */

        $data['customers'] = $this->Customer_model->get_all_customers($params);
        
        $data['_view'] = 'customer/index';
        $this->load->view('layouts/main',$data);
    }
    function profile($customer_id){
        $data['_view'] = 'customer/profile';
        $data['customer'] = $this->Customer_model->get_customer($customer_id);
        if(!$data['customer']){
            show_error('The customer you are trying to view does not exist.');
        }
        $data['companies'] = $this->Company_model->get_companies_by_customer_id($customer_id);
        $company_ids = array_unique(array_column($data['companies'], 'companyid'));
        $data['employees'] = $this->Employee_model->get_employees_by_company_ids($company_ids);
        $data['documents'] = $this->Document_model->get_documents_by_company_ids($company_ids);
        //echo "<pre>";print_r($data['documents']);exit;
        $this->load->view('layouts/main',$data);
    }

    /*
     * Adding a new customer
     */
    function add()
    {   
        if(!$this->auth->isAdd()){
            redirect('/');
        }
        $this->load->library('form_validation');

		$this->form_validation->set_rules('Customer_name','Customer Name','required|min_length[2]|max_length[60]|is_unique[customers.Customer_name]');
		
		if($this->form_validation->run())     
        {   
            $params = array(
				'Remarks' => $this->input->post('Remarks'),
				'Customer_name' => $this->input->post('Customer_name'),
				'Nationality' => $this->input->post('Nationality'),
				'email' => $this->input->post('email'),
				'mobile' => $this->input->post('mobile'),
				'IDcard' => $this->input->post('IDcard'),
				'Position' => $this->input->post('Position'),
            );
            
            $customer_id = $this->Customer_model->add_customer($params);
            redirect('customer/index');
        }
        else
        {            
            $data['_view'] = 'customer/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*
     * Editing a customer
     */
    function edit($customer_id)
    {   
        if(!$this->auth->isEdit()){
            redirect('/');
        }
        // check if the customer exists before trying to edit it
        $data['customer'] = $this->Customer_model->get_customer($customer_id);
        
        if(isset($data['customer']['customer_id']))
        {
            $this->load->library('form_validation');

			$this->form_validation->set_rules('Customer_name','Customer Name','required');
		
			if($this->form_validation->run())     
            {   
                $params = array(
					
					'Customer_name' => $this->input->post('Customer_name'),
					'Nationality' => $this->input->post('Nationality'),
					'Position' => $this->input->post('Position'),
					'mobile' => $this->input->post('mobile'),
					'IDcard' => $this->input->post('IDcard'),
					'email' => $this->input->post('email'),
					'Remarks' => $this->input->post('Remarks'),
                );

                $this->Customer_model->update_customer($customer_id,$params);            
                redirect('customer/index');
            }
            else
            {
                $data['_view'] = 'customer/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The customer you are trying to edit does not exist.');
    } 

    /*
     * Deleting customer
     */
    function remove($customer_id)
    {
        if(!$this->auth->isDelete()){
            redirect('/');
        }
    
	  
        $customer = $this->Customer_model->get_customer($customer_id);
        if(!isset($customer['customer_id'])){
            show_error('The customer you are trying to delete does not exist.');
        }
        else{
            $this->Customer_model->delete_customer($customer_id);  
        } 
        redirect('customer/index');
    }
    
}