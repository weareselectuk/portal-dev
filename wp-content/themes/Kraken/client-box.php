

<div class="modal fade" id="cb1" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true" style="width: 100%;color:#999;">
<div class="arrow" style="display:block; left:76%"></div>
                      <div class="modal-dialog" role="document" style="width:580px !important;left: 65%;top: 12%;position: absolute;">
                        <div class="modal-content" style="width: 571px;background-color:#EEEDED">
                          <div class="modal-header"  style="width: 569px;margin-left: 0px;margin-bottom: 13px;padding-bottom: 15px; background-color: white;">
                            <h5 class="modal-title" id="email">Key Client Info</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                          <div class="table-responsive">
                <table class="table table-striped">

                  <tbody>

                    <tr>
                      <th scope="row"><strong>Client Status:</strong></th>
                      <td>
                        <?php $meta_key = 'client_status'; $id = get_the_id(); ?>
                        <a data-title="Client Status" href="#" id="client-status" name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'Active',text:'Active'},{value:'Not Active',text:'Not Active'}]"
                          data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                    </tr>
                    <tr>

                    </tr>
                    <tr>
                      <th scope="row"><strong>Key Sales Contact:</strong></th>
                      <td>
                        <?php $meta_key = 'sales_contact'; $id = get_the_id(); ?>
                        <a data-title="Key Sales Contact" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row"><strong>Key Tech Contact:</strong></th>
                      <td>
                        <?php $meta_key = 'tech_contact'; $id = get_the_id(); ?>
                        <a data-title="Key Technical Contact" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row"><strong>Key Contact for Approval:</strong></th>
                      <td>
                        <?php $meta_key = 'approval_contact'; $id = get_the_id(); ?>
                        <a data-title="Key Contact for Approval" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>

                      <tr>
                        <th scope="row"><strong>Account Manager:</strong></th>
                        <td>
                          <?php $meta_key = 'account_manager'; $id = get_the_id(); ?>
                          <a data-title="Account Manager" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                            <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                          </a>
                        </td>

                      </tr>

                    </tr>
                  </tbody>
                </table>
                          </div>                          
                        </div>
                      </div>
                    </div>
</div>
<div class="modal fade" id="cb2" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true" style="width: 100%;color:#999;">
<div class="arrow" style="display:block; left:76%"></div>
                      <div class="modal-dialog" role="document" style="width:580px !important;left: 65%;top: 12%;position: absolute;">
                        <div class="modal-content" style="width: 571px;background-color:#EEEDED">
                          <div class="modal-header"  style="width: 569px;margin-left: 0px;margin-bottom: 13px;padding-bottom: 15px; background-color: white;">
                            <h5 class="modal-title" id="email">Network Configuration</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                          <div class="table-responsive">
      <table class="table table-striped">

        <tbody>

          <tr>
            <th scope="row"><strong>Domain Setup:</strong></th>
            <td>
              <?php $meta_key = 'domain_setup'; $id = get_the_id(); ?>
              <a data-title="Domain Setup" href="#" id="vpn" name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'Yes',text:'Yes'},{value:'Not',text:'No'},{value:'',text:'Empty'}]" data-pk="<?php echo $id;?>" class="text-field">
                <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
              </a>
            </td>
          </tr>
          <tr>
            <th scope="row"><strong>Primary Domain Suffix:</strong></th>
            <td>
              <?php $meta_key = 'primary_domain_suffix'; $id = get_the_id(); ?>
              <a data-title="Primary Domain Suffix" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
              </a>
            </td>
          </tr>
          <tr>
            <th scope="row"><strong>SSO Setup:</strong></th>
            <td>
              <?php $meta_key = 'sso_setup'; $id = get_the_id(); ?>
              <a data-title="SSO Setup" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
              </a>
            </td>


          </tr>
          <tr>
            <th scope="row"><strong>DHCP Server:</strong></th>
            <td>
              <?php $meta_key = 'dhcp_server'; $id = get_the_id(); ?>
              <a data-title="DHCP Server" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
              </a>
            </td>

          </tr>
          <tr>
            <th scope="row"><strong>Lan IP Address:</strong></th>
            <td>
              <?php $meta_key = 'lan_ip'; $id = get_the_id(); ?>
              <a data-title="Lan IP Address" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
              </a>
            </td>
          </tr>
          <tr>
            <th scope="row"><strong>Gateway IP Address:</strong></th>
            <td>
              <?php $meta_key = 'gateway_ip_address'; $id = get_the_id(); ?>
              <a data-title="gateway IP Address" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
              </a>
            </td>
          </tr>
          <tr>
            <th scope="row"><strong>Subnet Mask:</strong></th>
            <td>
              <?php $meta_key = 'subnet_mask'; $id = get_the_id(); ?>
              <a data-title="Subnet Mask" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
              </a>
            </td>
          </tr>
          <tr>
            <th scope="row"><strong>Primary DNS:</strong></th>
            <td>
              <?php $meta_key = 'primary_dns'; $id = get_the_id(); ?>
              <a data-title="Primary DNS" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
              </a>
            </td>
          </tr>
          <tr>
            <th scope="row"><strong>Secondary DNS:</strong></th>
            <td>
              <?php $meta_key = 'secondary_dns'; $id = get_the_id(); ?>
              <a data-title="Secondary DNS" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
              </a>
            </td>
          </tr>
          <tr>
            <th scope="row"><strong>WAN IP Address:</strong></th>
            <td>
              <?php $meta_key = 'wan_ip_address'; $id = get_the_id(); ?>
              <a data-title="WAN IP Address" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
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

