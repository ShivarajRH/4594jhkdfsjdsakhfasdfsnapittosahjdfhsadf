<div class="container">
    <div class="">
        <form>
            <select id="sel_territory" >
                <option value="00">All Territory</option>
                <?php 
                    foreach($pnh_terr as $terr)
                    {
                ?>
                        <option value="<?php echo $terr['id'];?>"><?php echo $terr['territory_name'];?></option>
                <?php
                    }
                ?>
                
            </select>
            <select id="sel_town">
                <option value="00">All Towns</option>
                
            </select>
            <select id="sel_franchise">
                <option value="00">All Franchise</option>
            </select>
        </form>
        <div class="sel_status"></div>
    </div>
    <hr>
    <div id="franchise_order_list_wrapper" style="clear: both; z-index: 9 !important;">
        <div id="franchise_ord_list" style="clear: both;overflow: hidden">
                <table width="100%" >
                        <tr>
                                <td>
                                        <div class="tab_list" style="clear: both;overflow: hidden">
                                                    <ol>
                                                            <li><a class="load_type" id="all" href="javascript:void(0)">All</a><div class="all_pop"></div></li>
                                                            <li><a class="load_type" id="shipped" href="javascript:void(0)">Shipped</a><div class="shipped_pop"></div></li>
                                                            <li><a class="load_type" id="unshipped" href="javascript:void(0)">UnShipped</a><div class="unshipped_pop"></div></li>
                                                            <li><a class="load_type" id="cancelled" href="javascript:void(0)">Cancelled</a><div class="cancelled_pop"></div></li>
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
    //ENTRY 6
    $("#sel_town").live("change",function() {
        var townid=$(this).find(":selected").val();//text();
        if(townid=='00') {
            $(".sel_status").html("Please select town."); return false;
        }
        
        var terrid=$("table").data("sdata").terrid;
        if(!terrid) {
            $(".sel_status").html("Please select territory first."); return false;
        }
        
        $("table").data("sdata", {terrid:terrid,townid:townid});
        
        
        var url="<?php echo site_url("admin/jx_suggest_fran"); ?>"+"/"+terrid+"/"+townid;
        
        $.post(url,success_town,'json').done(done).fail(fail);
        return false;
    });
    
    function success_town(resp) {
        if(resp.status=='success') {
            //print(resp.towns);
            var obj = jQuery.parseJSON(resp.franchise);
            $("#sel_franchise").html(objToOptions_franchise(obj));
        }
        else {
            $(".sel_status").html(resp.message);
        }
    }
    function objToOptions_franchise(obj) {
        var output='';
            output += "<option value='00' selected>Select Franchise</option>\n";
        $.each(obj,function(key,elt){
            if(obj.hasOwnProperty(key)) {
                output += "<option value='"+elt.franchise_id+"'>"+elt.franchise_name+"</option>\n";
            }
        });
        return(output);
    }
    
    //ENTRY 5
    $("#sel_territory").live("change",function() {
        var terrid=$(this).find(":selected").val();//text();
        if(terrid=='00') {
            $(".sel_status").html("Please select territory."); return false;
        }
        
        $("table").data("sdata", {terrid:terrid});
        var url="<?php echo site_url("admin/jx_suggest_townbyterrid"); ?>/"+terrid;//  alert(url);
        $.post(url,success_terr,'json').done(done).fail(fail);
        return false;
    });
    
    function success_terr(resp) {
        if(resp.status=='success') {
             print(resp.towns);
             var obj = jQuery.parseJSON(resp.towns);
            
            //    $(".sel_status").html(objToOptions(obj));
            $("#sel_town").html(objToOptions_terr(obj));
                    
        }
        else {
            $(".sel_status").html(resp.message);
        }
    }
    function objToOptions_terr(obj) {
        var output='';
            output += "<option value='00' selected>Select Town</option>\n";
        $.each(obj,function(key,elt){
            if(obj.hasOwnProperty(key)) {
                output += "<option value='"+elt.id+"'>"+elt.town_name+"</option>\n";
            }
        });
        return(output);
    }
    
    //ENTRY 1
    $(".load_type").bind("click",function(e){
        e.preventDefault();
        var stat=this.id;
        var url="<?php echo site_url("admin/jx_orders_status_summary"); ?>";
        //2. date
        var date_from=$( "#date_from").val();
        var date_to=$( "#date_to").val();
        $("table").data("sdata", { terrid:0,townid:0,franchid:0,type:stat,date_from:date_from,date_to:date_to, issorting : "no",idname:'',classname:'',firstrun:'no',pagination:"false",url:url });
        
        load_all_orders(stat);
        return false;
    });
    //ENTRY 2
    $("#ord_list_frm").bind("submit",function(e){
        e.preventDefault();
        var stat='1';
        var url="<?php echo site_url("admin/jx_orders_status_summary"); ?>";
        //2. date
        var date_from=$( "#date_from").val();
        var date_to=$( "#date_to").val();
        
        $("table").data("sdata", {terrid:0,townid:0,franchid:0,type:'all',date_from:date_from,date_to:date_to,  issorting : "no",idname:'',classname:'',firstrun:'no',pagination:"false",url:url });
        load_all_orders(stat);
        return false;
    });
    
    //ENTRY 3
    $("#orders_status_pagination a").live("click",function(e){
             e.preventDefault();
            var ajax_url=$(this).attr('href');
            
            $("table").data("sdata", { terrid:0,townid:0,franchid:0, issorting : "no",idname:'',classname:'',firstrun:'no',pagination:"true",url:ajax_url });
            load_all_orders_pagelink(ajax_url);
            return false;
    });
    
    //ENTRY 4
    $(document).ready(function() {    
        //FIRST RUN
        var reg_date = "<?php echo date('m/d/Y',  time());?>";
        $( "#date_from").datepicker({
             changeMonth: true,
             dateFormat:'yy-mm-dd',
             numberOfMonths: 1,
             maxDate:0,
             //minDate: new Date(reg_date),
               onClose: function( selectedDate ) {
                 $( "#date_to" ).datepicker( "option", "minDate", selectedDate ); //selectedDate
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

        loadTableData();
    
    });
    
    
    function load_all_orders_pagelink(ajax_url) {
        $('.orders_status_summary_div').html("3. Loading...");
        $("table").data("sdata", { terrid:0,townid:0,franchid:0,type: fil_ordersby,date_from:date_from,date_to:date_to, issorting : "no",idname:'',classname:'',firstrun:'no',pagination:"true",url:ajax_url });
        print("3. "+ajax_url);
        //return false;
        $.post(ajax_url,success)
        .done(done)
        .fail(fail);
    }
    var fil_ordersby = 'all';
    
    function load_all_orders(stat) {
        
            var url=$("table").data("sdata").url;
            var pagination=$("table").data("sdata").pagination;
            var date_from=$("table").data("sdata").date_from;
            var date_to=$("table").data("sdata").date_to;
            var terrid=$("table").data("sdata").terrid;
            var townid=$("table").data("sdata").townid;
            var francid=$("table").data("sdata").francid;
            
            var ajax_url;
            
            
            
            //1. type
		if(stat != '1')
			fil_ordersby = stat;
		
            $('.tab_list .selected').removeClass('selected');
            $('.tab_list #'+fil_ordersby).addClass('selected');
                
            
            			
		$('#ord_list_frm input[name="type"]').val(fil_ordersby);
		
		$('.orders_status_summary_div').html("2. Loading...");
                
                var indata="/"+fil_ordersby+"/"+date_from+"/"+date_to;
                
//                if(pagination=='true') {ajax_url=url;}else {
                    
//                }

                ajax_url=url+indata;
                print("2. "+ajax_url);
                
                //return false;
		$.post(ajax_url,success)
                .done(done)
                .fail(fail);
		return false;
	}
    
//    function load_all_orders_date(stat) {
//        
//            var url=$("table").data("sdata").url;
//            var pagination=$("table").data("sdata").pagination;
//            var ajax_url;
//            //1. type
//		if(stat != '1')
//			fil_ordersby = stat;
//		
//            $('.tab_list .selected').removeClass('selected');
//            $('.tab_list #'+fil_ordersby).addClass('selected');
//                
//            //2. date
//                var date_from=$( "#date_from").val();
//                var date_to=$( "#date_to").val();
//                
//                
//            //3. pagination
//                $("table").data("sdata", { type: fil_ordersby,date_from:date_from,date_to:date_to, issorting : "no",idname:'',classname:'',firstrun:'no',pagination:"true",url:url });
//                	
//				
//		$('#ord_list_frm input[name="type"]').val(fil_ordersby);
//		
//		$('.orders_status_summary_div').html("3. Loading...");
//                
//                var indata="/"+fil_ordersby+"/"+date_from+"/"+date_to;
//                
//                if(pagination=='true') {
//                    ajax_url=url;
//                }
//                else {
//                    ajax_url=url+indata;
//                }
//                print("2. "+ajax_url);
//                
//                //return false;
//		$.post(ajax_url,success)
//                .done(done)
//                .fail(fail);
//		return false;
//	}
         
           function loadTableData() {
                //var url=$("table").data("sdata").url;
                //var pagination=$("table").data("sdata").pagination;
                //var date_from=$("table").data("sdata").date_from;
                //var date_to=$("table").data("sdata").date_to;
                
                var url="<?php echo site_url("admin/jx_orders_status_summary"); ?>";
                var type='all';   //$('#franchise_ord_list_frm').attr('action')
                
                
                
                $('.tab_list .selected').removeClass('selected');
		$('.tab_list #'+type).addClass('selected');
                
                $('.orders_status_summary_div').html("1. Loading...");

                
                
                //2. date
                var date_from=$( "#date_from").val();
                var date_to=$( "#date_to").val();
                $("table").data("sdata", { type:'all',date_from:date_from,date_to:date_to, issorting : "no",idname:'',classname:'',firstrun:'true',pagination:"false",url:url });
                
                //pagination:
                
                //var indata=$("#ord_list_frm").serialize()+"&type="+type;
                var indata="/"+fil_ordersby+"/"+date_from+"/"+date_to+"";
                
                
                print(url+indata);
                
                $.post(url+indata,success)
                .done(done)
                .fail(fail);
           }
 
        function done(data) { }
	function fail(xhr,status) { $('.orders_status_summary_div').print("Error: "+xhr.responseText+" "+xhr+" | "+status);}
        function success(resp) {
                $('.orders_status_summary_div').html(resp);
        }
  
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

/*PAGINATION*/
.orders_pagination {
    float: left;
}
.all_pop, .shipped_pop, .unshipped_pop, .cancelled_pop {
    font-size:11px;
    text-align: center;
    float: right;
    border-radius: 4px 4px;
    padding: 2px 2px;
}
.all_pop {
    margin-top: -40px;
}
.shipped_pop {
    margin-top: -40px;
}
.unshipped_pop {
     margin-top: -40px;
}
.cancelled_pop {
     margin-top: -40px;
}
.popbg{
    color: #ffffff;
    background-color: #78201C;
}
</style>	


<?php
