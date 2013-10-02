 <div class="tjjd">

  <div class="dianping"> <span class="more"><a href="<?php  echo site_url("/allcity") ?>">更多</a></span>

    <ul class="citybg">

      <?php 

        $ci = & get_instance();

        $ci->load->model('model_common');

        $ci->load->model('model_city');

        $ci->load->library('tool');

        

        $cityInfo = $ci->model_common->initCityinfo();

        $cityid = $cityInfo['cityid'];

        

        //热门城市列表

        $hotCityList = $ci->model_city->getInitCityList();

        $listNum = count($hotCityList);

        

        $tuijianHotelList = $ci->model_common->getTuijianHotel($cityid);

        foreach($tuijianHotelList as $key=>$val){

            $tuijianHotelList[$key]['df_haoping']=$this->tool->hoteldianping($val['df_haoping'],2);    

            $tuijianHotelList[$key]['xingji']=$this->tool->hotelrankname($val['xingji']);    

        }

        

        $i = 0;

        foreach($hotCityList as $val){ 

            $i++;

      ?>                                          

      

      <?php } ?>

    </ul>

    <span><font style="color:#f60;">推荐</font>酒店</span>

  </div>

  

  <div class="tjbotm" id="tuijianhotel_div">

    <?php 

        foreach ($tuijianHotelList as $key=>$val){

    ?>

    <div class="tjplate">

       <dl>

        <dt><a href="<?php  echo site_url("/hotelinfo/{$val['ID']}") ?>" title="<?php echo $val['HotelName'] ?>"><img src="<?php echo $val['Picture']  ?>" width="147" height="112" alt='<?php echo $val['HotelName'] ?>'/></a></dt>

        <dd>

          <ul>

            <li class="tjbt"><a href="<?php  echo site_url("/hotelinfo/{$val['ID']}") ?>" title="<?php echo $val['HotelName'] ?>"><?php echo $val['HotelName']  ?></a></li>

            <li>类型：<?php echo $val['xingji']  ?></li>

            <li>价格：<font class="f_b1_f00">￥<?php echo $val['min_jiage']  ?></font>起</li>

            <li>好评：<font class="f_b1_f00"><?php echo $val['df_haoping'][0]  ?></font></li>

            <li>位置：<?php echo $val['Address']  ?></li>

          </ul>

        </dd>

      </dl>

       <div class="yinying"></div>

    </div>

    <?php } ?>

  </div>

  

</div>