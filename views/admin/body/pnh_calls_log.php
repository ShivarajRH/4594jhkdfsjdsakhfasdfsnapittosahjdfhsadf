<div id="container">
<h2 class="page_title">PNH Calls Summary</h2>

<div class="tab_view" >
<!--    <div class="dash_bar" id="dash_bar" style="cursor: pointer;float: right; margin-right: 52%;"></div>-->
    <ul>
        <li><a href="#callsmade">Calls Made</a></li>
        <li><a href="#receivedcalls">Received Calls</a></li>
    </ul>
    <div id="callsmade">
        <div class="tab_view tab_view_inner">
            <ul>
                <li><a href="#all_calls">All Calls</a></li>
                <li><a href="#busy_calls">Busy</a></li>
                <li><a href="#attended_calls">Attended</a></li>
            </ul>
            
            <div id="all_calls" style="padding:0px !important;">
                <div class="tab_view tab_view_inner">
                <ul>
                    <li><a href="#tofranchise" class="trg_onload" onclick="load_callslog_data(this,'callsmade','all_calls','tofranchise',0)">To Franchise</a></li>
                    <li><a href="#toexecutive" onclick="load_callslog_data(this,'callsmade','all_calls','toexecutive',0)">To Executive</a></li>
                    <li><a href="#tounknown" onclick="load_callslog_data(this,'callsmade','all_calls','tounknown',0)">To Unknown</a></li>
                </ul>
                    
                <div id="tofranchise" >
                        <h4>To Franchise </h4>
                        
                        <div class="tab_content"></div>
                </div>
                <div id="toexecutive">
                    <h4>To Executive</h4>
                    <div class="tab_content"></div>
                </div>
                <div id="tounknown">
                    <h4>Unknown Calls</h4>
                    <div class="tab_content"></div>
                </div>


                </div>
            </div>
            
            <div id="busy_calls" style="padding:0px !important;">
                <div class="tab_view tab_view_inner">
                <ul>
                    <li><a href="#tofranchise" class="trg_onload" onclick="load_callslog_data(this,'callsmade','busy_calls','tofranchise',0)">To Franchise</a></li>
                    <li><a href="#toexecutive" onclick="load_callslog_data(this,'callsmade','busy_calls','toexecutive',0)">To Executive</a></li>
                    <li><a href="#tounknown" onclick="load_callslog_data(this,'callsmade','busy_calls','tounknown',0)">To Unknown</a></li>
                </ul>
                <div id="tofranchise" >
                        <h4>To Franchise </h4> 
                        <div class="tab_content"></div>
                </div>
                <div id="toexecutive">
                <h4>To Executive</h4>
                    <div class="tab_content"></div>
                </div>
                <div id="tounknown">
                <h4>Unknown Calls</h4>
                    <div class="tab_content"></div>
                </div>


                </div>
            </div>
            
            <div id="attended_calls" style="padding:0px !important;">
                <div class="tab_view tab_view_inner">
                <ul>
                    <li><a href="#tofranchise" class="trg_onload" onclick="load_callslog_data(this,'callsmade','attended_calls','tofranchise',0)">To Franchise</a></li>
                    <li><a href="#toexecutive" onclick="load_callslog_data(this,'callsmade','attended_calls','toexecutive',0)">To Executive</a></li>
                    <li><a href="#tounknown" onclick="load_callslog_data(this,'callsmade','attended_calls','tounknown',0)">To Unknown</a></li>
                </ul>
                <div id="tofranchise" >
                        <h4>To Franchise </h4> 
                        <div class="tab_content"></div>
                </div>
                <div id="toexecutive">
                <h4>To Executive</h4>
                    <div class="tab_content"></div>
                </div>



                <div id="tounknown">
                <h4>Unknown Calls</h4>
                    <div class="tab_content"></div>
                </div>

                </div>
            </div>
        </div>
    </div>
    
    <div id="receivedcalls">
        <div class="tab_view tab_view_inner">
            <ul>
                <li><a href="#all_calls">All Calls</a></li>
                <li><a href="#busy_calls">Busy</a></li>
                <li><a href="#attended_calls">Attended</a></li>
            </ul>
             
            <div id="all_calls" style="padding:0px !important;">
                <div class="tab_view tab_view_inner">
                <ul>
                    <li><a href="#tofranchise" class="trg_onload" onclick="load_callslog_data(this,'receivedcalls','all_calls','tofranchise',0)">To Franchise</a></li>
                    <li><a href="#toexecutive" onclick="load_callslog_data(this,'receivedcalls','all_calls','toexecutive',0)">To Executive</a></li>
                    <li><a href="#tounknown" onclick="load_callslog_data(this,'receivedcalls','all_calls','tounknown',0)">To Unknown</a></li>
                </ul>
                    
                <div id="tofranchise" >
                        <h4>To Franchise </h4>
                        
                        <div class="tab_content"></div>
                </div>
                <div id="toexecutive">
                    <h4>To Executive</h4>
                    <div class="tab_content"></div>
                </div>
                <div id="tounknown">
                    <h4>Unknown Calls</h4>
                    <div class="tab_content"></div>
                </div>


                </div>
            </div>
            
            <div id="busy_calls" style="padding:0px !important;">
                <div class="tab_view tab_view_inner">
                    <ul>
                        <li><a href="#tofranchise" class="trg_onload" onclick="load_callslog_data(this,'receivedcalls','busy_calls','tofranchise',0)">To Franchise</a></li>
                        <li><a href="#toexecutive" onclick="load_callslog_data(this,'receivedcalls','busy_calls','toexecutive',0)">To Executive</a></li>
                        <li><a href="#tounknown" onclick="load_callslog_data(this,'receivedcalls','busy_calls','tounknown',0)">To Unknown</a></li>
                    </ul>
                    <div id="tofranchise">
                        <h4>To Franchise</h4>
                        <div class="tab_content"></div>
                    </div>
                    
                    <div id="toexecutive">
                        <h4>To Executive</h4>
                        <div class="tab_content"></div>
                    </div>
                    <div id="tounknown">
                        <h4>Unknown Calls</h4>
                        <div class="tab_content"></div>
                    </div>
                </div>
            </div>
            <div id="attended_calls" style="padding:0px !important;">
                <div class="tab_view tab_view_inner">
                    <ul>
                        <li><a href="#tofranchise" class="trg_onload" onclick="load_callslog_data(this,'receivedcalls','attended_calls','tofranchise',0)">To Franchise</a></li>
                        <li><a href="#toexecutive" onclick="load_callslog_data(this,'receivedcalls','attended_calls','toexecutive',0)">To Executive</a></li>
                        <li><a href="#tounknown" onclick="load_callslog_data(this,'receivedcalls','attended_calls','tounknown',0)">To Unknown</a></li>
                    </ul>
                    <div id="tofranchise" >
                            <h4>To Franchise </h4> 
                            <div class="tab_content"></div>
                    </div>
                    <div id="toexecutive">
                    <h4>To Executive</h4>
                        <div class="tab_content"></div>
                    </div>
                    <div id="tounknown">
                    <h4>Unknown Calls</h4>
                        <div class="tab_content"></div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>



