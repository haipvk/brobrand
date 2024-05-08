<a href="<?php echo 'Techsystem/extra?action='.base64_encode("table=".$kiot_table."&action=view&code=warranty_add_date&id=".$item['id']);?>" data-id="<?php echo $item['id'] ?>" class="edit fnc add-date" title="Thêm ngày bảo hành"><i class="icon-plus"></i></a>
<script>
    if (typeof addDateWarranty == "undefined") { 
        function addDateWarranty(_this){
            var date = prompt("Nhập số ngày muốn thêm", "10");
            $.ajax({
                type: "POST",
                url: _this.attr('href'),
                data: {date:date,id:_this.data('id')},
                dataType: "json",
                success: function (response) {
                    window.location.reload();
                }
            });
        }
        $(document).on('click','.add-date',function(e){
            e.preventDefault();
            addDateWarranty($(this));
        })
    }
</script>
