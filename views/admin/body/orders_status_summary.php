<div class="container">
    <div id="franchise_order_list_wrapper" style="clear: both; z-index: 9 !important;">
        <div id="franchise_ord_list" style="clear: both;overflow: hidden">
                <table width="100%" >
                        <tr>
                                <td>
                                        <div class="tab_list" style="clear: both;overflow: hidden">
                                                    <ol>
                                                            <li><a class="load_type" id="all" href="javascript:void(0)">All</a></li>
                                                            <li><a class="load_type" id="shipped" href="javascript:void(0)">Shipped</a></li>
                                                            <li><a class="load_type" id="unshipped" href="javascript:void(0)">UnShipped</a></li>
                                                            <li><a class="load_type" id="cancelled" href="javascript:void(0)">Cancelled</a></li>
                                                    </ol>
                                            </div>
                            </td>
                            <td align="right">
                                    <div ><?php // echo site_url('admin/jx_pnh_getfranchiseordersbydate');?>
                                            <form id="ord_list_frm" method="post" onsubmit="javascript:return load_all_orders(1);">
                                                    <input type="hidden" value="all" name="type" name="type">
                                                    <b>Show Orders </b> :
                                                    From :<input type="text" style="width: 90px;" id="date_from"
                                                            name="date_from" value="<?php echo date('Y-m-01',time())?>" />
                                                    To :<input type="text" style="width: 90px;" id="date_to"
                                                            name="date_to" value="<?php echo date('Y-m-d',time())?>" /> 
                                                    <input type="submit" value="Submit">
                                            </form>
                                    </div>
                            </td>
                    </tr>
                    <tr>
                            <td colspan="2" align="left">
                                     <div class="franchise_ord_list_content" style="clear:both;"></div>
                            </td>
                    </tr>
            </table>
        </div>
    </div>
    <div class="orders_status_summary_div">&nbsp;</div>
    
</div>

<script>
$(function(){ $("#from,#to").datepicker();});
function date_range()
{
	location="<?=site_url("admin/order_status_summary")?>/"+$("#from").val()+"/"+$("#to").val();
}
</script>


<script>
    $(".load_type").bind("click",function(e){
        e.preventDefault();
        var stat=this.id;

        load_all_orders(stat);
        return false;
    });
    $("#ord_list_frm").bind("submit",function(e){
        e.preventDefault();
        var stat='1';
        load_all_orders(stat);
        return false;
    });
    

    
    $(document).ready(function() {    
        //FIRST RUN
        var url="<?php echo site_url("admin/jx_orders_status_summary"); ?>";
         $("table").data("sdata", { type:'all', issorting : "no",idname:'',classname:'',firstrun:'true',pagination:"false",url:url });
         loadTableData();
     });
    
    var fil_ordersby = 'all';
    
    function load_all_orders(stat) {
            var ajax_url=$("table").data("sdata").url;
            
            //1. type
		if(stat != '1')
			fil_ordersby = stat;
		
            $('.tab_list .selected').removeClass('selected');
            $('.tab_list #'+fil_ordersby).addClass('selected');
                
            //2. date
                var date_from=$( "#date_from").val();
                var date_to=$( "#date_to").val();
                
                
            //3. pagination
            
                $("table").data("sdata", { type: fil_ordersby,date_from:date_from,date_to:date_to, issorting : "no",idname:'',classname:'',firstrun:'no',pagination:"true",url:ajax_url });
                	
				
		$('#ord_list_frm input[name="type"]').val(fil_ordersby);
		
		$('.orders_status_summary_div').html("Loading...");
                
                var indata="/"+fil_ordersby+"/"+date_from+"/"+date_to;
                
                print("2. "+ajax_url+"/"+indata);
                
                //return false;
		$.post(ajax_url+indata,function(resp){    //$('#ord_list_frm').serialize()
			$('.orders_status_summary_div').html(resp);
                        return false;
		},'html')
                .done(done)
                .fail(fail);
		return false;
	}
         
           function loadTableData() {
               var ajax_url=$("table").data("sdata").url;
               var type=$("table").data("sdata").type;   //$('#franchise_ord_list_frm').attr('action')
               //alert(ajax_url);
               
               var reg_date = "<?php echo date('m/d/Y',  time());?>";
               $( "#date_from").datepicker({
                    changeMonth: true,
                    dateFormat:'yy-mm-dd',
                    //numberOfMonths: 1,
                    //maxDate:0,
                    //minDate: new Date(reg_date),
                      onClose: function( selectedDate ) {
                      $( "#date_to" ).datepicker( "option", "minDate", selectedDate );
                    }
                  });
                $( "#date_to" ).datepicker({
                    changeMonth: true,
                    dateFormat:'yy-mm-dd',
                    numberOfMonths: 1,
                    maxDate:0,
                    onClose: function( selectedDate ) {
                      $( "#date_from" ).datepicker( "option", "maxDate", selectedDate );
                    }
                  });
                  
                prepare_daterange('date_from','date_to');
                
                $('.tab_list .selected').removeClass('selected');
		$('.tab_list .'+fil_ordersby).addClass('selected');
                
                $('.orders_status_summary_div').html("Loading...");

                var date_from=$( "#date_from").val();
                var date_to=$( "#date_to").val();
                
                //var indata=$("#ord_list_frm").serialize()+"&type="+type;
                var indata="/"+fil_ordersby+"/"+date_from+"/"+date_to;
                
                print(ajax_url+"/"+indata);
                
                $.post(ajax_url+indata,function(resp){
                        $('.orders_status_summary_div').html(resp); 
                })
                .done(done)
                .fail(fail);
           }
 
        function done(data) { }
	function fail(xhr,status) { $('.orders_status_summary_div').print("Error: "+xhr.responseText+" "+xhr+" | "+status);}
  
