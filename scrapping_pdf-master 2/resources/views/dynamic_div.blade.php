<?php
  foreach ($other_div as $key=>$value) {
?>
<div class="row active" data-div-id="<?php echo $value->div_id; ?>">
            <div class="col-lg-1 d-flex items-center justify-content-center card vertical-text">
              <span class="remove_me" style="cursor: pointer;"><b>Academic year <?php echo $key + 1 ?></b></span>
            </div>
            <div class="col-lg-11">
          <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="card">
                <div class="text-center">
                <p class="text-black b mb0">Fall <?php echo $value->div_1_year; ?> semester</p>
                <?php
                  $total = 0;
                  if($value){
                   
                   //echo "<pre>"; print_r($items); die;
                   if($value->div_1_mark){
                    $beta = unserialize($value->div_1_mark);
                    //print_r($items); die;
                    if($beta){
                      foreach ($beta as $teta) {
                        $keka = unserialize($teta);
                        $total = $total + $keka['attempted'];
                      }
                    }
                  }
                  }
                ?>

                <span><?php echo $total; ?> Credit Hours</span>
              </div>
              <hr class="mt1" />
              <div class="mh3" data-main="no" data-div="div_1" data-div-id="<?php echo $value->div_id; ?>">
                &nbsp;
                <?php
                  if($value){
                   
                   //echo "<pre>"; print_r($items); die;
                   if($value->div_1){
                    $items = unserialize($value->div_1);

                    foreach ($items as $item) {
                      ?>
                        <div data-main="no"  data-div="div_1" data-div-id="<?php echo $value->div_id; ?>" style="cursor: pointer;" class="card mt1 mb0 pa2 move_me"><?php echo $item; ?>   <i class="material-icons delete_card" style="padding-left: 90%;">delete</i></div>
                      <?php
                    }
                  }
                  }
                ?>
              </div>
              <hr class="mb1" />
                <div class="d-flex items-center pointer mb1">
                  <div class="main_div" style="display: none;">
                    <input type="text" name="my_val" class="my_val"data-type="others" data-page-id="<?php echo $page_id; ?>" style="margin: 5px;">
                    <span class="add_course_top_bar_in_db btn btn-success btn-sm" data-page-id="<?php echo $page_id; ?>">Save</span>
                    <span class="add_course_top_bar_in_cancel btn btn-warning btn-sm" data-page-id="<?php echo $page_id; ?>">Cancel</span>
                  </div>
                  <i class="material-icons">add</i>
                  <span class="add_course_top_bar" data-page-id="<?php echo $page_id; ?>">Add course</span>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="card">
                <div class="text-center">
                <p class="text-black b mb0">Spring <?php echo $value->div_2_year; ?> semester</p>

                <?php
                  $total = 0;
                  if($value){
                   
                   //echo "<pre>"; print_r($items); die;
                   if($value->div_2_mark){
                    $beta = unserialize($value->div_2_mark);
                    //print_r($items); die;
                    if($beta){
                      foreach ($beta as $teta) {
                        $keka = unserialize($teta);
                        $total = $total + $keka['attempted'];
                      }
                    }
                  }
                  }
                ?>

                <span><?php echo $total; ?> Credit Hours</span>
              </div>
              <hr class="mt1" />
              <div class="mh3" data-main="no" data-div="div_2" data-div-id="<?php echo $value->div_id; ?>" id="<?php echo $value->div_id; ?>">
                &nbsp;
                <?php
                  if($value){
                   
                   if($value->div_2){
                   $items = unserialize($value->div_2);
                   foreach ($items as $item) {
                      ?>
                        <div data-main="no"  data-div="div_2" data-div-id="<?php echo $value->div_id; ?>" style="cursor: pointer;" class="card mt1 mb0 pa2 move_me"><?php echo $item; ?> <i class="material-icons delete_card" style="padding-left: 90%;">delete</i></div>
                      <?php
                   }
                  }
                  }
                ?>
              </div>
              <hr class="mb1" />
                <div class="d-flex items-center pointer mb1">
                  <div class="main_div" style="display: none;">
                    <input type="text" name="my_val" class="my_val"data-type="others" data-page-id="<?php echo $page_id; ?>" style="margin: 5px;">
                    <span class="add_course_top_bar_in_db btn btn-success btn-sm" data-page-id="<?php echo $page_id; ?>">Save</span>
                    <span class="add_course_top_bar_in_cancel btn btn-warning btn-sm" data-page-id="<?php echo $page_id; ?>">Cancel</span>
                  </div>
                  <i class="material-icons">add</i>
                  <span class="add_course_top_bar" data-page-id="<?php echo $page_id; ?>">Add course</span>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="card">
                <div class="text-center">
                <p class="text-black b mb0">Summer <?php echo $value->div_3_year; ?> semester</p>

                <?php
                  $total = 0;
                  if($value){
                   
                   //echo "<pre>"; print_r($items); die;
                   if($value->div_3_mark){
                    $beta = unserialize($value->div_3_mark);
                    //print_r($items); die;
                    if($beta){
                      foreach ($beta as $teta) {
                        $keka = unserialize($teta);
                        $total = $total + $keka['attempted'];
                      }
                    }
                  }
                  }
                ?>

                <span>0 Credit Hours</span>
              </div>
              <hr class="mt1" />
              <div class="mh3" data-main="no"  data-div="div_3" data-div-id="<?php echo $value->div_id; ?>" id="<?php echo $value->div_id; ?>">
                &nbsp;
                <?php
                  if($value){
                   
                   if($value->div_3){
                    $items = unserialize($value->div_3);
                   foreach ($items as $item) {
                      ?>
                        <div data-main="no"  data-div="div_3" data-div-id="<?php echo $value->div_id; ?>" style="cursor: pointer;" class="card mt1 mb0 pa2 move_me"><?php echo $item; ?> <i class="material-icons delete_card" style="padding-left: 90%;">delete</i></div>
                      <?php
                   }
                  }
                  }
                ?>
              </div>
              <hr class="mb1" />
                <div class="d-flex items-center pointer mb1">
                  <div class="main_div" style="display: none;">
                    <input type="text" name="my_val" class="my_val"data-type="others" data-page-id="<?php echo $page_id; ?>" style="margin: 5px;">
                    <span class="add_course_top_bar_in_db btn btn-success btn-sm" data-page-id="<?php echo $page_id; ?>">Save</span>
                    <span class="add_course_top_bar_in_cancel btn btn-warning btn-sm" data-page-id="<?php echo $page_id; ?>">Cancel</span>
                  </div>
                  <i class="material-icons">add</i>
                  <span class="add_course_top_bar" data-page-id="<?php echo $page_id; ?>">Add course</span>
                </div>
              </div>
            </div>
           
          </div>
          </div>
          </div>


<?php        
  }
?>