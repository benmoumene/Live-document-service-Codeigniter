<?php
/*
 * Generated by CRUDigniter v3.2
 * www.crudigniter.com
 */



class Document_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /*
     * Get document by docid
     */
    public function get_document($docid)
    {

        $this->db->select('D.docid,D.docno,D.issuedate,D.expiredate,D.warndays,D.comapnyid,D.doctype,D.dtype,D.Remarks,CC.Name ');
        $this->db->from('documents AS D');
        $this->db->join('company AS CC', 'D.comapnyid=CC.companyid');
        $this->db->where('docid', $docid);
        $query = $this->db->get();
        $data = $query->row_array();
        require_once APPPATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

        if (!empty($data['issuedate'])) {
             $issue_date = \GeniusTS\HijriDate\Hijri::convertToHijri($data['issuedate'])->format('Y/m/d');
             $issue_date = date('d/m/Y', strtotime($issue_date));
             $data['issuedate'] = $issue_date;
        }
        else {
            $data['issuedate'] = "";
        }
        if (!empty($data['expiredate'])) {
            $expire_date = \GeniusTS\HijriDate\Hijri::convertToHijri($data['expiredate'])->format('Y-m-d');
            $expire_date = date('d/m/Y', strtotime($expire_date));
            $data['expiredate'] = $expire_date;
        }
        else {
            $data['expiredate'] = "";
        }

        return $data;

    }

    /*
     * Get all documents count
     */
    public function get_all_documents_count($value = null)
    {
        $this->db->from('documents');
        if (!empty($value)) {
            $this->db->like('docno', $value);
        }
        return $this->db->count_all_results();
    }

    /*
     * Get all documents count
     */
    public function get_expire_documents_count()
    {
        $this->db->from('documents');
        $this->db->where(array('expiredate is NOT '=> NULL, 'expiredate <=' => date('Y-m-d')));
		
        return $this->db->count_all_results();
    }

	
	

	  public function get_expire_documents_list($params = array())
    {

        $this->db->order_by('docid', 'desc');
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }
        //  return $this->db->get('documents')->result_array();

        $this->db->select('documents.docid,documents.docno,documents.issuedate ,documents.expiredate,documents.warndays,documents.comapnyid,documents.remarks,documents.doctype,documents.dtype,documents.dtype,doctype.name as docname,dcategory.name as category, company.name as compname');
        //  $this->db->select('company.companyid,company.Name,company.companyNo ,company.CompType,company.CompReg,company.Customer_id,customers.Customer_name as customer,employees.emp_name as manager, company.email,company.Managerid,comptypes.name as CTypeName');

        $this->db->from('documents');
        //$this->db->join('customers', 'company.customer_id = customers.customer_id');
        $this->db->join('doctype', 'documents.doctype = doctype.id', 'left');
        $this->db->join('dcategory', 'documents.dtype=dcategory.dtype', 'left');
        $this->db->join('company', 'documents.comapnyid=company.companyid', 'left');
	    $this->db->where('expiredate <=', date('Y-m-d'));
        $datas = $this->db->get()->result_array();

        require_once APPPATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
        foreach($datas as $k => $data) {
            $datas[$k]['issuedate'] = \GeniusTS\HijriDate\Hijri::convertToHijri($data['issuedate'])->format('d/m/Y');
            $datas[$k]['expiredate'] = \GeniusTS\HijriDate\Hijri::convertToHijri($data['expiredate'])->format('d/m/Y');
        }

        return $datas;

    }
	
	
	  public function get_expire_documents_list30($params = array())
    {

        $this->db->order_by('docid', 'desc');
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }
        //  return $this->db->get('documents')->result_array();

        $this->db->select('documents.docid,documents.docno,documents.issuedate ,documents.expiredate,documents.warndays,documents.comapnyid,documents.remarks,documents.doctype,documents.dtype,documents.dtype,doctype.name as docname,dcategory.name as category, company.name as compname');
        //  $this->db->select('company.companyid,company.Name,company.companyNo ,company.CompType,company.CompReg,company.Customer_id,customers.Customer_name as customer,employees.emp_name as manager, company.email,company.Managerid,comptypes.name as CTypeName');

        $this->db->from('documents');
        //$this->db->join('customers', 'company.customer_id = customers.customer_id');
        $this->db->join('doctype', 'documents.doctype = doctype.id', 'left');
        $this->db->join('dcategory', 'documents.dtype=dcategory.dtype', 'left');
        $this->db->join('company', 'documents.comapnyid=company.companyid', 'left');
        $this->db->where(array(
            'expiredate is not ' => NULL, 
            'expiredate <= ' => 'DATE_ADD(CURDATE(), INTERVAL -30 DAY)'
        ));
        $datas = $this->db->get()->result_array();

        require_once APPPATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
        foreach($datas as $k => $data) {
            $datas[$k]['issuedate'] = \GeniusTS\HijriDate\Hijri::convertToHijri($data['issuedate'])->format('d/m/Y');
            $datas[$k]['expiredate'] = \GeniusTS\HijriDate\Hijri::convertToHijri($data['expiredate'])->format('d/m/Y');
        }

        return $datas;

    }
	
	
	
	  public function get_expire_documents_list60($params = array())
    {

        $this->db->order_by('docid', 'desc');
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }
        //  return $this->db->get('documents')->result_array();

        $this->db->select('documents.docid,documents.docno,documents.issuedate ,documents.expiredate,documents.warndays,documents.comapnyid,documents.remarks,documents.doctype,documents.dtype,documents.dtype,doctype.name as docname,dcategory.name as category, company.name as compname');
        //  $this->db->select('company.companyid,company.Name,company.companyNo ,company.CompType,company.CompReg,company.Customer_id,customers.Customer_name as customer,employees.emp_name as manager, company.email,company.Managerid,comptypes.name as CTypeName');

        $this->db->from('documents');
        //$this->db->join('customers', 'company.customer_id = customers.customer_id');
        $this->db->join('doctype', 'documents.doctype = doctype.id', 'left');
        $this->db->join('dcategory', 'documents.dtype=dcategory.dtype', 'left');
        $this->db->join('company', 'documents.comapnyid=company.companyid', 'left');
        
        $this->db->where(array(
            'expiredate is not ' => NULL, 
            'expiredate <= ' => 'DATE_ADD(CURDATE(), INTERVAL -60 DAY)'
        ));

        $datas = $this->db->get()->result_array();

        require_once APPPATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
        foreach($datas as $k => $data) {
            $datas[$k]['issuedate'] = \GeniusTS\HijriDate\Hijri::convertToHijri($data['issuedate'])->format('d/m/Y');
            $datas[$k]['expiredate'] = \GeniusTS\HijriDate\Hijri::convertToHijri($data['expiredate'])->format('d/m/Y');
        }

        return $datas;

    }
	
    /*
     * Get all documents
     */
    public function get_all_documents($params = array())
    {

        $this->db->order_by('docid', 'desc');
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }
        //  return $this->db->get('documents')->result_array();

        $this->db->select('documents.docid,documents.docno,documents.issuedate ,documents.expiredate,documents.warndays,documents.comapnyid,documents.remarks,documents.doctype,documents.dtype,documents.dtype,doctype.name as docname,dcategory.name as category, company.name as compname');
        //  $this->db->select('company.companyid,company.Name,company.companyNo ,company.CompType,company.CompReg,company.Customer_id,customers.Customer_name as customer,employees.emp_name as manager, company.email,company.Managerid,comptypes.name as CTypeName');

        $this->db->from('documents');
        //$this->db->join('customers', 'company.customer_id = customers.customer_id');
        $this->db->join('doctype', 'documents.doctype = doctype.id', 'inner');
        $this->db->join('dcategory', 'documents.dtype=dcategory.dtype', 'inner');
        $this->db->join('company', 'documents.comapnyid=company.companyid', 'inner');
        $datas = $this->db->get()->result_array();

        require_once APPPATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
        foreach($datas as $k => $data) {
            $issue_date = $data['issuedate'];
            if (!empty($issue_date)) {
                $datas[$k]['issuedate'] = \GeniusTS\HijriDate\Hijri::convertToHijri($issue_date)->format('d/m/Y');
            }
            $expire_date = $data['expiredate'];
            if (!empty($expire_date)) {
                $datas[$k]['expiredate'] = \GeniusTS\HijriDate\Hijri::convertToHijri($expire_date)->format('d/m/Y');
            }
        }

        return $datas;

    }

    public function get_documents_by_company_ids($company_ids = [])
    {
        if (!$company_ids) {
            return [];
        }
        $this->db->select('documents.*, company.companyid as company_id,company.Name AS company_name,doctype.name AS doctype_name, DA.*');
        $this->db->from('documents');
        $this->db->where_in('comapnyid', $company_ids);
        $this->db->join('company', 'company.companyid=documents.comapnyid', 'left');
        $this->db->join('doctype', 'doctype.id=documents.doctype', 'left');
        $this->db->join('documents_attachment AS DA','DA.FK_DocID = documents.docid','left');
        return $this->db->get()->result_array();
    }

    /*
     * function to add new document
     */
    public function add_document($params)
    {
        $this->db->insert('documents', $params);
        return $this->db->insert_id();
    }

    /*
     * function to update document
     */
    public function update_document($docid, $params)
    {
        $this->db->where('docid', $docid);
        return $this->db->update('documents', $params);
    }

    /*
     * function to delete document
     */
    public function delete_document($docid)
    {
        return $this->db->delete('documents', array('docid' => $docid));
    }

    public function count_important()
    {
        $this->db->from('documents');
        $this->db->where(array(
            'expiredate is not ' => NULL, 
            'expiredate <= ' => 'CURDATE()'
        ));

        return $this->db->count_all_results();
    }

    public function count_warning()
    {
        $this->db->from('documents');
        $this->db->where(array(
            'expiredate is not ' => NULL, 
            'expiredate <= ' => 'DATE_ADD(CURDATE(), INTERVAL 30 DAY)'
        ));
        return $this->db->count_all_results();
    }

    public function count_information()
    {
        $this->db->from('documents');
        $this->db->where(array(
            'expiredate is not ' => NULL, 
            'expiredate <= ' => 'DATE_ADD(CURDATE(), INTERVAL 60 DAY)'
        ));
        return $this->db->count_all_results();
    }
}
