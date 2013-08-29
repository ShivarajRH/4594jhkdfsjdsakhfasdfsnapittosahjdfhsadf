
<div class="container">

<div class="dash_bar">
<a href="<?=site_url("admin/products")?>"></a>
<span><?=$this->db->query("select count(1) as l from m_product_info")->row()->l?></span> Total products
</div>
<!--
<div class="dash_bar">
Showing <span><?=count($products)?></span> products
</div>--> 

<div class="dash_bar">
view by brand : <select id="prod_disp_brand">
<option value="0">select</option>
<?php foreach($this->db->query("select id,name from king_brands order by name asc")->result_array() as $b){?>
<option value="<?=$b['id']?>" <?=$b['id']==$this->uri->segment(3)?"selected":""?>><?=$b['name']?></option>
<?php }?>
</select>
</div>

<div class="dash_bar">
view by Tax : <select id="prod_disp_tax">
<option value="select">select</option>
<?php foreach($this->db->query("select vat as tax from m_product_info group by tax")->result_array() as $b){?>
<option value="<?=$b['tax']?>" <?=$b['tax']==$this->uri->segment(3)?"selected":""?>><?=$b['tax']?></option>
<?php }?>
</select>
</div>

<div class="clear"></div>

<h2><?=!isset($brand)&&!isset($tax)?"New ":""?>Products <?=isset($brand)?" of $brand brand":(isset($tax)?" with $tax% tax":"")?></h2>
<div style="float:right">
<span style="background:#faa;height:15px;width:15px;display:inline-block;">&nbsp;</span>-Not sourceable &nbsp; &nbsp; &nbsp;
<span style="background:#afa;height:15px;width:15px;display:inline-block;">&nbsp;</span>-sourceable &nbsp; &nbsp; &nbsp;
</div>

<a href="<?=site_url("admin/addproduct")?>">Add new product</a>
<?php
$output.='<table class="datagrid datagridsort" width="100%">
            <thead>
            <tr class="trheader">
                <th><input type="checkbox" class="chk_all"></th>
                <th><a class="header" id="th_pname" href="'.REQUEST_URI.'">Product Name</a></th>
                <th><a class="header" id="th_mrp" href="'.REQUEST_URI.'">MRP</a></th>
                <th><a class="header" id="th_stock" href="'.REQUEST_URI.'">Stock</a></th>
                <th><a class="header" id="th_barcode" href="'.REQUEST_URI.'">Barcode</a></th>
                <th><a class="header" id="th_brand" href="'.REQUEST_URI.'">Brand</a></th>
                <th></th>
            </tr>
            </thead>
            <tbody class="appendtodiv"></tbody>
            <div class="loading">&nbsp;</div>
            </table>';
echo $output;
?>

<div>With Selected : <input type="button" value="Mark it as Sourcable" onclick='mark_src("1")'> <input type="button" value="Mark it as Not-Sourcable" onclick='mark_src("0")'></div>
</div>

<form id="src_form" action="<?=site_url("admin/mark_src_products")?>" method="post">
    <input type="hidden" name="pids" class="pids">
    <input type="hidden" name="action" class="action" value="1">
</form>

