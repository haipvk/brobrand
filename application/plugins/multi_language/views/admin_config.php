<div id="Breadcrumb" class="Block Breadcrumb ui-widget-content ui-corner-top ui-corner-bottom">
    <ul>
        <li class="home"><a href="<?php echo base_url(''); ?>Techsystem"><i class="icon-home" style="font-size:14px;"></i> <?php echo alang("HOME") ?></a></li>
        <li class="SecondLast"><a href="Techsystem/view_plugins/multi_language">Cấu hình Multi Language</a></li>
    </ul>
</div>
<?php $config = @$config?$config:[];
$this->db->select('name,note');
$q = $this->db->get('nuy_table');
$tables = $q->result_array();
$configTables = isset($config['tables'])?$config['tables']:[];
$defaultLang = isset($config['languages']['list'])?$config['languages']['default']:'';
$listLangs = isset($config['languages']['list'])?$config['languages']['list']:[];
 ?>
<div id="cph_Main_ContentPane " class="multi_language">
    <div class="row">
      <h3 class="col-xs-12 title">Lựa chọn bảng sử dụng Multi Language</h3>
    </div>
    <div class="row">
        <?php foreach($tables as $table): ?>
            <div class="col-xs-12 col-md-4">
            <input <?php echo array_key_exists($table['name'], $configTables) && $configTables[$table['name']]['value']==1?'checked':'' ?> type="checkbox" class='table_input_lang' id='_<?php echo $table['name'] ?>'  value="<?php echo $table['name'] ?>">
            <label for="_<?php echo $table['name'] ?>"><?php echo $table['note'] ?></label>
            </div>
            <?php endforeach ?>
        
    </div>
    <div class="row">
      <h3 class="col-xs-12 title">Lựa chọn ngôn ngữ</h3>
    </div>
    <div class="row">
    	<?php $langs = pFlags(); ?>
        <div class="col-xs-12">
        	<table class='table_lang'>
	        	<tr>
	        		<td>Ngôn ngữ mặc định</td>
	        		<td>
	        			<select class="default_language">
	        				<?php foreach($langs as $lang =>$vlang): ?>
	        				<option <?php echo $lang==$defaultLang?'selected':'' ?> value="<?php echo $lang ?>"><?php echo $vlang['name'] ?></option>
	        				<?php endforeach ?>
	        			</select>
	        		</td>
	        	</tr>
	        	<tr>
	        		<td>Lựa chọn các ngôn ngữ</td>
	        		<td>
	        			<?php foreach($langs as $lang=>$vlang): ?>
	        			<input <?php echo in_array($lang, $listLangs)?'checked':'' ?> class="choose_language" value="<?php echo $lang ?>" id="<?php echo $lang ?>" type="checkbox">
	        			<label for="<?php echo $lang ?>"><?php echo $vlang['name'] ?></label>
	        			<?php endforeach ?>
	        		</td>
	        	</tr>
	        </table>
        </div>
        
    </div>


	<div class="row">
		<div class="col-xs-12">
		    <form action="<?php echo 'Techsystem/extra?action='.base64_encode("table=news&action=view&code=multi_language"); ?>" method="post">
		        <textarea name="config" class="hidden"><?php echo json_encode($config); ?></textarea>
		        <div class="">
		        <button class="btn btn-primary" type="submit">Lưu</button>
		        </div>
		    </form>
    	</div>
	</div>
</div>
</div>
<script type="text/javascript">
    $(".multi_language input[type=checkbox], .multi_language select").change(function(event) {
        var json = {};
        var tables = {};
        var checkboxs = $(".multi_language input.table_input_lang[type=checkbox]");
        for (var i = 0; i < checkboxs.length; i++) {
            var checkbox = $(checkboxs[i]);
            var id = checkbox.attr("value");
            var value = checkbox.is(":checked")?1:0;;
            tables[id] = {"name":id,"value":value};
        }
        json['tables'] = tables;
        var languages = {};
        languages['default'] = $('.multi_language select.default_language').val();
        var chooses = $('.multi_language .choose_language');
        var list = [];
        for (var i = 0; i < chooses.length; i++) {
        	var item = $(chooses[i]);
        	if(item.is(':checked')){
        		list.push(item.val());
        	}
        }
        languages['list'] = list;
        json['languages'] = languages;
        $(".multi_language textarea[name=config]").val(JSON.stringify(json));
    });
</script>
<style type="text/css">
  .multi_language .title{
        text-align: center;
    margin: 0;
    text-transform: uppercase;
    background: #00923f;
    padding: 5px 0px;
    color: #fff;
  }
    .multi_language input[type=checkbox] + label {
  display: block;
  margin: 0.2em;
  cursor: pointer;
  padding: 0.2em;
}
.multi_language input[type=checkbox] {
  display: none !important;
}
.multi_language input[type=checkbox] + label:before {
  content: "\2714";
  border: 0.1em solid #000;
  border-radius: 0.2em;
  display: inline-block;
  width: 20px;
  height: 20px;
  padding-left: 0.2em;
  padding-bottom: 0.3em;
  margin-right: 0.2em;
  vertical-align: bottom;
  color: transparent;
  transition: .2s;
}
.multi_language input[type=checkbox] + label:active:before {
  transform: scale(0);
}
.multi_language input[type=checkbox]:checked + label:before {
  background-color: MediumSeaGreen;
  border-color: MediumSeaGreen;
  color: #fff;
}
.multi_language input[type=checkbox]:disabled + label:before {
  transform: scale(1);
  border-color: #aaa;
}
.multi_language input[type=checkbox]:checked:disabled + label:before {
  transform: scale(1);
  background-color: #bfb;
  border-color: #bfb;
}
.multi_language .table_lang{
	width:100%;
	margin: 10px 0px;
}
.multi_language .table_lang td{
	padding:5px;
	border: 1px solid #00923f;
}
</style>