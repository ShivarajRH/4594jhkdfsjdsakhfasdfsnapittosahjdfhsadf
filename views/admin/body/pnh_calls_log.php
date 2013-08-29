<div id="container">
<h2 class="page_title">PNH Calls Summary</h2>
<div class="tab_view" >
    <ul>
        <li><a href="#callsmade">Calls Made</a></li>
        <li><a href="#receivedcalls">Received Calls</a></li>
    </ul>
    <div id="callsmade">
        <div class="tab_view tab_view_inner">
            <ul>
                <li><a href="#missed_calls">Missed Calls</a></li>
                <li><a href="#attended_calls">Attended Calls</a></li>
            </ul>
            <div id="missed_calls" style="padding:0px !important;">
                <div class="tab_view tab_view_inner">
                <ul>
                    <li><a href="#tofranchise" class="trg_onload" onclick="load_callslog_data(this,'callsmade','missed_calls','tofranchise',0)">To Franchise</a></li>
                    <li><a href="#toexecutive" onclick="load_callslog_data(this,'callsmade','missed_calls','toexecutive',0)">To Executive</a></li>
                    <li><a href="#tounknown" onclick="load_callslog_data(this,'callsmade','missed_calls','tounknown',0)">To Unknown</a></li>
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
                <li><a href="#missed_calls">Missed Calls</a></li>
                <li><a href="#attended_calls">Attended Calls</a></li>
            </ul>
            <div id="missed_calls" style="padding:0px !important;">
                <div class="tab_view tab_view_inner">
                    <ul>
                        <li><a href="#tofranchise" class="trg_onload" onclick="load_callslog_data(this,'receivedcalls','missed_calls','tofranchise',0)">To Franchise</a></li>
                        <li><a href="#toexecutive" onclick="load_callslog_data(this,'receivedcalls','missed_calls','toexecutive',0)">To Executive</a></li>
                        <li><a href="#tounknown" onclick="load_callslog_data(this,'receivedcalls','missed_calls','tounknown',0)">To Unknown</a></li>
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
	function show_log()
	{
		location.href = site_url+'/admin/pnh_exsms_log/'+$('#inp_date').val();
	}
		
	function  load_callslog_data(ele,p1,p2,c,pg)
	{
            var scrolldiv= "#"+p1+" #"+p2+" "+$(ele).attr('href')+' div.tab_content';
            $(scrolldiv).html('<div align="center"><img src="'+base_url+'/images/jx_loading.gif'+'"></div>');
            var posturl=site_url+'admin/jx_getpnh_calls_log/'+p1+'/'+p2+'/'+c+"/"+pg;
            print(posturl);
            $.post(posturl,'',function(resp){ //print(resp.Hi);
                    $(scrolldiv).html(resp.Hi);//resp.log_data+resp.pagi_links);
                    //$(scrolldiv+' .datagridsort').tablesorter();
            },'json')
            .done(done)
            .fail(fail);
	}
        function success1(resp) { //print(resp.Hi);
                    $(scrolldiv).html(resp.log_data+resp.pagi_links);
                    $(scrolldiv+' .datagridsort').tablesorter();
            }
	function done(data) { }
	function fail(xhr,status) { print(xhr.responseText+" "+xhr+" | "+status);
            //.toSource()
        }
	$('#inp_date').datepicker();
	$("#logdet_disp_terry").change(function(){
		load_callslog_data(loaded_logele,loaded_logtype,0,$(this).val()*1);
	});

	$('.tab_view').tabs();
	$('.datagridsort').tablesorter( {sortList: [[0,0]]} );

	$('.log_pagination a').live('click',function(e){
		e.preventDefault();
		$.post($(this).attr('href'),'',function(resp){
			$('#'+resp.type+' div.tab_content').html(resp.log_data+resp.pagi_links);
			$('#'+resp.type+' div.tab_content .datagridsort').tablesorter();
		},'json');
	});
	
	$('.trg_onload').trigger('click');

	$("#logdet_disp_terry").chosen();	

</script>