<style type="text/css">
.busy{display:none;}
/* new */
.trheader a { text-decoration: none; width: 100%;    }
.link { float: left; }
.loading { background-image:url("http://static.snapittoday.com/loading_maroon.gif");  background-repeat: no-repeat; float: left; margin-left: 20px;width: 20px; visibility:hidden; }
</style>
<script type="text/javascript">
    /* START OF SORTING AND PAGINATION BY SDEV*/
    //FIRST RUN
    $(document).ready(function() {
        var url="<?php echo site_url("admin/jx_products"); ?>";
        $("table").data("sdata", { issorting : "no",idname:'',classname:'',firstrun:'true',pagination:"false",url:url });
        loadTableData();
    });
    //ONCLICK FIELD SORTING
    $(".trheader a").click(function(){
        var elt=$(this);
        var url=get_jx_url(this.href);
        change_class(elt);
        var idname=elt.attr("id");
        var classname=elt.attr("class");
        $("table").data("sdata", { issorting : "yes",idname:idname,classname:classname,firstrun:'false',pagination:"false",url:url });
        loadTableData();
        return false;
    });
    
    function change_class(elt) {
        var elt_header=$(".trheader a.header");
        var num_classes = (elt.attr('class').trim().split(" ")).length;
        //print(num_classes);
        if(num_classes == 1) {
            elt.removeClass("headerSortUp headerSortDown");
        }
        if(!elt.hasClass("headerSortUp")) { 
            elt.removeClass("headerSortDown");
            elt.addClass("headerSortUp");
        }
        else { 
            elt.removeClass("headerSortUp");  
            elt.addClass("headerSortDown"); 
        }
        return true;
    }
    function print(str) { console.log(str); }
    function get_jx_url(url_x) {
        url1=url_x.split("//");
        var newstr = url1[1].split("/");
        var pagenum=0;
        if(newstr[4] != null) { pagenum=newstr[4]; }
        var url=("<?php echo site_url("admin/jx_products"); ?>"+"/"+pagenum);
        return url;
    }
    function loadTableData() {
        var loading=$(".loading");loading.css({"visibility":"visible"});
        var issorting=$("table").data("sdata").issorting;
        var idname=$("table").data("sdata").idname;
        var classname=$("table").data("sdata").classname;
        var firstrun=$("table").data("sdata").firstrun; 
        var pagination=$("table").data("sdata").pagination; 
        var ajax_url=$("table").data("sdata").url;  
        var jqxhr='';
        
        if(firstrun=='true') {  //alert("1"+ajax_url);
            jqxhr=$.post(ajax_url,{idname:'',classname : ''},success)
            .done(done)
            .fail(function(data) { loading.css({"visibility":"hidden"});  alert("1. Error:\nURL: ["+ajax_url+"]\n"+"OUTPUT: ["+data+"]"); })
            .always(always);
        }
        else if(issorting=='yes') { //alert("2"+ajax_url);
             jqxhr=$.post(ajax_url,{idname:idname,classname : classname},success)
            .done(function() { loading.css({"visibility":"hidden"}); $("."+classname).addClass("headerSortDown"); })
            .fail(function(data) { loading.css({"visibility":"hidden"});  alert("2. Error:\nURL: ["+ajax_url+"]\n"+"OUTPUT: ["+data+"]"); })
            .always(always);
        }
        else if(pagination == "true") {//alert("3\n"+ajax_url+"\n"+classname);
            jqxhr=$.post(ajax_url,{idname:idname,classname : classname},success)
            .done(done)
            .fail(function(data) { loading.css({"visibility":"hidden"});  alert("3. Error:\nURL: ["+ajax_url+"]\n"+"OUTPUT: ["+data+"]"); })
            .always(always);
        }
        return false;
    }
    function done() { var loading=$(".loading"); loading.css({"visibility":"hidden"});  }
    function always() { var loading=$(".loading"); loading.css({"visibility":"hidden"});  }
    function success(data,textStatus, jqXHR) {
        $(".loading").css({"visibility":"visible"});
        $(".appendtodiv").html(data);
        
        $(".link a").click(function(){
            var issorting=$("table").data("sdata").issorting;
            var idname=$("table").data("sdata").idname;
            var classname=$("table").data("sdata").classname;
            var firstrun=$("table").data("sdata").firstrun; 
            var pagination=$("table").data("sdata").pagination; 
            //var ajax_url=$("table").data("sdata").url;

            var url=get_jx_url(this.href);
            var elt=$(this);
            change_class(this.href);
            $("table").data("sdata", { issorting : issorting,idname:idname,classname:classname,firstrun:'false',pagination:"true",url:url } ); 
            loadTableData();
            return false; 
        });
    }
    //function success22(data,textStatus, jqXHR) { alert(data);  }
    /* END OF SORTING AND PAGINATION */
function mark_src(act)
{
	var pids=[];
	$(".p_check:checked").each(function(){
		pids.push($(this).val());
	});
	pids=pids.join(",");
	$("#src_form .action").val(act);
	$("#src_form .pids").val(pids);
	$("#src_form").submit();
}
$(function(){
	$(".barcode_forms").submit(function(){
		$(".busy",$(this).parent()).show();
		$(this).hide();
		f=$(this);
		$.post(f.attr("action"),f.serialize(),function(data){
			f.show();
			$(".busy",f.parent()).hide();
		});
		return false;
	});
	$(".chk_all").click(function(){
		if($(this).attr("checked"))
			$(".p_check").attr("checked",true);
		else
			$(".p_check").attr("checked",false);
	});
	$("#prod_disp_tax").change(function(){
		v=$(this).val();
		if(v!="select")
			location='<?=site_url("admin/productsbytax")?>/'+v;
	});
	$(".barcode_inp").focus(function(){
		$(this).data("ol_val",$(this).val());
		$(this).val("");
	}).blur(function(){
		if($(this).val().length==0)
			$(this).val($(this).data("ol_val"));
	});
	$("#prod_disp_brand").change(function(){
		v=$(this).val();
		if(v!=0)
			location='<?=site_url("admin/productsbybrand")?>/'+v;
	});
});
</script>
<?php
