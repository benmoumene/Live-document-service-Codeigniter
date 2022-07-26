<?php $base_url = base_url(); ?>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-lg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">البحث والاستعلام</h5>
        <button type="button" class="close lise_close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal_body">
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">البحث والاستعلام</h3>
      </div>
      <div class="box-body">
        <div class="col-md-12">

          <div class="navbar_form">
            <form id="search-form" class="navbar-form" action="<?php echo base_url(); ?>search" method="post" role="search">
              <div class="input-group add-on">
                <input class="form-control" placeholder="ادخل النص" value="<?php echo $this->input->post('search'); ?>" name="search" id="srch-term" type="text">
                <div class="input-group-btn">
                  <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="col-md-12">
          <h1 class="SearchResult">نتائج البحث</h1>
        </div>

        <div class="col-md-12">
          <div id="accordion" role="tablist" aria-multiselectable="false">
            <div class="card">
              <div class="card-header" role="tab" id="headingTwo1">
                <h5 class="mb-0">
                  <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo1" aria-expanded="false" aria-controls="collapseTwo1">
                    عميل
                  </a>
                  <span style="float:right">found <label>(<?php echo count(@$customers); ?>)</label></span>
                </h5>
              </div>
              <div id="collapseTwo1" class="collapse" role="tabpanel" aria-labelledby="headingTwo1">
                <div class="card-block">

                  <div class="row">
                    <div class="col-md-12">
                      <div class="box-body">
                        <table class="table table-striped">
                          <tr>
                            <th>رقم العميل</th>
                            <th>إسم العميل</th>
                            <th>الجنسية</th>
                            <th>البريد الالكتروني</th>
                            <th>الجوال</th>
                            <th>رقم الهوية</th>
                            <th>المنصب</th>
                            <th>العملية</th>
                          </tr>
                          <?php if (!empty($customers)) {
                            foreach ($customers as $c) { 
                              $customer_id = $c['customer_id'];
                              $format = "<td><a href='{$base_url}customer/profile/{$customer_id}'>%s</a></td>";    
                          ?>
                              <tr>
                                <?php echo sprintf($format, $c['customer_id']) ?>
                                <?php echo sprintf($format, $c['Customer_name']) ?>
                                <?php echo sprintf($format, $c['Nationality']) ?>
                                <?php echo sprintf($format, $c['email']) ?>
                                <?php echo sprintf($format, $c['mobile']) ?>
                                <?php echo sprintf($format, $c['IDcard']) ?>
                                <?php echo sprintf($format, $c['Position']) ?>
                                <td><a data-toggle="modal" data-listing="<table class='table'><tr><th>Customer ID</th><th>Customer Name</th><th>Nationality</th><th>Email</th><th>Mobile</th><th>ID Card</th><th>Position</th></tr><tr><td><?php echo $c['customer_id']; ?></td><td><?php echo $c['Customer_name']; ?></td><td><?php echo $c['Nationality']; ?></td><td><?php echo $c['email']; ?></td><td><?php echo $c['mobile']; ?></td><td><?php echo $c['IDcard']; ?></td><td><?php echo $c['Position']; ?></td></tr></table>" data-target="#exampleModal" class="Show_details">view</a></td>
                              </tr>
                          <?php }
                          } ?>
                        </table>
                      </div>

                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header" role="tab" id="headingTwo">
                <h5 class="mb-0">
                  <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    منشأة
                  </a>
                  <span style="float:right">found <label>(<?php echo count(@$company); ?>)</label></span>
                </h5>
              </div>
              <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                <div class="card-block">
                  <div class="box-body">
                    <table class="table table-striped">
                      <tr>
                        <th>الرقم</th>
                        <th>الاسم</th>
                        <th>نوع المنشأة</th>
                        <th>اسم العميل</th>
                        <!--    <th>Manager</th> -->
                        <th>رقم المنشأة</th>
                        <th>رقم التسجيل</th>
                        <th>العملية</th>

                      </tr>
                      <?php if (!empty($company)) {
                        foreach ($company as $c) { 
                          $company_id = $c['companyid'];
                          $format = "<td><a href='{$base_url}company/profile/{$company_id}'>%s</a></td>";    
                      ?>
                          <tr>
                            <?php echo sprintf($format, $c['companyid']) ?>
                            <?php echo sprintf($format, $c['Name']) ?>
                            <?php echo sprintf($format, $c['CTypeName']) ?>
                            <td>
                              <a href='<?php echo base_url(); ?>customer/profile/<?php echo $c['companyid'] ?>'>
                                <?php echo $c['customer']; ?>
                              </a>
                            </td>
                            <?php echo sprintf($format, $c['companyNo']) ?>
                            <?php echo sprintf($format, $c['CompReg']) ?>
                            <?php
                              $string = $c['companyNo'];
                              $company_no = implode('<br>', preg_split('~\X{12}\K~u', $string));

                              $string = $c['Name'];
                              $company_name = implode('<br>', preg_split('~\X{12}\K~u', $string));
                            ?>
                            <td><a data-toggle="modal" data-listing="<table class='table-responsive'><tr><th>Company ID</th><th>Name</th><th>Company Type</th><th>Customer</th><th>Company No</th><th>Registeration</th></tr><tr><td><?php echo $c['companyid']; ?></td><td><?php echo $company_name; ?></td><td><?php echo $c['CTypeName']; ?></td><td><?php echo $c['customer']; ?></td><td><?php echo $company_no; ?></td><td><?php echo $c['CompReg']; ?></td></tr>  </table>" data-target="#exampleModal" class="Show_details">view</a></td>

                          </tr>
                      <?php } } ?>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header" role="tab" id="headingThree">
                <h5 class="mb-0">
                  <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    موظف
                  </a>

                  <span style="float:right">found <label>(<?php echo count(@$employees); ?>)</label></span>
                </h5>
              </div>
              <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree">
                <div class="card-block">
                  <div class="box-body">
                    <table class="table table-striped">
                      <tr>
                        <th>رقم الموظف</th>
                        <th>نوع الوظيفة</th>
                        <th>اسم الموظف</th>
                        <th>رقم المنشأة</th>
                        <th>البريد الالتروني</th>
                        <th>الجوال</th>
                        <th>العملية</th>
                        <!--    <th>Nationality</th> -->
                        <!--    <th>Position</th> -->

                      </tr>
                      <?php if (!empty($employees)) {
                        foreach ($employees as $e) { 
                          $employee_id = $e['employee_id'];
                          $format = "<td><a href='{$base_url}employee/edit/{$employee_id}'>%s</a></td>";
                          $company_id = $e['companyid'];
                          $format_company = "<td><a href='{$base_url}company/edit/{$company_id}'>%s</a></td>";
                      ?>
                          <tr>
                            <?php echo sprintf($format, $e['employee_id']) ?>
                            <?php echo sprintf($format, $e['empposition']) ?>
                            <?php echo sprintf($format, $e['emp_name']) ?>
                            <?php echo sprintf($format_company, $e['companyname']) ?>
                            <?php echo sprintf($format, $e['email']) ?>
                            <?php echo sprintf($format, $e['mobile']) ?>

                            <td><a data-toggle="modal" data-listing="<table class='table'><tr><th>Employee ID</th><th>Type</th><th>Employee Name</th><th>Companyid</th><th>Email</th><th>Mobile</th></tr><tr><td><?php echo $e['employee_id']; ?></td><td><?php echo $e['empposition']; ?></td><td><?php echo $e['emp_name']; ?></td><td><?php echo $e['companyname']; ?></td><td><?php echo $e['email']; ?></td><td><?php echo $e['mobile']; ?></td></tr></table>" data-target="#exampleModal" class="Show_details">view</a></td>
                          </tr>
                      <?php }
                      } ?>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="card">
              <div class="card-header" role="tab" id="headingThree1">
                <h5 class="mb-0">
                  <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree1" aria-expanded="false" aria-controls="collapseThree1">
                    مستند
                  </a>
                  <span style="float:right">found <label>(<?php echo count(@$documents); ?>)</label></span>
                </h5>
              </div>
              <div id="collapseThree1" class="collapse" role="tabpanel" aria-labelledby="headingThree1">
                <div class="card-block">
                  <div class="box-body">
                    <table class="table table-striped">
                      <tr>
                        <th>#</th>
                        <!--   <th>Remarks</th> -->
                        <th>إسم المستند</th>
                        <th>نوع المستند</th>
                        <th>التصنيف</th>
                        <th>رقم المستند</th>
                        <th>تاريخ الاصدار</th>
                        <th>تاريخ الانتهاء</th>
                        <th>أيام التنبيه</th>
                        <th>العملية</th>
                      </tr>
                      <?php if (!empty($documents)) {                        
                        foreach ($documents as $d) { 
                          $doc_id = $d['docid'];
                          $format = "<td><a href='{$base_url}document/edit/{$doc_id}'>%s</a></td>";
                        ?>
                          <tr>
                            <?php echo sprintf($format, $d['docid']) ?>
                            <td>
                              <a href='<?php echo base_url(); ?>company/profile/<?php echo $d['comapnyid'] ?>'>
                                <?php echo $d['compname']; ?>
                              </a>
                            </td>
                            <?php echo sprintf($format, $d['docname']) ?>
                            <?php echo sprintf($format, $d['category']) ?>
                            <?php echo sprintf($format, $d['docno']) ?>
                            <?php echo sprintf($format, $d['issuedate']) ?>
                            <?php echo sprintf($format, $d['expiredate']) ?>
                            <?php echo sprintf($format, $d['warndays']) ?>
                            <?php
                              //$company_name = implode('<br>', str_split($d['compname'], 12));
                              $string = $d['compname'];
                              $company_name = implode('<br>', preg_split('~\X{12}\K~u', $string));
                            ?>
                            <td><a data-toggle="modal" data-listing="<table><tr><th>#</th><th>Comapny Name</th><th>Document Type</th><th>Category</th><th>Document No</th><th>Issue Date</th><th>Expire Date</th><th>Warndays</th></tr> <tr><td><?php echo $d['docid']; ?></td><td><?php echo $company_name; ?></td><td><?php echo $d['docname']; ?></td><td><?php echo $d['category']; ?></td><td><?php echo $d['docno']; ?></td><td><?php echo $d['issuedate']; ?></td><td><?php echo $d['expiredate']; ?></td><td><?php echo $d['warndays']; ?></td></tr></table>" data-target="#exampleModal" class="Show_details">view</a></td>
                          </tr>
                      <?php } } ?>
                    </table>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
  $("#search-form").submit(function(event) {
    sessionStorage.clear()
  });

  $(".collapsed").each(function() {
    var elementId = $(this).attr('aria-controls');
    if (sessionStorage.getItem('search_collapsed_' + elementId) == '1') {
      $("#" + elementId).attr('class', 'collapse in')
      $(this).attr('aria-expanded', 'true')
    }
    else {
      $("#" + elementId).attr('class', 'collapse')
      $(this).attr('aria-expanded', 'false')
    }
  })

  $(".collapsed").click(function() {
    var state = $(this).attr('aria-expanded')
    var elementId = $(this).attr('aria-controls');
    sessionStorage.setItem('search_collapsed_' + elementId, state == 'true' ? '0' : '1');    
  })
})
</script> -->