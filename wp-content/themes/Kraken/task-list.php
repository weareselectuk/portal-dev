<?php /*Template Name: Migrations*/ get_header(); ?>
<style>
  @media screen and (max-width: 50em) {
    body {
      font-size: large;
    }
  }

  @media screen and (max-width: 40em) {
    body {
      font-size: medium;
    }
  }

  @media screen and (max-width: 30em) {
    body {
      font-size: smaller;
    }
  }

  .page-title {
    padding: 15px;
    color: #22313F;
    font-size: 1.6em;
    width: 90%;
    margin: 0 auto;
    text-align: center;
  }

  .page-title h1 {
    margin: 0;
  }

  .page-title .tag {
    padding: 0;
    color: #3A539B;
    font-weight: bold;
    font-size: .7em;
    width: 18em;
    animation: type 2s steps(200, end);
    white-space: nowrap;
    overflow: hidden;
    margin: 0 auto;
  }

  .tag .caret {
    animation: blink 1s;
  }

  @keyframes type {
    from {
      width: 0;
    }
  }

  @keyframes blink {
    to {
      opacity: .0;
    }
  }

  .page-title [class*=icon] {
    font-size: 1em;
    color: #26A65B;
  }

  [draggable] {
    -moz-user-select: none;
    -khtml-user-select: none;
    -webkit-user-select: none;
    user-select: none;
    /* Required to make elements draggable in old WebKit */
    -khtml-user-drag: element;
    -webkit-user-drag: element;
  }

  .opaque {
    opacity: 0.4;
  }

  .main-wrap {
    border: solid 1px #2c3033;
    max-width: 350px;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto;
    z-index: 500;
    max-height: 450px;
    background: #22313F;
    color: #fff;
    opacity: .9;
  }

  .hidden {
    display: none;
  }

  .app-header {
    width: 100%;
    height: 50px;
    background-color: #2980b9;
    font: bold 18px/50px arial;
    text-align: center;
    color: white;
    margin: 0;
  }

  .main-content {
    padding: 15px 30px;
  }

  #todoForm {
    display: flex;
    flex-wrap: wrap;
    flex-direction: column;
  }

  /* Row */

  div.row {
    margin: 0 10px;
    padding: 10px 0;
  }

  .row.submit-btn {
    min-width: 150px;
  }

  /** Form Elements **/

  label {
    display: block;
    font-size: 1.2em;
  }

  input,
  select,
  textarea {
    border-radius: 3px;
    border: 1px solid #aebdc1;
    box-sizing: border-box;
    font-size: 1em;
    padding: 0.625em;
    -webkit-transition: border-color 0.2s ease-in-out;
    transition: border-color 0.2s ease-in-out;
    min-width: 250px;
  }

  .primary-button {
    width: 100%;
    font-size: 1.2em;
    margin: 0;
    display: block;
    color: #fff;
    background-color: #2980b9;
    border-color: #48c9b0;
    box-shadow: none;
    border: none;
    padding: 15px 0;
    max-width: 250px;
  }

  .todo-list-container {
    position: relative;
    width: 100%;
    margin: 0 auto;
    /*box-shadow: 0 -5px 10px rgba(0, 0, 0, .08);*/
    display: flex;
    flex-wrap: wrap;
  }

  .todo-list-container .todo-in-progress {
    flex: 2 1 800px;
    width: 70%;
  }

  .todo-in-progress h2 {
    color: #8F1D21;
  }

  .todo-list-container .todo-completed {
    flex: 1 1 300px;
    /*background: #cecece;*/
    color: #8F1D21;
    opacity: .8;
    width: 30%;
  }

  .todo-list-completed {
    padding: 0;
  }

  .todo-list {
    margin: 0 auto;
    padding: 0;
    display: flex;
    flex-wrap: wrap;
  }

  .todo-list .todo-item {
    will-change: transform;
    position: relative;
    background-color: #fafafa;
    flex: 1 1 calc(48% - 40px);
    -webkit-transition: all 400ms cubic-bezier(0.165, 0.84, 0.44, 1);
    transition: all 400ms cubic-bezier(0.165, 0.84, 0.44, 1);
    box-shadow: 0 1px 6px 0 rgba(0, 0, 0, 0.3), 0 1px 6px 0 rgba(0, 0, 0, 0.15);
    padding: 0 20px 0 20px;
    margin: 15px 2% 15px 0;
    min-width: 260px;
  }

  .todo-item.over {
    border: 2px dashed #000;
  }

  .todo-item .todo-description {
    line-height: 1.2em;
    font-size: 1.3em;
    width: 85%;
	  margin-top:15px;
  }

  .todo-item.done .todo-description {
    text-decoration: line-through;
  }

  .todo-item .todo-title {
    color: white;
    margin: 0 -20px;
    padding: 15px 20px;
    font-size: 1.4em;
    line-height: 2em;
    font-weight: bold;
    cursor: pointer;
  }

  .todo-item .todo-title .icon-checkbox {
    display: none;
  }

  .todo-item .todo-title:hover .icon-checkbox-outline {
    display: none;
  }

  .todo-item .todo-title:hover .icon-checkbox {
    display: block;
  }

  .todo-item .todo-priority {
    -webkit-appearance: none;
    font-size: 1em;
    text-shadow: none;
    line-height: 1.2em;
    border-radius: 3px;
    border: 3px solid #fff;
    color: white;
    cursor: pointer;
    position: absolute;
    bottom: 0;
    right: 0;
    padding: 3px 5px;
  }

  .todo-item.new {
    border: 2px dashed darkblue;
    flex: 2 1 1;
  }

  .new .todo-title {
    background-color: #2980b9;
    cursor: pointer;
    padding: 40px 20px;
    font-size: 1.2em;
  }

  .todo-item .pad-15 {
    padding: 15px;
  }

  .high .todo-title,
  .high .todo-priority,
  .high [class*='icon'] {
    background-color: #cd4436;
  }

  .medium .todo-title,
  .medium .todo-priority,
  .medium [class*='icon'] {
    background-color: #2ac56c;
  }

  .low .todo-title,
  .low .todo-priority,
  .low [class*='icon'] {
    background-color: #f19f0f;
  }

  .todo-list .icon-delete {
    position: absolute;
    right: 0px;
    text-decoration: none;
    padding: 0 10px;
    cursor: pointer;
    color: #fff;
    z-index: 0;
    cursor: pointer;
  }

  .todo-list .icon-delete:hover::after {
    color: #fff;
  }

  .todo-list .icon-delete:hover::before {
    opacity: 1;
    -webkit-transform: translateX(-50%) translateY(-50%) scale(1);
    -moz-transform: translateX(-50%) translateY(-50%) scale(1);
    transform: translateX(-50%) translateY(-50%) scale(1);
    z-index: -1;
  }

  .todo-list .icon-delete::before {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 40px;
    height: 40px;
    border: 2px solid #ccc;
    border-radius: 50%;
    content: '';
    opacity: 0;
    background: #000;
    color: white;
    z-index: -1;
    -webkit-transition: -webkit-transform 0.3s, opacity 0.3s;
    -moz-transition: -moz-transform 0.3s, opacity 0.3s;
    transition: transform 0.3s, opacity 0.3s;
    -webkit-transform: translateX(-50%) translateY(-50%) scale(0.2);
    -moz-transform: translateX(-50%) translateY(-50%) scale(0.2);
    transform: translateX(-50%) translateY(-50%) scale(0.2);
  }

  .todo-list-completed .todo-item {
    color: darkgrey;
    font-weight: bold;
    border-bottom: 2px solid #eee;
    display: flex;
    justify-content: space-between;
    background: #fff;
    position: relative;
  }

  .todo-list-completed .icon-delete {
    display: none;
    cursor: pointer;
  }

  .todo-list-completed .todo-item:hover .icon-check {
    display: none;
  }

  .todo-list-completed .todo-item:hover .icon-delete {
    display: block;
  }

  .todo-list-completed .todo-item .content {
    padding: 15px 10px;
    flex: 1;
    font-size: 1.2em;
    text-decoration: line-through;
  }

  /** TODO List **/

  li {
    list-style-type: none;
  }

  /** Footer **/

  .footer {
    font-size: 1.5em;
    color: #D2527F;
    width: 100%;
    margin: 0 auto;
    padding: 10px 0;
    text-align: center;
    opacity: .6;
    background-color: #22313F;
  }

  .footer [class*=icon] {
    font-size: 1.4em;
    padding: 10px 10px;
    line-height: 1.5em;
    vertical-align: sub;
  }

  span.action {
    float: left;
    margin: 0 15px 0 0;
  }

  /** font icons **/

  /* Rules for sizing the icon. */

  .material-icon .material-icons.md-18 {
    font-size: 18px;
  }

  .material-icons.md-24 {
    font-size: 24px;
  }

  .material-icons.md-36 {
    font-size: 36px;
  }

  .material-icons.md-48 {
    font-size: 48px;
  }

  /* Rules for using icons as black on a light background.*/

  .material-icons.md-dark {
    color: rgba(0, 0, 0, 0.54);
  }

  .todo-item.done .material-icons.md-dark,
  .material-icons.md-dark:hover {
    color: rgba(255, 255, 255, 1);
  }

  .material-icons.md-dark:hover {
    -webkit-animation: spin .8s ease-in-out 1;
    -moz-animation: spin .8s ease-in-out 1;
    animation: spin .8s ease-in-out 1;
  }

  .material-icons.md-light {
    color: rgba(255, 255, 255, 1);
  }

  .material-icons.md-light.md-inactive {
    color: rgba(255, 255, 255, 0.3);
  }

  @-moz-keyframes spin {
    100% {
      -moz-transform: rotate(360deg);
    }
  }

  @-webkit-keyframes spin {
    100% {
      -webkit-transform: rotate(360deg);
    }
  }

  @keyframes spin {
    100% {
      -webkit-transform: rotate(360deg);
      transform: rotate(360deg);
    }
  }

