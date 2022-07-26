<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class User extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    } 

    /*
     * Listing of users
     */
    function index()
    {
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('user/index?');
        $config['total_rows'] = $this->User_model->get_all_users_count();
        $this->pagination->initialize($config);

        $data['users'] = $this->User_model->get_all_users($params);
        
        $data['_view'] = 'user/index';
        $this->load->view('layouts/main',$data);
    }

    /*
     * Adding a new user
     */
    function add()
    {   
        $this->load->library('form_validation');
$this->load->helper('date');

		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');
		$this->form_validation->set_rules('user_group_id','User Group Id','required');
		$this->form_validation->set_rules('email','Email','valid_emails');
		
		

		
		
		 $image_show="";
		
		
		if($this->form_validation->run())     
        {   
           



                            	$config['upload_path'] ='uploads';
                            	$config['allowed_types'] = 'gif|png|jpg|jpeg'; 	
                            	$this->load->library('upload', $config);
                            	if ($this->upload->do_upload('imageUpload')){                        	
                                            	
                            	
                            	$tt=$this->upload->data();
                            	$dat = array('image' =>$tt['file_name']);
                            	$thumbnail = $tt['file_name'];
                            	$this->load->library('image_lib');
                            	$image_base_path_thumb = "uploads/thumbs/";
                            	$config['image_library'] = 'gd2';
                            	$config['source_image'] ='uploads/'.$thumbnail;
                            	$config['new_image'] =  $image_base_path_thumb.$thumbnail;     
                            	//$config['create_thumb'] = TRUE; 
                            	$config['maintain_ratio'] = false;
                            	$config['width'] = '50';
                            	//$config['height'] = '69';
                            	$this->image_lib->initialize($config);
                            	$this->image_lib->resize();               	
                            	    			
				                $image_show=$thumbnail;
								}
								










		   $params = array(
				'status' => $this->input->post('status'),
				'addstatus' => $this->input->post('addstatus'),
				'editstatus' => $this->input->post('editstatus'),
				'delstatus' => $this->input->post('delstatus'),
				'user_group_id' => $this->input->post('user_group_id'),
				'password' => md5($this->input->post('password')),
				'username' => $this->input->post('username'),
				
				'fullname' => $this->input->post('fullname'),
				
				'email' => $this->input->post('email'),
				'image' => $image_show,
			
				'date_added' => Now(),
				
            );
            
		
	
			
            $user_id = $this->User_model->add_user($params);
            redirect('user/index');
        }
        else
        {
			$this->load->model('User_group_model');
			$data['all_user_group'] = $this->User_group_model->get_all_user_group();
            
            $data['_view'] = 'user/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*
     * Editing a user
     */
    function edit($user_id)
    {   
        // check if the user exists before trying to edit it
        $data['user'] = $this->User_model->get_user($user_id);
		
		


		
		
        
        if(isset($data['user']['user_id']))
        {
            
			
			
			
			$this->load->library('form_validation');
$image_show="";
			$this->form_validation->set_rules('username','Username','required');
			//$this->form_validation->set_rules('password','Password','required');
			$this->form_validation->set_rules('user_group_id','User Group Id','required');
			$this->form_validation->set_rules('email','Email','valid_emails');
		
			if($this->form_validation->run())     
            {   
                
				
				
				
	
                            	$config['upload_path'] ='uploads';
                            	$config['allowed_types'] = 'gif|png|jpg|jpeg'; 	
                            	$this->load->library('upload', $config);
                            	if ($this->upload->do_upload('imageUpload')){                        	
                                            	
                            	
                            	$tt=$this->upload->data();
                            	$dat = array('image' =>$tt['file_name']);
                            	$thumbnail = $tt['file_name'];
                            	$this->load->library('image_lib');
                            	$image_base_path_thumb = "uploads/thumbs/";
                            	$config['image_library'] = 'gd2';
                            	$config['source_image'] ='uploads/'.$thumbnail;
                            	$config['new_image'] =  $image_base_path_thumb.$thumbnail;     
                            	//$config['create_thumb'] = TRUE; 
                            	$config['maintain_ratio'] = false;
                            	$config['width'] = '50';
                            	//$config['height'] = '69';
                            	$this->image_lib->initialize($config);
                            	$this->image_lib->resize();               	
                            	    			
				                $image_show=$thumbnail;
								}
								else {
									
				                   $image_show= $this->input->post('image');
								}
				 $user = $this->session->user;
				
				$pass=$user['password'];
				$passwords=$this->input->post('password');
				if(!empty($passwords)){
					
					$pass=md5($this->input->post('password'));
				}

				
		
				
				
				
				
				
				
				
				
				$params = array(
					'status' => $this->input->post('status'),
					'addstatus' => $this->input->post('addstatus'),
					'editstatus' => $this->input->post('editstatus'),
					'delstatus' => $this->input->post('delstatus'),
					'user_group_id' => $this->input->post('user_group_id'),
					'password' => $pass,
					'username' => $this->input->post('username'),
				
					'fullname' => $this->input->post('fullname'),
					
					'email' => $this->input->post('email'),
					'image' => $image_show,
					
					'date_added' => $this->input->post('date_added'),
				
                );

                $this->User_model->update_user($user_id,$params);            
                redirect('user/index');
            }
            else
            {
				$this->load->model('User_group_model');
				$data['all_user_group'] = $this->User_group_model->get_all_user_group();

                $data['_view'] = 'user/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The user you are trying to edit does not exist.');
    } 

    /*
     * Deleting user
     */
    function remove($user_id)
    {
        $user = $this->User_model->get_user($user_id);

        // check if the user exists before trying to delete it
        if(isset($user['user_id']))
        {
            $this->User_model->delete_user($user_id);
            redirect('user/index');
        }
        else
            show_error('The user you are trying to delete does not exist.');
    }
    
}