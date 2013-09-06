<div class="container">
    <div class="">
        <form>
            <select id="sel_territory" >
                <option value="00">All Territory</option>
                <?php foreach($pnh_terr as $terr):?>
                        <option value="<?php echo $terr['id'];?>"><?php echo $terr['territory_name'];?></option>
                <?php endforeach;  ?>
            </select>
            <select id="sel_town">
                <option value="00">All Towns</option>
                <?php foreach($pnh_towns as $town): ?>
                        <option value="<?php echo $town['id'];?>"><?php echo $town['town_name'];?></option>
                <?php endforeach; ?>
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
                                                            <li><a class="load_type selected" id="all" href="javascript:void(0)">All</a><div class="all_pop"></div></li>
                                                            <li><a class="load_type" id="shipped" href="javascript:void(0)">Shipped</a><div class="shipped_pop"></div></li>
                                                            <li><a class="load_type" id="unshipped" href="javascript:void(0)">UnShipped</a><div class="unshipped_pop"></div></li>
                                                            <li><a class="load_type" id="cancelled" href="javascript:void(0)">Cancelled</a><div class="cancelled_pop"></div></li>
                                                            <li><a class="load_type" id="removed" href="javascript:void(0)">Batch Disabled</a><div class="removed_pop"></div></li>
                                                    </ol>
                                            </div>
                            </td>
                            <td align="right">
                                    <div >
                                            <form id="ord_list_frm" method="post">
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
    //ENTRY 7
    $("#sel_franchise").live("change",function() {
        loadTableData(0);
        return false;
    });
    
    //ENTRY 6
    $("#sel_town").live("change",function() { 
        var townid=$(this).find(":selected").val();//text();
        var terrid=$("#sel_territory").find(":selected").val();//text();
        var url="<?php echo site_url("admin/jx_suggest_fran"); ?>"+"/"+terrid+"/"+townid;
        $.post(url,function(resp) {
            if(resp.status=='success') {
                     var obj = jQuery.parseJSON(resp.franchise);
                    $("#sel_franchise").html(objToOptions_franchise(obj));
                }
                else {
                    $("#sel_franchise").val($("#sel_franchise option:nth-child(0)").val());
                    //$(".sel_status").html(resp.message);
                }
            },'json').done(done).fail(fail);
        
        loadTableData(0);
        return false;
    });
    
    
    //ENTRY 5
    $("#sel_territory").live("change",function() {
        var terrid=$(this).find(":selected").val();//text();
//        if(terrid=='00') {          $(".sel_status").html("Please select territory."); return false;        }
        
       // $("table").data("sdata", {terrid:terrid});
        var url="<?php echo site_url("admin/jx_suggest_townbyterrid"); ?>/"+terrid;//  alert(url);
        $.post(url,function(resp) {
            if(resp.status=='success') {
                 print(resp.towns);
                 var obj = jQuery.parseJSON(resp.towns);
                $("#sel_town").html(objToOptions_terr(obj));
            }
            else {
                $("#sel_town").val($("#sel_town option:nth-child(0)").val());
                $("#sel_franchise").val($("#sel_franchise option:nth-child(0)").val());
                            //$(".sel_status").html(resp.message);
            }
        },'json').done(done).fail(fail);
        loadTableData(0);
        return false;
    });
     
     $(".tab_list a").bind("click",function(e){
         $(".tab_list a.selected").removeClass('selected');
         $(this).addClass('selected');
         loadTableData(0);
     });
     
    //ENTRY 2
    $("#ord_list_frm").bind("submit",function(e){
        e.preventDefault();
        loadTableData(0);
        return false;
    });
    
    function loadTableData(pg) {

         var type = $('.tab_list .selected').attr('id');
         var date_from=$( "#date_from").val();
         var date_to=$( "#date_to").val();
         var terrid= ($("#sel_territory").val()=='00')?0:$("#sel_territory").val();
         var townid=($("#sel_town").val()=='00')?0:$("#sel_town").val();
         var franchiseid=($("#sel_franchise").val()=='00')?0:$("#sel_franchise").val();

         //$("table").data("sdata", { terrid :terrid,townid:townid, franchiseid:franchiseid, type:type,date_from:date_from,date_to:date_to, issorting : "no",idname:'',classname:'',firstrun:'true',pagination:"false",url:url });
         $('.orders_status_summary_div').html("Loading...");
         $.post(site_url+"/admin/jx_orders_status_summary"+"/"+type+"/"+date_from+"/"+date_to+'/'+terrid+'/'+townid+'/'+franchiseid+'/'+pg,{},function(resp){
            $('.orders_status_summary_div').html(resp);
         });
    }
    
    //ENTRY 3
    $(".orders_status_pagination a").live("click",function(e){
        e.preventDefault();
        $('.orders_status_summary_div').html("Loading...");
        $.post($(this).attr('href'),{},function(resp){
            $('.orders_status_summary_div').html(resp);
        });
        return false;
    });
 
    function done(data) { }
    function fail(xhr,status) { $('.orders_status_summary_div').print("Error: "+xhr.responseText+" "+xhr+" | "+status);}
    function success(resp) {
            $('.orders_status_summary_div').html(resp);
    }
       
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

         loadTableData(0);
    
    });
    function objToOptions_terr(obj) {
        var output='';
            output += "<option value='00' selected>All Towns</option>\n";
        $.each(obj,function(key,elt){
            if(obj.hasOwnProperty(key)) {
                output += "<option value='"+elt.id+"'>"+elt.town_name+"</option>\n";
            }
        });
        return(output);
    }
    function objToOptions_franchise(obj) {
        var output='';
            output += "<option value='00' selected>All Franchise</option>\n";
        $.each(obj,function(key,elt){
            if(obj.hasOwnProperty(key)) {
                output += "<option value='"+elt.franchise_id+"'>"+elt.franchise_name+"</option>\n";
            }
        });
        return(output);
    }
    
  
</script>
<style>
.leftcont {        display: none;    }
select {    margin: 15px 0 15px 5px; }
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
		padding:5px 34px;
		font-size: 15px;
		color: #454545;
		cursor:pointer;
                font-weight: bold;
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
.orders_status_pagination {
    float: right;
    font-size: 16px;
    margin: 6px 40px 6px 0;
}
.ttl_orders_status_listed {
    margin:0 2px;
    font-weight: bold;text-align: center;font-size: 1.17em;float: left;
}
.c2 {
    margin:0 2px 0 540px;
    font-weight: bold;text-align: center;font-size: 1.17em;float: left;
}
.all_pop, .shipped_pop, .unshipped_pop, .cancelled_pop, .removed_pop {
    font-size:11px;
    text-align: center;
    float: right;
    border-radius: 10px 10px;
    padding: 5px 5px;
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
.removed_pop {
     margin-top: -40px;
}
.popbg{
    color: #ffffff;
    background-color: #78201C;
}
</style>	


<?php
