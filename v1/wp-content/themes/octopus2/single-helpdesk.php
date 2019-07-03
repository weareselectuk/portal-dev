<?php /*Template Name: helpdesk-landing*/ get_header(); ?>

<section class="container-fluid" id="section1">
  	<h1 class="text-center v-center">How can we help?</h1>
 	
  	<div class="container">
      <div class="row">
          <div class="col-sm-4">
            <div class="row">
              <div class="col-sm-10 col-sm-offset-2 text-center"><h3>Sales</h3><p>Pre Sales, new equipment and upgrades</p><a href="#sales" data-toggle="modal" data-target="#sales"><span class="fas fa-money-check fa-5x" style="color:#FFFFFF" title="Sales"></span></a></div>
            </div>
          </div>
          <div class="col-sm-4 text-center">
            <div class="row">
              <div class="col-sm-10 col-sm-offset-1 text-center"><h3>Technical Support</h3><p>Get help with any issues</p><a href="#technicalsupport" data-toggle="modal" data-target="#technicalsupport"><span class="fas fa-ambulance fa-5x" style="color:#FFFFFF" title="Customer Service"></span></a></div>
            </div>
          </div>
          <div class="col-sm-4 text-center">
            <div class="row">
              <div class="col-sm-10 text-center"><h3>Customer Service</h3><p>Billing or account issues</p><a href="#customerservice" data-toggle="modal" data-target="#customerservice"><span class="fas fa-file-invoice-dollar fa-5x" style="color:#FFFFFF" title="Customer Service"></span></a></div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="row">
              <div class="col-sm-10 col-sm-offset-2 text-center"><h3>Licensing</h3><p>Software, Office 365, GMail or Windows</p><a href="#licensing" data-toggle="modal" data-target="#licensing"><span class="fas fa-barcode fa-5x" style="color:#FFFFFF" title="Licensing"></span></a></div>
            </div>
          </div>
          <div class="col-sm-4 text-center">
            <div class="row">
              <div class="col-sm-10 col-sm-offset-1 text-center"><h3>Other</h3><p>Not listed, then you've come to the place</p><a href="#other" data-toggle="modal" data-target="#other"><span class="fas fa-question fa-5x" style="color:#FFFFFF" title="Other"></span></a></div>
            </div>
          </div>
          <div class="col-sm-4 text-center">
            <div class="row">
              <div class="col-sm-10 text-center"><h3>Report a bug</h3><p>Found an issue with the portal, report it here</p><a href="#bug" data-toggle="modal" data-target="#bug"><span class="fas fa-bug fa-5x" style="color:#FFFFFF" title="Sales"></span></a></div>
            </div>
          </div>
      </div><!--/row-->
    <div class="row"><br></div>
  </div><!--/container-->
</section> 

<?php include get_template_directory() . '/support-modals.php'; ?>





