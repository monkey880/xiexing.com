<div class="friend">

    <div class="fri_left">

    </div>

    <div class="fri_right">

        <ul>

            <?php 

            $ci = & get_instance();

            $ci->load->model('model_flink');

            $links = $ci->model_flink->getFlinkList(0,28,array('flink_type_radio'=>1),'`flink_order` asc');

            foreach ($links as $link){

            ?>        

            <li><a href="<?php echo $link['flink_link']?>" target="_blank"><?php echo $link['flink_title']?></a></li>

            <?php }?>

        </ul>

    </div>

</div>