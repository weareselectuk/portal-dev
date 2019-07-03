<div class="container-fluid">
	
<div class="col-md-12">
      <div class="panel with-nav-tabs panel-orange-top">
			<div style="padding:4px; background-color:#d8931f;height:200px;">
			<div class="container-fluid">
	<div class="row">
		<div class="col-md-4">
			<p>stuff</p>
		</div>
		<div class="col-md-4">
			<p>stuff</p>
		</div>
		<div class="col-md-4">
			<p>stuff</p>
		</div>
	</div>
</div>
     
			</div>
		</div>
	
	
		
      <div class="panel with-nav-tabs panel-default">
			<ul class="nav nav-tabs" id="interest_tabs">
        <!--top level tabs-->
        <li><a href="#all" data-toggle="tab">General</a></li>
        <li><a href="#brands" data-toggle="tab">Specifications</a></li>
        <li><a href="#media" data-toggle="tab">Guru</a></li>
        <li><a href="#music" data-toggle="tab">Asset Diary</a></li>
        <li><a href="#public_figures" data-toggle="tab">Reports</a></li>
        <li><a href="#sports" data-toggle="tab">Logins</a></li>
       
      </ul>

      <!--top level tab content-->
      <div class="tab-content">
        <!--all tab menu-->
        <div id="all" class="tab-pane">
          <ul class="nav nav-tabs" id="all_tabs" style="background-color:#232C3E;margin-top:-20px;">
            <li><a href="#all_popular" data-toggle="tab">test2 </a></li>
            <li><a href="#all_unique" data-toggle="tab">test 2 </a></li>
          </ul>
        </div>

        <!--brands tab menu-->
        <div id="brands" class="tab-pane">
          <ul class="nav nav-tabs" id="brands_tabs" style="background-color:#232C3E;margin-top:-20px;">
            <li><a href="#brands_popular" data-toggle="tab">CPU</a></li>
            <li><a href="#brands_unique" data-toggle="tab">RAM</a></li>
            <li><a href="#brands_hdd" data-toggle="tab">HDD</a></li>
          </ul>
        </div>

        <!--media tab menu-->
        <div id="media" class="tab-pane">
          <ul class="nav nav-tabs" id="media_tabs" style="background-color:#232C3E;margin-top:-20px;">
            <li><a href="#media_popular" data-toggle="tab">Guru 1</a></li>
            <li><a href="#media_guru1" data-toggle="tab">Guru 2</a></li>
            <li><a href="#media_guru2" data-toggle="tab">Guru 3</a></li>
            <li><a href="#media_guru3" data-toggle="tab">Guru 4</a></li>
            <li><a href="#media_guru4" data-toggle="tab">Guru 5</a></li>
            
          </ul>
        </div>

        <!--music tab menu-->
        <div id="music" class="tab-pane">
          <ul class="nav nav-tabs" id="music_tabs" style="background-color:#232C3E;margin-top:-20px;">
            <li><a href="#music_popular" data-toggle="tab">Event 1</a></li>
            <li><a href="#music_unique" data-toggle="tab">Event 2</a></li>
          </ul>
        </div>

        <!--public_figures tab menu-->
        <div id="public_figures" class="tab-pane">
          <ul class="nav nav-tabs" id="public_figures_tabs" style="background-color:#232C3E;margin-top:-20px;">
            <li><a href="#public_figures_popular" data-toggle="tab">test 1</a></li>
            <li><a href="#public_figures_unique" data-toggle="tab">Test 2</a></li>
          </ul>
        </div>

        <!--sports tab menu-->
        <div id="sports" class="tab-pane">
          <ul class="nav nav-tabs" id="sports_tabs" style="background-color:#232C3E;margin-top:-20px;">
            <li><a href="#sports_popular" data-toggle="tab">Logins 1</a></li>
            <li><a href="#sports_unique" data-toggle="tab">Logins </a></li>
          </ul>
        </div>

        <!--tv/movies tab menu-->
        <div id="tv_movies" class="tab-pane" style="background-color:#232C3E;margin-top:-20px;">
          <ul class="nav nav-tabs" id="tv_movies_tabs">
            <li><a href="#tv_movies_popular" data-toggle="tab">Test 4</a></li>
            <li><a href="#tv_movies_unique" data-toggle="tab">Test 5</a></li>
          </ul>
        </div>



      </div>

      <!--all tab content-->
      <div class="tab-content">
        <div id="all_popular" class="tab-pane">
          <div class="table-responsive">
                            <table class="table table-striped">
                                  <tbody>
																	    <tr>
																	      <th scope="row">Server Type:</th>
																	      <td colspan="3"><?php $meta_key = 'servers_type'; $id = get_the_id();?><a data-title="Server Type" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      </tr>
																	    <tr>
																		<tr>
																	      <th scope="row">Manufacturer:</th>
																	      <td><?php $meta_key = 'manufacturer'; $id = get_the_id();?><a data-title="Manufacturer" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Model:</td>
																	      <td><?php $meta_key = 'model'; $id = get_the_id();?><a data-title="Model" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																		 
																	      <th scope="row">OS Version :</th>
																	      <td><?php $meta_key = 'os_version'; $id = get_the_id();?><a data-title="Model" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Admin URL</td>
																	      <td><?php $meta_key = 'admin_url'; $id = get_the_id();?><a data-title="Local Admin Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <th scope="row">Serial No:</th>
																	      <td><?php $meta_key = 'serial_number'; $id = get_the_id();?><a data-title="Serial No" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Service Tag:</td>
																	      <td><?php $meta_key = 'service_tag_serial_number'; $id = get_the_id();?><a data-title="Service Tag" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <th scope="row">Teamviewer ID:</th>
																	   	  <td><?php $meta_key = 'teamviewer_id'; $id = get_the_id();?><a data-title="Teamvieweer ID" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Teamviewer Password:</td>
																	      <td><?php $meta_key = 'teamviewer_password'; $id = get_the_id();?><a data-title="Teamviewer Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <th scope="row">LAN IP:</th>
																	  	  <td><?php $meta_key = 'lan_ip'; $id = get_the_id();?><a data-title="LAN IP" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">WAN IP:</td>
																	      <td><?php $meta_key = 'wan_ip'; $id = get_the_id();?><a data-title="WAN IP" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																		<tr>
																	      <th scope="row">Purchase Order No:</th>
																	   	  <td><?php $meta_key = 'purchase_order_no'; $id = get_the_id();?><a data-title="TPM Chip Version" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Purchase Price:</td>
																	      <td><?php $meta_key = 'purchase_price'; $id = get_the_id();?><a data-title="Teamviewer ID" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <th scope="row">Purchase Date:</th>
																	  	<td><?php $meta_key = 'purchase_date'; $id = get_the_id();?><a data-title="LAN IP" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Purchase Supplier:</td>
																	      <td><?php $meta_key = 'purchase_supplier'; $id = get_the_id();?><a data-title="Teamviewer Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	  </tbody>
                </table>
              </div>
        </div>
        <div id="all_unique" class="tab-pane">
         <div class="table-responsive">
                           test 2
        </div>
      </div>

      <!--brands tab content-->
      <div class="tab-content">
        <div id="brands_popular" class="tab-pane">
          <i>info 1</i>
        </div>
        <div id="brands_unique" class="tab-pane">
          <i>info 1</i>
        </div>
      </div>

      <!--media tab content-->
      <div class="tab-content">
        <div id="media_popular" class="tab-pane">
          <i>info 1</i>
        </div>
        <div id="media_unique" class="tab-pane">
          <i>info 1</i>
        </div>
      </div>

      <!--music tab content-->
      <div class="tab-content">
        <div id="music_popular" class="tab-pane">
          <i>info 1</i>
        </div>
        <div id="music_unique" class="tab-pane">
          <i>info 1</i>
        </div>
      </div>

      <!--public_figures tab content-->
      <div class="tab-content">
        <div id="public_figures_popular" class="tab-pane">
          <i>info 1</i>
        </div>
        <div id="public_figures_unique" class="tab-pane">
          <i>info 1</i>
        </div>
      </div>

      <!--sports tab content-->
      <div class="tab-content">
        <div id="sports_popular" class="tab-pane">
          <i>info 1</i>
        </div>
        <div id="sports_unique" class="tab-pane">
          <i>info 1</i>
        </div>
      </div>

      <!--tv_movies tab content-->
      <div class="tab-content">
        <div id="tv_movies_popular" class="tab-pane">
          <i>info 2</i>
        </div>
        <div id="tv_movies_unique" class="tab-pane">
          <i>info 1</i>
        </div>
      </div>
            </div>
		</div>
		</div>



