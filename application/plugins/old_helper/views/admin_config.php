<div id="Breadcrumb" class="Block Breadcrumb ui-widget-content ui-corner-top ui-corner-bottom">
    <ul>
        <li class="home"><a href="<?php echo base_url(''); ?>Techsystem"><i class="icon-home" style="font-size:14px;"></i> <?php echo alang("HOME") ?></a></li>
        <li class="SecondLast"><a href="Techsystem/view_plugins/picture_helper">Cấu hình Plugin Picture</a></li>
    </ul>
</div>
<?php 
    $this->db->where("name","SIZE_IMAGE");
    $q = $this->db->get("nuy_config");
    $nuy_config = $q->result_array();
    $imagesizes = [];
    if(count($nuy_config)>0){
        $nuy_config = $nuy_config[0]["value"];
        $nuy_config = json_decode($nuy_config,true);
        $imagesizes = isset($nuy_config)?$nuy_config:[];
    }
    $config = isset($config)?$config:[];
    if(count($config)==0){
        $config["default"] = ["size"=>"def","media"=>"min-width:1200px"];
    }
?>
<div id="cph_Main_ContentPane " class="picture_helper">
	<div class="row">
		<form action="" method="post">
			<textarea name="config" class="hidden"><?php echo json_encode($config) ?></textarea>
            <?php $count = 0; ?>
            <?php foreach($config as $kconf=> $conf): ?>
    		<div class="col-xs-12 col-md-3 item">
    			<select class="size">
                    <option value="0">Không xác định</option>
                    <?php foreach($imagesizes as $size): ?>
                    <option <?php echo $kconf == $size['name']?'selected':'' ?> value ="<?php echo $size['name'] ?>"><?php echo $size['name'] ?></option>
                    <?php endforeach ?>
                </select>
                <input type="text" value="<?php echo $conf['media'] ?>" class="media">
                <?php if($count>0): ?>
                    <span class='delete'>X</span>
                <?php endif ;$count++;?>
    		</div>
            <?php endforeach ?>
		<div class="col-xs-12 text-center">
            <button type="button" class="add">Thêm</button>
			<button type="submit">Lưu</button>
		</div>
		</form>
	</div>
</div>
</div>
<script type="text/javascript">
	$(".add").click(function(event) {
        var clone = $(".picture_helper .item").first().clone();
        clone.find("input.media").val("");
        clone.find("select").val(0);
        clone.append("<span class='delete'>X</span>")
        $(".picture_helper form").prepend(clone);
    });
    $(document).on('click', '.picture_helper span.delete', function(event) {
        event.preventDefault();
        $(this).parents(".item").remove();
        calculatePictureHelper();
    });
    $(document).on('input', '.picture_helper input.media', function(event) {
        event.preventDefault();
        calculatePictureHelper();
    });
    $(document).on('change', '.picture_helper select.size', function(event) {
        event.preventDefault();
        calculatePictureHelper();
    });
    function calculatePictureHelper(){
        var items = $(".picture_helper .item");
        var json = [];
        for (var i = 0; i < items.length; i++) {
            var item = $(items[i]);
            var input = item.find("input");
            var select = item.find("select");
            if(select.val()=="0") continue;
            var tmp = {};
            tmp.media = input.val();
            tmp.size = select.val();
            json[tmp.size] = tmp;
        }
        $(".picture_helper textarea[name=config]").val(JSON.stringify({...json}));
    }
</script>
<style type="text/css">
  .picture_helper .item select,
	.picture_helper .item input{
    height: 25px;
    width: 49%;
    margin:0;
  }
  .picture_helper .item span.delete{
        position: absolute;
    background: red;
    color: #fff;
    padding: 7px;
    line-height: 16px;
    right: 0;
    top: 0;
    cursor: pointer;
  }
</style>