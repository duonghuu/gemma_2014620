<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
            <li><a href="index.php?com=anhnen&act=capnhat<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>"><span>Hình ảnh</span></a></li>
            <li class="current"><a href="#" onclick="return false;">Cập nhật hình ảnh</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">     
    function TreeFilterChanged2(){      
                $('#validate').submit();        
    }
</script>
<form name="supplier" id="validate" class="form" action="index.php?com=anhnen&act=save<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>" method="post" enctype="multipart/form-data">
    <div class="widget">
        <div class="title"><img src="./images/icons/dark/list.png" alt="" class="titleIcon" />
            <h6>Cập nhật hình ảnh</h6>
        </div>     
        

        
        
        
        <div class="formRow">
            <label>Màu nền :</label>
            <div class="formRight">
                <input type="text" name="color" value="<?=@$item['color']?>" class="input form-control short_input cp3" />
            </div>
            <div class="clear"></div>    
        </div>
        <style>
            .formRow input.short_input {
                width: 200px;
            }
        </style>
        
        <script>
            $(document).ready(function() {
                $('#picker').css('border-right','20px solid #<?=@$item['color']?>');
                $('#picker').css('border-color','#<?=@$item['color']?>'); 
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function(e) {
                $('#picker').colpick({
                    layout:'hex',
                    submit:0,
                    colorScheme:'dark',
                    onChange:function(hsb,hex,rgb,el,bySetColor) {
                        $(el).css('border-right','20px solid #'+hex);
                        $(el).css('border-color','#'+hex);
                        // Fill the text box just if the color was set using the picker, and not the colpickSetColor function.
                        if(!bySetColor) $(el).val(hex);
                    }
                }).keyup(function(){
                    $(this).colpickSetColor(this.value);
                });
            })
        </script>



    <div class="formRow">
        <div class="formRight">
            <input type="hidden" name="id" id="id_this_photo" value="<?=@$item['id']?>" />
            <input type="button" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
        </div>
        <div class="clear"></div>
    </div>     
        
    </div>
   
</form>   