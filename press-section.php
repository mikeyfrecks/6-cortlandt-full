<?php
function post_types_init() {

//PROPERTY
$propargs = array(
  'label' => 'Press',
  'public' => false,
  'labels' => array(
    'add_new_item' => 'Add New Press Item',
    'name' => 'Press',
    'edit_item' => 'Edit Press Item',
    'search_items' => 'Search Press',
    'not_found' => 'No press items Found.',
    'all_items' => 'All Press'
  ),
  'show_ui' => true,
  'capability_type' => 'post',
  'hierarchical' => false,
  'has_archive' => false,
  'rewrite' => array('slug' => 'press'),
  'query_var' => true,
  'menu_icon' => 'dashicons-media-document',
  'supports' => array(
      'title',
      'revisions',
      'thumbnail',
    )
  );
register_post_type( 'press', $propargs );



}

add_action( 'init', 'post_types_init' );

//UI

//BOTTOM CONTENT

add_action('admin_footer-post.php', 'press_ui_content');
add_action('admin_footer-post-new.php', 'press_ui_content');
function press_ui_content() {

	global $post;
  if($post->post_type !== 'press') {
    return;
  }
  ?>
  <div id="required-field-list-template" style="display:none;" class="postbox ">
    <h2 class="hndle ui-sortable-handle"><span>Please make sure you set the following:</span></h2>
    <ul id="required-field-list">
      <li class="title">
        Title
      </li>
      <li class="excerpt">
        Excerpt

      </li>
      <li class="read">Read More Link</li>
      <li class="image">Featured Image <i class="description">(optional)</i></li>
    </ul>


  </div>
  <script>
  jQuery(document).ready(function($){
    $('#submitdiv').after($('#required-field-list-template'));
    $('#required-field-list-template').show();

    var docType = $('input[name=press-read-more-link_link-type]:checked').val();
    docSwitcher();
    $('input[name=press-read-more-link_link-type]').on('change',function(){
      docSwitcher();
    });

    function docSwitcher() {
      docType = $('input[name=press-read-more-link_link-type]:checked').val();
      if(docType == 'external') {
        $('#press-read-more-link li.row-document').hide();
        $('#press-read-more-link li.row-external-site-url').show();
      } else {
        $('#press-read-more-link li.row-document').show();
        $('#press-read-more-link li.row-external-site-url').hide();
      }
    }

    function stateChecker() {
      var ready = true;
      $('#required-field-list-template li').addClass("success");
      $('#publishing-action input.button').removeAttr('disabled');

    
      //CHECK TITLE
      var title = $('input#title').val();
      if(title == '') {
        ready = false;
        $('#required-field-list-template li.title').removeClass("success");
      }
      //CHECK EXCERPT
      var excerpt = $('textarea[name="press-excerpt_copy"]').val();
      if(excerpt == '') {
        ready = false;
        $('#required-field-list-template li.excerpt').removeClass("success");
      }
      //CHECK READ MORE
      if(docType == 'external') {
        if($('input[name="press-read-more-link_external-site-url"]').val() == '') {
          ready = false;
          $('#required-field-list-template li.read').removeClass("success");
        }
      } else {
        if($('input[name="press-read-more-link_document"]').val() == '') {
          ready = false;
          $('#required-field-list-template li.read').removeClass("success");
        }
      }
      // FEATURED IMAGE
      var img = $('#set-post-thumbnail > img').attr('src');
      if(img == undefined) {
        $('#required-field-list-template li.image').removeClass("success");
      }
      //BUTTON
      if(ready == false) {
        $('#publishing-action input.button').attr('disabled','');
      }
    }

    stateChecker();


    setInterval(function(){
      stateChecker();
    },1000);
  });



  </script>
  <style>
  /*#46b450*/
  #required-field-list li {
    position:relative;
    min-height:20px;
    padding-left:30px;
    margin-left: 10px;
    margin-right:10px;
  }
  #required-field-list li.success {
    color:#46b450;
  }
  #required-field-list li:before {
    display:block;
    content:'';
    width:15px;
    height: 15px;
    position:absolute;
    left: 0;
    top: -2px;
    border-radius:50%;
    border:1px solid rgba(238,238,238,1);
  }
  #required-field-list li.success:before {
    border-color:#46b450;
    background: #46b450;
  }


  </style>
  <?php
}

?>