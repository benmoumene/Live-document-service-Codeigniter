<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Employee extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Employee_model');
    } 

    /*
     * Listing of employees
     */
    function index()
    {
       /* $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('employee/index?');
        $config['total_rows'] = $this->Employee_model->get_all_employees_count();
        $this->pagination->initialize($config); */

        $data['employees'] = $this->Employee_model->get_all_employees($params);
        
        $data['_view'] = 'employee/index';
        $this->load->view('layouts/main',$data);
    }

    /*
     * Adding a new employee
     */
    function add()
    {   if(!$this->auth->isAdd()){
            redirect('/');
        }
        $this->load->library('form_validation');
        $data=array();
		$data['err_companyid']="";
		$this->form_validation->set_rules('email','Email','valid_email');
		$this->form_validation->set_rules('emp_name','Employee Name','required|min_length[2]|max_length[60]|is_unique[employees.emp_name]');
		$this->form_validation->set_rules('Ctype','Ctype','required');
		$this->form_validation->set_rules('companyid','Companyid','required');
		$companyid=$this->input->post('companyid');
		
		if((empty($companyid))&&($_POST)){
			
			$data['err_companyid']="There is no companies, please Add a company first";
		}
		
		
		if($this->form_validation->run())     
        {  


				$comapnyid=$this->input->post('companyid');
				$filess = $this->db->get_where('company', array('Name' =>$comapnyid))->row_array();

				if(!empty($filess)){ 


						$params = array(
							'Remarks' => $this->input->post('Remarks'),
							'Ctype' => $this->input->post('Ctype'),
							'emp_name' => $this->input->post('emp_name'),
							'companyid' => $filess['companyid'],
							'email' => $this->input->post('email'),
							'mobile' => $this->input->post('mobile'),
							'Nationality' => $this->input->post('Nationality'),
							'position' => $this->input->post('position'),
						);
						
						$employee_id = $this->Employee_model->add_employee($params);
			
				}
            redirect('employee/index');
        }
        else
        {
			$this->load->model('Emptype_model');
			$data['all_emptypes'] = $this->Emptype_model->get_all_emptypes();
            
			$this->load->model('Company_model');
			$data['all_company'] = $this->Company_model->get_all_company();
			
			$data['_view'] = 'employee/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*
     * Editing a employee
     */
    function edit($employee_id)
    {   
        if(!$this->auth->isEdit()){
            redirect('/');
        }
        // check if the employee exists before trying to edit it
		    $data=array();
        $data['employee'] = $this->Employee_model->get_employee($employee_id);
		
	/* 	echo"<pre>";
		print_r($data['employee']);
		exit();
      */
		$data['err_companyid']="";
		$companyid=$this->input->post('companyid');
		
		if((empty($companyid))&&($_POST)){
			
			$data['err_companyid']="There is no companies, please Add a company first";
		}		

		
        if(isset($data['employee']['employee_id']))
        {
            $this->load->library('form_validation');

			//$this->form_validation->set_rules('email','Email','valid_email');
			$this->form_validation->set_rules('emp_name','Emp Name','required');
			$this->form_validation->set_rules('Ctype','Ctype','required');
			$this->form_validation->set_rules('companyid','companyid','required');
			if($this->form_validation->run())     
            {   
                
				
		        $comapnyid=$this->input->post('companyid');
				$filess = $this->db->get_where('company', array('Name' =>$comapnyid))->row_array();

				if(!empty($filess)){ 			
				
				
				
				
				
				$params = array(
					'Remarks' => $this->input->post('Remarks'),
					'Ctype' => $this->input->post('Ctype'),
					'emp_name' => $this->input->post('emp_name'),
					'companyid' => $filess['companyid'],
					'email' => $this->input->post('email'),
					'mobile' => $this->input->post('mobile'),
					'Nationality' => $this->input->post('Nationality'),
					'position' => $this->input->post('position'),
                );

                $this->Employee_model->update_employee($employee_id,$params); 
				}				
                redirect('employee/index');
            }
            else
            {
				$this->load->model('Emptype_model');
				$data['all_emptypes'] = $this->Emptype_model->get_all_emptypes();

				$this->load->model('Company_model');
				$data['all_company'] = $this->Company_model->get_all_company();
				
                $data['_view'] = 'employee/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The employee you are trying to edit does not exist.');
    } 

    /*
     * Deleting employee
     */
    function remove($employee_id)
    {
        if(!$this->auth->isDelete()){
            redirect('/');
        }
        $employee = $this->Employee_model->get_employee($employee_id);

        // check if the employee exists before trying to delete it
        if(isset($employee['employee_id']))
        {
            $this->Employee_model->delete_employee($employee_id);
            redirect('employee/index');
        }
        else
            show_error('The employee you are trying to delete does not exist.');
    }
    
}