</div>

</div>

<script>
    function print(str) { console.log("= "+str+" ="); }
    function print_obj(resp) { for(var key in resp) {print('' + key + ' => ' + resp[key]+ '\n');} }
	function show_log() {
		location.href = site_url+'/admin/pnh_exsms_log/'+$('#inp_date').val();
	}
	
	function  load_callslog_data(ele,p1,p2,c,pg){
            var scrolldiv= "#"+p1+" #"+p2+" "+$(ele).attr('href')+' div.tab_content';
            $(scrolldiv).html('<div align="center"><img src="'+base_url+'/images/jx_loading.gif'+'"></div>');
            var posturl=site_url+'admin/jx_getpnh_calls_log/'+p1+'/'+p2+'/'+c+"/"+pg;
            var items_info=$("#dash_bar");
            
            $.post(posturl,'',function(resp){ 
                print_obj(resp);
                if(resp.status=='fail') {
//                    $("#dash_bar").html(resp.items_info);
                    $(scrolldiv).html("<br>"+resp.response);//resp.status
                }    
                else if(resp.status=='success') {
//                    items_info.html(resp.items_info);
                    $(scrolldiv).html(resp.log_data+resp.pagi_links);
                    $(scrolldiv+' .datagridsort').tablesorter();
                    return false;
                }
            },'json')
            .done(done)
            .fail(fail);
	}
        function done(data) { }
	function fail(xhr,status) { print(xhr.responseText+" "+xhr+" | "+status);
            //.toSource()
        }
	$('#inp_date').datepicker();
	
	$('.tab_view').tabs();
	$('.datagridsort').tablesorter( {sortList: [[0,0]]} );

	$('.log_pagination a').live('click',function(e){
		e.preventDefault();
		$.post($(this).attr('href'),'',function(resp){
                var scrolldiv= "#"+resp.p1+" #"+resp.p2+" #"+resp.c+' div.tab_content';
                
                if(resp.status=='fail') {
//                    $("#dash_bar").html(resp.items_info);
                    $(scrolldiv).html("<br>"+resp.response);//resp.status
                }    
                else if(resp.status=='success') {
                    $(scrolldiv).html(resp.log_data+resp.pagi_links);
//                    $("#dash_bar").html(resp.items_info);
//                    $(".dash_bar").html("Showing <strong>"+parseInt(resp.newpg)+"</strong> to <strong>"+parseInt(resp.limit)+'</strong> of <strong>'+parseInt(resp.tbl_total_rows)+"</strong>");
                    $(scrolldiv+' .datagridsort').tablesorter();
                }
                return false;
        },'json');
	});
	
	$('.trg_onload').trigger('click');

</script>