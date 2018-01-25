<script language="javascript">
/**
 * switch format between json and array
 */
function switchFormat(select) {
	$.ajax({
		"data": { "data": $("#row_data").val(), "format":select.value },
		"url": "index.php?action=collection.switchFormat&db=<?php h($db); ?>&collection=<?php h($collection); ?>",
		"type": "POST",
		"dataType": "json",
		"success": function (resp) {
			$("#row_data").val(resp.data);
		}
	});
}
function generateRandom(){
    $("#random").show();
    var data = $('#row_data').val();
    var json = $.parseJSON(data);
    var columns = "<option value=''>Select Column</option>";
    $.each(json,function(key,val){
        if($.isPlainObject(val)){
            $.each(val,function(key2,val2){
                if($.isPlainObject(val2)){
                    $.each(val2,function(key3,val3){
                        var v = key+"."+key2+"."+key3;
                        columns += "<option value='"+v+"'>"+v+"</option>";
                    });
                }else{
                    var v = key+"."+key2;
                    columns += "<option value='"+v+"'>"+v+"</option>";
                }
            });
        }else{
           var v = key;
           columns += "<option value='"+v+"'>"+v+"</option>";
        }
    });
    
    $('#columns').html(columns);
}
</script>

<h3><?php render_navigation($db,$collection,false); ?> &raquo; <?php hm("createrow"); ?></h3>

<?php if (isset($error)):?>
<p class="error"><?php h($error);?></p>
<?php endif; ?>
<?php if (isset($message)):?>
<p class="message"><?php h($message);?></p>
<?php endif; ?>

<form method="post">
<?php hm("format"); ?>:<br/>
<select name="format" onchange="switchFormat(this)">
<option value="array" <?php if($last_format=="array"): ?>selected="selected"<?php endif; ?>>Array</option>
<option value="json" <?php if($last_format=="json"): ?>selected="selected"<?php endif; ?>>JSON</option>
</select>
<br/>
<?php hm("data"); ?>
<br/>
<textarea rows="35" cols="70" name="data" id="row_data"><?php echo x("data") ?></textarea><br/>

<label>Repeat <input onchange="generateRandom()" type="number" name="count"  value="1" style="width:60px;text-align:center"/> times.</label><br/>
<div id="random" style="display:none">
    <label>Randomize <select name="columns" id="columns"></select></label>
</div>
<input type="submit" value="<?php hm("save"); ?>"/>
</form>
