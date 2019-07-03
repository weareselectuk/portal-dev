<?php get_template_part('asset', 'header');?>


<div class="panel with-nav-tabs panel-default">
  <ul class="nav nav-tabs">
    <!--top level tabs-->
    <li class="active"><a href="#general" data-toggle="tab">General</a></li>
    <li><a href="#logins" data-toggle="tab">Logins</a></li>
  </ul>

  <!--top level tab content-->
  <div class="tab-content">
    <!--all tab menu-->
    <div id="general" class="tab-pane fade active in">
      <ul class="nav nav-tabs" style="background-color:#3873b9;margin-top:-20px;">
        <li class="active"><a href="#overview_1" data-toggle="tab">Asset Overview </a></li>
        <li><a href="#purchasing_2" data-toggle="tab">Purchasing & Warranty Information</a></li>
      </ul>

      <!--General tab content-->
      <div class="tab-content">
        <div id="overview_1" class="tab-pane active">
          <div class="table-responsive">
            <table class="table table-striped">

              <tbody>
                <tr>
                  <th scope="row"><strong>Manufacturer:</strong></th>
                  <td>
                    <?php $meta_key = 'manufacturer'; $id = get_the_id();?>
                    <a data-title="Manufacturer" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                  <th scope="row"><strong>Lan IP:</strong></th>
                    <td>
                      <?php $meta_key = 'lan_ip'; $id = get_the_id();?>
                      <a data-title="Lan IP" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                        <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                      </a>
                    </td>
                </tr>
                <tr>
                  <th scope="row"><strong>Model:</strong></th>
                  <td>
                    <?php $meta_key = 'model'; $id = get_the_id();?>
                    <a data-title="Model" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                  <th scope="row"><strong>OS Version:</strong></th>
                    <td>
                      <?php $meta_key = 'os_version'; $id = get_the_id();?>
                      <a data-title="OS Version" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                        <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                      </a>
                    </td>
                </tr>
                <tr>
                  <th scope="row"><strong>Serial No:</strong></th>
                  <td>
                    <?php $meta_key = 'serial_number'; $id = get_the_id();?>
                    <a data-title="Serial No" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                  <th scope="row"><strong>WAN IP:</strong></th>
                    <td>
                      <?php $meta_key = 'wan_ip'; $id = get_the_id();?>
                      <a data-title="WAN IP" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                        <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                      </a>
                    </td>
                </tr>
                <tr>
                  <th scope="row"><strong>Service Tag:</strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'service_tag'; $id = get_the_id();?>
                    <a data-title="Service Tag" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>

                </tr>
              </tbody>
            </table>


          </div>
        </div>
        <div id="purchasing_2" class="tab-pane">
          <div class="table-responsive">
            <table class="table table-striped">
              <tbody>
                <tr>
                  <th scope="row"><strong>Purchase Order No:</strong>
                  </th>
                  <td>
                    <?php $meta_key = 'purchase_order_no'; $id = get_the_id();?>
                    <a data-title="Purchase Order No" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                  <th scope="row"><strong>Purchase Price:</strong>
                    </th>
                    <td>
                      <?php $meta_key = 'purchase_price'; $id = get_the_id();?>
                      <a data-title="Purchase price" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                        <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                      </a>
                    </td>
                </tr>
                <tr>
                  <th scope="row"><strong>Purchase Date:</strong>
                  </th>
                  <td>
                    <?php $meta_key = 'purchase_date'; $id = get_the_id();?>
                    <a data-title="Purchase Date" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                  <th scope="row"><strong>Purchase Supplier:</strong>
                  </th>
                  <td>
                    <?php $meta_key = 'purchase_supplier'; $id = get_the_id();?>
                    <a data-title="Purchase Supplier" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><strong>Warranty Description:</strong>
                  </th>
                  <td>
                    <?php $meta_key = 'warranty_description'; $id = get_the_id();?>
                    <a data-title="Warranty Description" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                  <th scope="row"><strong>Warranty Expiry:</strong>
                  </th>
                  <td>
                    <?php $meta_key = 'warranty_expiry'; $id = get_the_id();?>
                    <a data-title="Warranty Expiry" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><strong>Warranty Reference:</strong>
                  </th>
                  <td>
                    <?php $meta_key = 'warranty_reference'; $id = get_the_id();?>
                    <a data-title="Warranty Reference" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                  <th scope="row"><strong>Warranty Registration:</strong>
                  </th>
                  <td>
                    <?php $meta_key = 'warrranty_registration'; $id = get_the_id();?>
                    <a data-title="Warranty Registration" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>

              </tbody>
            </table>
          </div>
        </div>
      </div>
      </div>

      <!--logins tab menu-->
      <div id="logins" class="tab-pane fade">
        <ul class="nav nav-tabs" style="background-color:#3873b9;margin-top:-20px;">
          <li class="active"><a href="#logins_local" data-toggle="tab">Local Credentials</a></li>
        </ul>

        <!--Logins tab content-->
        <div class="tab-content">
          <div id="logins_local" class="tab-pane fade active in">
            <div class="table-responsive">
              <table class="table table-striped">
                <tbody>
                  <tr>
                    <th scope="row"><strong>Local Admin Username:</strong></th>
                    <td>
                      <?php $meta_key = 'local_admin_username'; $id = get_the_id();?>
                      <a data-title="Local Admin Username" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                        <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                      </a>
                    </td>
                    <th scope="row"><strong>Local Username:</strong></th>
                      <td>
                        <?php $meta_key = 'local_username'; $id = get_the_id();?>
                        <a data-title="Local Username" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                  </tr>
                  <tr>
                    <th scope="row"><strong>Local Admin Password:</strong></th>
                    <td>
                      <?php $meta_key = 'local_admin_password'; $id = get_the_id();?>
                      <a data-title="Local Admin Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                        <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                      </a>
                    </td>
                    <th scope="row"><strong>Local Password:</strong></th>
                      <td>
                        <?php $meta_key = 'local_password'; $id = get_the_id();?>
                        <a data-title="Local Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>