//  
        
                
        
/*function filter(prefix)
{
	if(prefix.length==0)
		$(".oitems").show();
	else{
		$(".oitems").hide();
		$(".o"+prefix).show();
	}
	$("#count").text($(".oitems:not(:hidden)").length);
	
	if(prefix == 'PNH')
	{
		$('.show_for_pnh').show();
		$('select[name="sel_pnh_menu"]').val("");
		$('select[name="sel_pnh_terr"]').val("");
	}else
	{
		$('.show_for_pnh').hide();
	}
	
}

$('select[name="sel_pnh_menu"] option:gt(0)').hide();
$('select[name="sel_pnh_terr"] option:gt(0)').hide();
$('.pnh_order').each(function(){
	var mid = $(this).attr('menu_id');
		$('.sel_menuid_'+mid).show();
		
	var terr_id = $(this).attr('terr_id');
		$('.sel_terrid_'+terr_id).show();	
});

$('select[name="sel_pnh_menu"]').change(function(){
	$('select[name="sel_pnh_terr"]').val("");
	if($(this).val() == "")
	{
		$(".oPNH").show();
	}else
	{
		$(".oPNH").hide();
		$('.pnh_m'+$(this).val()).show();
	}
	
	$("#count").text($(".oitems:not(:hidden)").length);
});

$('select[name="sel_pnh_terr"]').change(function(){
	$('select[name="sel_pnh_menu"]').val("");
	if($(this).val() == "")
	{
		$(".oPNH").show();
	}else
	{
		$(".oPNH").hide();
		$('.pnh_t'+$(this).val()).show();
	}
	
	$("#count").text($(".oitems:not(:hidden)").length);
});

filter("");
*/
</script>
<style>
.datagrid1 {border-collapse: collapse;border:none !important}
.datagrid1 th{border:none !important;font-size: 12px;padding:0px 0px;}
.datagrid1 td{border-right:none;border-left:none;border-bottom:1px dotted #ccc;font-size: 12px;}
.datagrid1 td a{text-transform: capitalize}
	#franchise_order_list_wrapper .tab_list{
		clear:both;
		display: block;
	}
	#franchise_order_list_wrapper .tab_list ol{
		padding-left:0px;
	}
	#franchise_order_list_wrapper .tab_list li{
		display: inline-block;
	}
	#franchise_order_list_wrapper .tab_list li a{
		display: block;
		background: #efefef;
		padding:5px 10px;
		font-size: 12px;
		color: #454545;
		cursor:pointer;
	}
	#franchise_order_list_wrapper .tab_list li a.selected{
		background: #555;
		color: #fff;
	}


.transit_link{
	border-radius:5px;
	background:#96C5E0;
	display:inline-block;
	padding:3px 7px;
	color:#fff;
}
.transit_link:hover{
	border-radius:0px;
	background:#3084C1;
	text-decoration:none;
}

.datagrid th{padding:12px 7px}
.datagrid1 {border-collapse: collapse;border:none !important}
.datagrid1 th{border:none !important;font-size: 13px;padding:0px 0px;}
.datagrid1 td{border-right:none;border-left:none;border-bottom:none;font-size: 12px;padding:2px;color: #444;text-transform: capitalize}
.datagrid1 td a{text-transform: capitalize}
.datagrid1 td b{font-weight: bold;font-size: 11px;}

</style>	


<?php