<div class="modal fade" id="cb3" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true" style="width: 100%;color:#999;">
<div class="arrow" style="display:block; left:76%"></div>
                      <div class="modal-dialog" role="document" style="width:580px !important;left: 65%;top: 12%;position: absolute;">
                        <div class="modal-content" style="width: 571px;background-color:#EEEDED">
                          <div class="modal-header"  style="width: 569px;margin-left: 0px;margin-bottom: 13px;padding-bottom: 15px; background-color: white;">
                            <h5 class="modal-title" id="email">Email Configuration</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                          <div class="table-responsive">
      <table class="table table-striped">

        <tbody>
        <tr>
            <th scope="row"><strong>Select Managed:</strong></th>
            <td>
            <?php $meta_key = 'select_managed'; $id = get_the_id(); ?>
                        <a data-title="Select Managed" href="#" id="select-managed" name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'Yes',text:'Yes'},{value:'No',text:'No'}]"
                          data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
              </a>
            </td>
          </tr>

          <tr>
            <th scope="row"><strong>Email Provider:</strong></th>
            <td>
              <?php $meta_key = 'email_provider'; $id = get_the_id(); ?>
              <a data-title="Email Provider" href="#" id="vpn" name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'Gsuite',text:'GSuite'},{value:'Office 365',text:'Office 365'}]" data-pk="<?php echo $id;?>"
                class="text-field">
                <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
              </a>
            </td>
          </tr>
          <tr>
            <th scope="row"><strong>Email Admin Login:</strong></th>
            <td>
              <?php $meta_key = 'email_admin_login'; $id = get_the_id(); ?>
              <a data-title="Email Admin Login" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
              </a>
            </td>
          </tr>
          <tr>
            <th scope="row"><strong>Email Admin Password:</strong></th>
            <td>
              <?php $meta_key = 'email_admin_password'; $id = get_the_id(); ?>
              <a data-title="Email Admin Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
              </a>
            </td>
          </tr>
          <tr>
            <th scope="row"><strong>Link To Email Provider:</strong></th>
            <td>
              <?php $meta_key = 'link_to_email_provider'; $id = get_the_id(); ?>
              <a data-title="Link To Email Provider" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
              </a>
            </td>
          </tr>


          <tr>
            <th scope="row"><strong>Email Setup Notes:</strong></th>
            <td>
              <?php $meta_key = 'email_setup_notes'; $id = get_the_id(); ?>
              <a data-title="Email Setup Notes" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
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
    <!-- Modal Create Client-->
