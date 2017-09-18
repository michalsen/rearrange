    <div class="panel panel-info">
      <div class="panel-heading">
          <img src="<?php print plugins_url(); ?>/rearrange/assets/images/rearrange.png" width="200px">
       </div>
       <div class="panel-body">

    <div id="post_list">

      <?php

       $posts = getPosts();
       foreach ($posts as $key => $value) {
         if (preg_match('/(<img .*?>)/', $value->post_content)) {
           print $value->post_content;
           print '<br>';
         }
       }

      ?>
    <form action="/wp-admin/tools.php?page=rearrange" method=POST>
      <!-- <a href="/wp-admin/tools.php?page=rearrange&action=forward">Put image in front</a> -->
      <a href="/wp-admin/tools.php?page=rearrange&action=back">Put image in back</a>
    </form>
    </div>



    <div class="clear"></div>



    </div>
  </div>