</style>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Muli:300' rel='stylesheet' type='text/css'>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">
            Tasks for Service Migration
             
          </h3>

        </div>

        <div class="panel-body">
          <div class="container" style="width:100%;">
            <div class="todo-list-container">
              <div class="todo-in-progress">
                <ul ondragstart="" class="todo-list" id="target">

                  <?php $args = array(
'post_type' => 'tasks',
'posts_per_page' => 999,
'meta_query' => array( array(
        'key' => 'engineer',
        'value' => $current_user->user_login ,
),
array(
		'key' => 'status',
        'value' => 'open' ,
      ),
    ),
    ); 
        $the_query = new WP_Query( $args );

if ($the_query->have_posts()) : {  

 while ( $the_query->have_posts() ) : $the_query->the_post(); ?>


                  <li class="todo-item <?php $meta_key = 'priority'; $id = get_the_id();?>
    <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = ''; ?>">
                    <div class="card">

                      <h3 class="todo-title">
                        <span class="title">
    <?php $meta_key = 'task_title'; $id = get_the_id();?>
          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = ''; ?>
    
 
  
</span></h3>

                      <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <th style="padding: 12px 10px;"></th>
                      <th style="padding: 12px 10px;">Service Migration</th>
                      <th style="padding: 12px 10px;">Date Created</th>
                      <th style="padding: 12px 10px;">User</th>
                      <th style="padding: 12px 10px;">Due Date</th>
                      <th style="padding: 12px 10px;">Engineer</th>
                      <th style="padding: 12px 10px;">Status</th>

                    </tr>
                     <tr>
                      <td></td>
                      <td style="padding: 12px 10px;">
                        <?php $meta_key = 'task_title'; $id = get_the_id();?>
                        <a data-title="Service Migration" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td style="padding: 12px 10px;">
                        <?php $meta_key = 'date_created'; $id = get_the_id();?>
                        <a data-title="Date Created" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td style="padding: 12px 10px;">
                        <?php $meta_key = 'user'; $id = get_the_id();?>
                        <a data-title="User" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td style="padding: 12px 10px;">
                        <?php $meta_key = 'due_date'; $id = get_the_id();?>
                        <a data-title="Due Date" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td style="padding: 12px 10px;">
                        <?php $meta_key = 'engineer'; $id = get_the_id();?>
                        <a data-title="Engineers" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td style="padding: 12px 10px;">
                        <?php $meta_key = 'status'; $id = get_the_id();?>
                        <a data-title="Status" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      
                    </tr> <span class="todo-priority"> <?php $meta_key = 'priority'; $id = get_the_id();?>
<?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = ''; ?>  </span></table></div> <?php endwhile; // echo '</table></div>'; ?>

<?php } else : 
  echo 'notasks'; endif?> </p>
                      

                    </div>

                  </li>

                </ul>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#migrations">
  Add Migration
