<?php 

    $ci = & get_instance();

    $ci->load->model('model_common');

    $orderList = $ci->model_common->getOderList(6);

?>

<?php foreach ($orderList as $key=>$val){ ?>

<dl>

    <dt>

        <span><font class="f_666"><?php echo $val['tel']; ?></font><font class="f_999">预订</font></span>

        <font class="f_999"><?php echo $val['time']; ?></font> 

    </dt>

    <dd> 

        <span class="jiage">￥<?php echo $val['jiang']; ?></span><a href="<?php  echo site_url("/hotelinfo/{$val['hotelid']}") ?>" title="<?php echo $val['hotelname'] ?>"><?php echo $val['hotelname']; ?></a>    

    </dd>

</dl>

<?php } ?>