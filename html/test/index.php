<script src="/admin/js/jquery-3.3.1.min.js"></script>
<link rel="stylesheet" href="/admin/css/font-awesome.css" type="text/css">

<script type="text/javascript">
$(document).ready(function(){
$('#submit').click(function(){
	var $loader=$('#loader').show();
	//$submit=$(this).find('[type="submit"]').prop('disabled',true);
    
    $.ajax({
        type:"POST",
        url:"tenthousandsinserts.php",
        cache: false,
        success: function(){
            $loader.hide();
			$submit.prop('disabled',false);
        }
    });
});
});
</script>


<style type="text/css">
#loader{
	display:none;
}
</style>

<form id="form">
<div id="loader">
	<i class="fa fa-spin fa-spinner"></i>
</div>
<input id="submit" type="submit"/>
<div id="success"></div>
</form>