<div class="row margin0">
	<div class="col-md-2 col-xs-12">
		<?php echo __('note',$field) ?>
	</div>
	<div class="col-md-10 col-xs-12 box-gallery" data-variable ='gallery_control_admin_<?php echo $field['name'] ?>'>
		<?php $galleriesJson = isset($dataitem)? $dataitem[$field['name']]:'' ;
           	$galleries = json_decode($galleriesJson,true);
           	$galleries = is_array($galleries)?$galleries:[];
            ?>
		<textarea class="hidden" name="<?php echo $field['name'] ?>" id="<?php echo $field['name'] ?>" data-type="GALLERY_CONTROL_ADMIN.VIEW"><?php echo $galleriesJson ?></textarea>
		<div class="gallery_control_admin_list" >
           <ul class="gallery_ul gallery_ul_<?php echo $field['name'] ?>">
           	
            <?php foreach($galleries as $gallery): ?>
            	<?php $file = $gallery["path"].$gallery["file_name"]; $file= file_exists($file)?$file:'theme/frontend/plugins/gallery_control_admin/theme/images/no-image.svg'; ?>
            	<?php  $this->load->helper(array('string'));  $idfile = random_string() ?>
	            <li class="col-sm-3 col-xs-12 gallery-item">
	                 <div>
	                    <span tagname="gallery"></span> <img class="img-responsive " name="gallery_control_admin_list_<?php echo $idfile ?>" id="gallery_control_admin_list_<?php echo $idfile ?>" rel="lib_img" dt-file='<?php echo json_encode($gallery) ?>' src="<?php echo $file ?>" alt="<?php echo $gallery['file_name'] ?>"> 
	                    <p><?php echo $gallery['file_name'] ?></p>
	                    <i class="icon-remove gallery-close"></i> <a href="Techsystem/Media/media?istiny=gallery_control_admin_list_<?php echo $idfile ?>&callback=GALLERY_CONTROL_ADMIN_PROVIDER.callback" class="iframe-btn button" type="button">Chọn hình</a> 
	                 </div>
	            </li>
            <?php endforeach ?>
           </ul>
      </div>
    <div class="btnadmin">
    	<a href="javascript:void(0);" class="btn gallery_ul_<?php echo $field['name'] ?>_add " type="button">Add 1 Image</a>
    </div>
    <div class="btnadmin">
    	<a href="Techsystem/Media/media?istiny=gallery_control_admin_<?php echo $field['name'] ?>&callback=GALLERY_CONTROL_ADMIN_PROVIDER.callback_multi" class="btn gallery_ul_<?php echo $field['name'] ?>_add_multi iframe-btn" type="button">Add Images</a>
    </div>
	</div>
</div>
<style type="text/css">
	.gallery_control_admin_list{
	    width: 80%;
		max-height: 250px;
		border: 1px solid #E0E0E0;
		overflow-y: scroll;
	}
	.gallery_control_admin_list .gallery_ul{
		padding: 0;
	}
	.gallery_control_admin_list .gallery_ul .gallery-item >div{
		position: relative;
		background: #ececec;
		height: 102px;
	}
	.gallery_control_admin_list .gallery_ul .gallery-item img{
		margin:0 auto;
		max-height: 102px;
	}
	.gallery_control_admin_list .gallery_ul .gallery-item{
		position: relative;
		    padding-top: 15px;
	}
	.gallery_control_admin_list .gallery_ul .gallery-item p {
	    position: absolute;
	    bottom: 0;
	    left: 0;
	    width: 100%;
	    background: rgba(0, 0, 0, 0.55);
	    color: #fff;
	    padding: 3px;
	    text-align: center;
	    margin: 0;
	}
	.gallery_control_admin_list .gallery_ul .gallery-item .gallery-close {
position: absolute;
    top: -13px;
    right: -13px;
    font-size: 20px;
    z-index: 1;
    border-radius: 50%;
    width: 27px;
    height: 27px;
    text-align: center;
    cursor: pointer;
    color: #fff;
    background: #ff1515!important;
    line-height: 27px;
	}
	.gallery_control_admin_list .gallery_ul .gallery-item .button {
    	position: absolute;
	    top: 0;
	    left: 0;
	    right: 0;
	    bottom: 0;
	    margin: auto;
	    width: 100px;
	    height: 30px;
	    background: #00923f;
	    color: #fff;
	    border: none;
	    text-transform: uppercase;
	    visibility: hidden;
	    display: block;
	    text-align: center;
	    padding-top: 7px;
	}
	.gallery_control_admin_list .gallery_ul .gallery-item:hover .button {
	    visibility: visible;
	}
	.gallery_control_admin_list .gallery_ul .gallery-item.selected {
	    opacity: 0.4;
	}
</style>
<script type="text/javascript">
	$(function() {
		window['gallery_control_admin_<?php echo $field['name'] ?>'] = new GALLERY_CONTROL('<?php echo $field['name'] ?>');
		window['gallery_control_admin_<?php echo $field['name'] ?>'].init();
	});
</script>