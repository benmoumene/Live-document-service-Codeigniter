<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class User_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get user by user_id
     */
    function get_user($user_id)
    {
        return $this->db->get_where('users',array('user_id'=>$user_id))->row_array();
    }
    
    /*
     * Get all users count
     */
    function get_all_users_count()
    {
        $this->db->from('users');
        return $this->db->count_all_results();
    }
        
    /*
     * Get all users
     */
    function get_all_users($params = array())
    {
        $this->db->order_by('user_id', 'desc');
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
       // return $this->db->get('users')->result_array();
	     $this->db->select('users.user_id,users.username,users.password,users.fullname,users.email,users.status,users.user_group_id,user_group.name as groupname');
		
        $this->db->from('users');
        $this->db->join('user_group','users.user_group_id = user_group.user_group_id','inner');
        return $this->db->get()->result_array();
	   
    }
        
    /*
     * function to add new user
     */
    function add_user($params)
    {
        $this->db->insert('users',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update user
     */
    function update_user($user_id,$params)
    {
        $this->db->where('user_id',$user_id);
        return $this->db->update('users',$params);
    }
    
    /*
     * function to delete user
     */
    function delete_user($user_id)
    {
        return $this->db->delete('users',array('user_id'=>$user_id));
    }
    
    /**
    * resolve_user_login function.
    * 
    * @access public
    * @param mixed $username
    * @param mixed $password
    * @return bool true on success, false on failure
    */
    public function resolve_user_login($email, $password) {
		
		
		$query = $this->db->query("select * from users where (email='".$email."' OR username='".$email."') and password=md5('".$password."') ");

		return $admin = $query->row_array();
		
		
		
		
		
      
    }
    
    /**
    * get_user_id_from_email function.
    * 
    * @access public
    * @param mixed $email
    * @return int the user id
    */
    public function get_user_id_from_email($email) {
        $this->db->select('user_id');
        $this->db->from('users');
        $this->db->where('email', $email);
        return $this->db->get()->row('user_id');
    }
    /**
    * hash_password function.
    * 
    * @access public
    * @param mixed $password
    * @return string|bool could be a string on success, or bool false on failure
    */
    public function hash_password($password) {
        return md5($password);
    }
    /**
    * verify_password_hash function.
    * 
    * @access private
    * @param mixed $password
    * @param mixed $hash
    * @return bool
    */
    private function verify_password_hash($password, $hash) {
        if(md5($password) == $hash){
            return true;
        }else{
            return false;
        }
    }
}