</button>

                <!-- Modal -->
                <div class="modal fade" id="migrations" tabindex="-1" role="dialog" aria-labelledby="migrationslabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="migrationalabel">Create Migration</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                      </div>
                      <div class="modal-body">
                        <?php echo do_shortcode("[ninja_form id=19]"); ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
                </div>


<div class="todo-completed">
                <ul class="todo-list-completed">
                  <h2> Completed Tasks </h2>

<?php $args = array(
'post_type' => 'tasks',
'posts_per_page' => 999,
'meta_query' => array( array(
        'key' => 'engineer',
        'value' => $current_user->user_login ,
      ),
      array(
          'key' => 'status',
              'value' => 'closed' ,
    ),
    ),
    ); 
        $the_query = new WP_Query( $args );

if ($the_query->have_posts()) : {  

 while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

              
                  <li class="todo-item <?php $meta_key = 'priority'; $id = get_the_id();?>
    <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = ''; ?>">
                    <div class="icon-check">
                      <i class="pad-15 material-icons md-36 md-light">check_circle</i>
                    </div>

                    <div class="icon-delete">
                      <i class="pad-15 material-icons md-36 md-light">delete</i>
                    </div>
                    <div class="content">
                      <?php $meta_key = 'description'; $id = get_the_id();?>
                        <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';	?>
                    </div>
                  </li>
					<?php endwhile ?>

                        <?php } else : 
  echo 'notasks'; endif; wp_reset_postdata();?>
                </ul>
              </div> 
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php get_template_part('client', 'box');?>



      <?php get_template_part('footer', 'simple');?>



      <?php get_footer(); ?>
      </div>