<div class="modal fade" id="clientm" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="clientmo">Create Client</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php echo do_shortcode("[ninja_form id=2]"); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
<!-- Modal Create Asset-->
<div class="modal fade" id="assetm" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="assetmo">Create Asset</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php echo do_shortcode("[ninja_form id=5]"); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal Create user-->
                    <div class="modal fade" id="userm" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="usermo">Create Staff Member</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                          <?php echo do_shortcode("[ninja_form id=42]"); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
<!-- Modal Create site-->
<div class="modal fade" id="sitem" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="sitem">Create Site</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php echo do_shortcode("[ninja_form id=3]"); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal Create Internal Service-->
                    <div class="modal fade" id="servicesm" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="internalm">Create A Service</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php echo do_shortcode("[ninja_form id=49]"); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal Create External Service-->
                    <div class="modal fade" id="softwareservicesm" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="externalm">Create Software</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php echo do_shortcode("[ninja_form id=50]"); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal Create Web Service:Domain-->
                    <div class="modal fade" id="domainm" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="email">Create Domain</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php echo do_shortcode("[ninja_form id=34]"); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal Create Web Service:Hosting-->
                    <div class="modal fade" id="hostingm" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="hostingmo">Create Hosting</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php echo do_shortcode("[ninja_form id=35]"); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal Create Web Service:SFTP-->
                    <div class="modal fade" id="crushm" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="crushmo">Create SFTP</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php echo do_shortcode("[ninja_form id=32]"); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Modal Create logins-->
                    <div class="modal fade" id="loginsm" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="usermo">Create Logins</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                          <?php echo do_shortcode("[ninja_form id=48]"); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal Create Licenses:Email-->
                    <div class="modal fade" id="emailm" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="emailmo">Create Email</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php echo do_shortcode("[ninja_form id=33]"); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal Create SSL-->
                    <div class="modal fade" id="sslm" tabindex="-1" role="dialog" aria-labelledby="ssl" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="sslmo">Create SSL</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php echo do_shortcode("[ninja_form id=38]"); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Modal Create Sales Ticket-->
                    <div class="modal fade" id="salehdm" tabindex="-1" role="dialog" aria-labelledby="sale" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="salesmo">Sales Ticket</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php Ninja_Forms()->display( 46 ); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Modal Create Bug Ticket-->
                    <div class="modal fade" id="bugm" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="bugmo">Report A Bug</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php Ninja_Forms()->display( 22 ); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                   
                    <!-- Modal Create Tech Support Ticket-->
                    <div class="modal fade" id="techsupportm" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="techmo">Technical Support Ticket</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php Ninja_Forms()->display( 43 ); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal Create Customer Service Ticket-->
                    <div class="modal fade" id="customerservicem" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="emailmo">Customer Service Ticket</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php Ninja_Forms()->display( 44 ); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                   
                    <!-- Modal Create Licensing Ticket-->
                    <div class="modal fade" id="licensingm" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="licensingmo">Licensing Ticket</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php Ninja_Forms()->display( 44 ); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal Create Other Ticket-->
                    <div class="modal fade" id="otherm" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="othermo">Other Ticket</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php Ninja_Forms()->display( 45 ); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal Add Diary Event-->
                    <div class="modal fade" id="diary_event" tabindex="-1" role="dialog" aria-labelledby="diary event" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="diaryeventtitle">Create Diary Event</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php Ninja_Forms()->display( 29 ); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal Conversation-->
                    <div class="modal fade" id="add_convo" tabindex="-1" role="dialog" aria-labelledby="add conversation" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="diaryeventtitle">Create Conversation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php Ninja_Forms()->display( 28 ); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- User profile DB-->
                    <div class="modal fade" id="user_profile" tabindex="-1" role="dialog" aria-labelledby="diary event" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="diaryeventtitle">My Select</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                          <?php echo do_shortcode("[ms-membership-account]"); ?>
                          
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>


                    