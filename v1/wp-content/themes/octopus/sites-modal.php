<!--

Modals for the client dashboard, under the site tab

Last updated: 28/08/2018

-->


<!-- Site Status -->

<div class="modal fade" id="sitestatus_<?php $post_id = get_the_ID();
   echo $post_id;?>" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Site Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <tbody>
                  <tr>
                    <th scope="row"><strong>Site Status:</strong></th>
                    <td colspan="3">
                    <label class="switch">
            <input type="checkbox">
            <span class="slider"></span>
          
        </label> 
     
                  </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>
<!-- Site Map -->

<div class="modal" id="sitemap_<?php $post_id = get_the_ID();
   echo $post_id;?>" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Site Map</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="panel panel-default">
          <div class="panel-body">
            <!--The div element for the map -->
    <div id="map"></div>
    <script>
// Initialize and add the map
function initMap() {
  // The location of site
  var site = {lat: <?php echo get_post_meta($post->ID, 'latitude', true); ?>, lng: <?php echo get_post_meta($post->ID, 'longitude', true); ?>};
  // The map, centered at site
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 12, center: site});
  // The marker, positioned at site
  var marker = new google.maps.Marker({position: site, map: map, title: "<?php the_title(); ?>"});
  var contentString = '<div id="content">'+
      '<div id="siteNotice">'+
      '</div>'+
      '<h1 id="firstHeading" class="firstHeading"><?php the_title(); ?></h1>'+
      '<div id="directions"><a href="https://maps.google.com/?q=<?php echo get_post_meta($post->ID, 'address', true); ?>,<?php echo get_post_meta($post->ID, 'post_code', true); ?>" class="btn btn-primary legitRipple">Directions</a></div>';
      var infowindow = new google.maps.InfoWindow({
    content: contentString
  });

  var marker = new google.maps.Marker({
    position: site,
    map: map,
    title: '<?php the_title(); ?>'
  });
  marker.addListener('click', function() {
    infowindow.open(map, marker);
  });
}
</script>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>
<!-- Site Config -->

<div class="modal fade" id="config_<?php $post_id = get_the_ID();
   echo $post_id;?>" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Site Email Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <tbody>
                <tr>
                        <th scope="row"><strong>Email Provider</strong></th>
                        <td>
                          <?php $client_id = get_post_meta( get_the_id(), 'client', true );?>
                          <a href="<?php echo get_permalink($client_id);?>" class="text-default">
                            <?php echo get_the_title($client_id);?>
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row"><strong>Email Address:</strong></th>
                        <td>
                          <?php $meta_key = 'email_address'; $id = get_the_id(); ?>
                          <a data-title="Email Address" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                            <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                          </a>
                        </td>
                      </tr>

                      <tr>
                        <th scope="row"><strong>Password:</strong></th>
                        <td>
                          <?php $meta_key = 'password'; $id = get_the_id();?>
                        <a data-title="Password" href="#" id="password" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field password">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                        <i class="glyphicon glyphicon-eye-open"></i>
                          </a>
                        </td>
                      </tr>
                </tbody>
              </table>
            </div>
            
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>

<!-- Site Photo library -->

<div class="modal fade" id="configphotos_<?php $post_id = get_the_ID();
   echo $post_id;?>" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Site Photos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="panel panel-default">
          <div class="panel-body">

          
        
                    <!-- Table -->
         
          </div>
         
          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
       

      </div>
    </div>
  </div>
</div>

<!-- Site Notes -->

<div class="modal fade" id="sitenotes_<?php $post_id = get_the_ID();
   echo $post_id;?>" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Site Notes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <tbody>
                <tr>
                        <th scope="row"><strong>Site Notes</strong></th>
                        <td>
                        <?php $meta_key = 'site_notes'; $id = get_the_id(); ?>
                          <a data-title="Site notes" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                            <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row"><strong>Date Completed:</strong></th>
                        <td>
                          <?php $meta_key = 'date_completed'; $id = get_the_id(); ?>
                          <a data-title="Date Completed" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
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
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>

<!-- Site Tickets -->

<div class="modal fade" id="sitetickets_<?php $post_id = get_the_ID();
   echo $post_id;?>" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Site Tickets</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <tbody>
                <tr>
                        <th scope="row"><strong>Site Notes</strong></th>
                        <td>
                        <?php $meta_key = 'site_notes'; $id = get_the_id(); ?>
                          <a data-title="Site notes" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                            <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row"><strong>Date Completed:</strong></th>
                        <td>
                          <?php $meta_key = 'date_completed'; $id = get_the_id(); ?>
                          <a data-title="Date Completed" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
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
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>