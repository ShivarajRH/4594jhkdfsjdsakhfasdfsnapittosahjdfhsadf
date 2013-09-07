<?php
//          join pnh_m_territory_info f on f.id = d.territory_id
//          join pnh_m_franchise_info d on d.franchise_id = c.franchise_id
//          join pnh_towns e on e.id = d.town_id 

    $fil_menulist = array();
    $fil_brandlist = array();
    
    $cond = '';
   if($menuid!=00) {
        $cond .= ' and deal.menuid='.$menuid;
    }
   if($brandid!=00) {
        $cond .= ' and deal.brandid='.$brandid;
    }
   if($terrid!=00) {
        $cond .= ' and d.territory_id='.$terrid;
    }
    if($townid!=00) {
        $cond .= ' and d.town_id='.$townid;
    }
    if($franchiseid!=00) {
        $cond .= ' and d.franchise_id='.$franchiseid;
    }
//    echo $cond; die();
        $sql_all = "select distinct deal.brandid,deal.menuid,m.name as menu_name,br.name as brand_name,c.transid,sum(o.i_coup_discount) as com,c.amount,o.transid,o.status,o.time,o.actiontime,pu.user_id as userid,pu.pnh_member_id 
                    from king_orders o 
                    join king_transactions c on o.transid = c.transid 
                    join pnh_member_info pu on pu.user_id=o.userid 
                    join pnh_m_franchise_info d on d.franchise_id = c.franchise_id
                    join pnh_m_territory_info f on f.id = d.territory_id
                    join pnh_towns e on e.id = d.town_id 
                    join king_dealitems dl on dl.id=o.itemid
                    join king_deals deal on deal.dealid=dl.dealid
                    join king_brands br on br.id = deal.brandid 
                    join pnh_menu m on m.id = deal.menuid 
            where c.init between $st_ts and $en_ts $cond
            group by c.transid  
            order by c.init desc  ";
        
        $sql_shipped = "select distinct deal.brandid,deal.menuid,m.name as menu_name,br.name as brand_name,b.transid,sum(o.i_coup_discount) as com,c.amount,o.transid,o.status,o.time,o.actiontime,pu.user_id as userid,pu.pnh_member_id 
                            from shipment_batch_process_invoice_link sd
                            join proforma_invoices b on sd.p_invoice_no = b.p_invoice_no
                            join king_transactions c on c.transid = b.transid
                            join king_orders o on o.id = b.order_id  
                            join pnh_member_info pu on pu.user_id=o.userid 
                            join pnh_m_franchise_info d on d.franchise_id = c.franchise_id
                            join pnh_m_territory_info f on f.id = d.territory_id
                            join pnh_towns e on e.id = d.town_id 
                            join king_dealitems dl on dl.id=o.itemid
                            join king_deals deal on deal.dealid=dl.dealid
                            join king_brands br on br.id = deal.brandid 
                            join pnh_menu m on m.id = deal.menuid 

                            where o.status = 2 and sd.shipped = 1 and c.is_pnh = 1 $cond and sd.shipped_on between from_unixtime($st_ts) and from_unixtime($en_ts) 
                            group by b.transid 
                            order by sd.shipped_on desc";
        
        $sql_unshipped = "select distinct deal.brandid,deal.menuid,m.name as menu_name,br.name as brand_name,b.transid,sum(o.i_coup_discount) as com,b.amount,o.transid,o.status,o.time,o.actiontime,pu.user_id as userid,pu.pnh_member_id
                                from king_orders o 
                                join king_transactions b on o.transid = b.transid 
                                left join proforma_invoices c on c.order_id = o.id
                                left join shipment_batch_process_invoice_link sd on sd.p_invoice_no = c.p_invoice_no and sd.shipped = 0 
                                join pnh_member_info pu on pu.user_id=o.userid 
                                join pnh_m_franchise_info d on d.franchise_id = b.franchise_id
                                join pnh_m_territory_info f on f.id = d.territory_id
                                join pnh_towns e on e.id = d.town_id 
                                join king_dealitems dl on dl.id=o.itemid
                                join king_deals deal on deal.dealid=dl.dealid
                                join king_brands br on br.id = deal.brandid 
                                join pnh_menu m on m.id = deal.menuid 

                                where o.status != 3 and o.actiontime between $st_ts and $en_ts $cond
                                group by b.transid 
                                order by b.init desc";
        
        $sql_cancelled = "select distinct deal.brandid,deal.menuid,m.name as menu_name,br.name as brand_name,b.transid,sum(o.i_coup_discount) as com,b.amount,o.transid,o.status,o.time,o.actiontime,pu.user_id as userid,pu.pnh_member_id  
                            from king_orders o  
                            join king_transactions b on o.transid = b.transid 
                            left join proforma_invoices c on c.order_id = o.id
                            left join shipment_batch_process_invoice_link sd on sd.p_invoice_no = c.p_invoice_no and sd.shipped = 0 
                            join pnh_member_info pu on pu.user_id=o.userid 
                            join pnh_m_franchise_info d on d.franchise_id = b.franchise_id
                            join pnh_m_territory_info f on f.id = d.territory_id
                            join pnh_towns e on e.id = d.town_id 
                            join king_dealitems dl on dl.id=o.itemid
                            join king_deals deal on deal.dealid=dl.dealid
                            join king_brands br on br.id = deal.brandid 
                            join pnh_menu m on m.id = deal.menuid 

                            where o.status = 3  and o.actiontime between $st_ts and $en_ts $cond
                            group by b.transid 
                            order by b.init desc  ";
        
        $sql_removed="select distinct deal.brandid,deal.menuid,m.name as menu_name,br.name as brand_name,tr.transid,sum(o.i_coup_discount) as com,tr.amount,o.transid,o.status,o.time,o.actiontime,mi.user_id as userid,mi.pnh_member_id from king_orders o
                                join king_transactions tr on tr.transid=o.transid
                                join pnh_member_info mi on mi.user_id=o.userid 
                                join pnh_m_franchise_info d on d.franchise_id = tr.franchise_id
                                join pnh_m_territory_info f on f.id = d.territory_id
                                join pnh_towns e on e.id = d.town_id 
                                join king_dealitems dl on dl.id=o.itemid
                                join king_deals deal on deal.dealid=dl.dealid
                                join king_brands br on br.id = deal.brandid 
                                join pnh_menu m on m.id = deal.menuid 
                                
                                where tr.batch_enabled=0 and o.status=0 $cond
                                group by tr.transid
                                order by tr.init desc";
        
		if($type == 'all') {
			$sql=$sql_all;
							
		}elseif($type == 'shipped') {
                    	$sql=$sql_shipped;
			$order_cond = " and a.status = 2 and sd.shipped = 1 and sd.shipped_on between from_unixtime($st_ts) and from_unixtime($en_ts) ";
			 
		}elseif($type == 'unshipped') {
                    	$sql=$sql_unshipped;
                        $order_cond = " and a.status != 3 and (sd.shipped = 0 or sd.shipped is null ) and t.init between $st_ts and $en_ts   ";	
                        
		}elseif($type == 'cancelled') {
                    	$sql=$sql_cancelled;
			$order_cond = " and a.status = 3 and a.actiontime between $st_ts and $en_ts  ";
		}
                elseif($type == 'removed') {
                    	$sql=$sql_removed;
			//$order_cond = " and a.actiontime between $st_ts and $en_ts  ";
                }
                
                $total_results=$total_results_all=$total_results_shipped=$total_results_unshipped=$total_results_cancelled='';
                
                $total_results=$this->db->query($sql)->num_rows();
                $total_results_all=$this->db->query($sql_all)->num_rows();
                $total_results_shipped=$this->db->query($sql_shipped)->num_rows();
                
                $total_results_unshipped=$this->db->query($sql_unshipped)->num_rows();
                $total_results_cancelled=$this->db->query($sql_cancelled)->num_rows();
                $total_results_removed=$this->db->query($sql_removed)->num_rows();

		$sql .=" limit $pg,$limit ";
                
                //echo $sql."<br>".$total_results_shipped."<br>".$total_results_unshipped."<br>".$total_results_cancelled."<br>"."<br>"; die("TESTING");
                
		$res = $this->db->query($sql); //,array($fid)
		$order_stat=array("Confirmed","Invoiced","Shipped","Cancelled");
                
		$resonse='';
		if(!$total_results) {
			$resonse.="<div align='center'><h3 style='margin:2px;'>No Orders found for selected dates (".format_date(date('Y-m-d',$st_ts)) ." to ".format_date(date('Y-m-d',$en_ts)).")</h3></div>".'<table class="datagrid" width="100%"></table>';	
		}else {
                    $endlimit=($pg+1*$limit);
                    $endlimit=($endlimit>$total_results)?$total_results : $endlimit;
                    $resonse.='<div align="left">
                        <div class="ttl_orders_status_listed">Showing <b>'.($pg+1).' to '.$endlimit.'</b> of '.$total_results.' orders</div>
                        <div class="c2">Orders from '.format_date(date('Y-m-d',$st_ts)).' to '.format_date(date('Y-m-d',$en_ts)).' </div>
                        </div>';
				

//                    PAGINATION
                    $date_from=date("Y-m-d",$st_ts);
                    $date_to=date("Y-m-d",$en_ts);
                    
                    $this->load->library('pagination');
                   
                    $config['base_url'] = site_url("admin/jx_orders_status_summary/".$type.'/'.$date_from.'/'.$date_to.'/'.$terrid.'/'.$townid.'/'.$franchiseid.'/'.$menuid.'/'.$brandid); //site_url("admin/orders/$status/$s/$e/$orders_by/$limit");
                    $config['total_rows'] = $total_results;
                    $config['per_page'] = $limit;
                    $config['uri_segment'] = 11; 
                    $config['num_links'] = 5;
                    
                    $this->config->set_item('enable_query_strings',false); 
                    $this->pagination->initialize($config); 
                    $orders_pagination = $this->pagination->create_links();
                    $this->config->set_item('enable_query_strings',TRUE);
//                  PAGINATION ENDS
                    
                    
                    
                $resonse .= '<div id="orders_status_pagination" class="orders_status_pagination">'.$orders_pagination.'</div>';
                $resonse.='
                    <table class="datagrid" width="100%">
                    <thead><tr><th>Slno</th><th>Time</th><th>Order</th><th>Amount</th><th>Commission</th><th>Deal/Product details</th><th>Status</th><th>Last action</th></tr></thead>
                    <tbody>';
                        
                        $k = 0;$slno=1;
                        foreach($res->result_array() as $o) {
                                $fil_menulist[$o['menuid']] = $o['menu_name'];
                                $fil_brandlist[$o['brandid']] = $o['brand_name'];
                            
                                $ship_dets = array(); 
                                    $trans_ttl_orders = 0;
                                    $sql_inner="select e.invoice_no,sd.packed,sd.shipped,e.invoice_status,sd.shipped_on,a.status,a.id,a.itemid,b.name,a.quantity,i_orgprice,i_price,i_discount,i_coup_discount 
                                                                        from king_orders a
                                                                        join king_dealitems b on a.itemid = b.id
                                                                        join king_deals dl on dl.dealid = b.dealid
                                                                        join king_transactions t on t.transid = a.transid   
                                                                        left join proforma_invoices c on c.order_id = a.id 
                                                                        left join shipment_batch_process_invoice_link sd on sd.p_invoice_no = c.p_invoice_no 
                                                                        left join king_invoice e on e.invoice_no = sd.invoice_no and sd.packed = 1 and sd.shipped = 1 
                                                                where a.transid = '".$o['transid']."'
                                                                    $order_cond order by c.p_invoice_no desc";
                                    
//                        echo '<pre>';print_r($sql);echo '</pre>';
//                        echo '<pre>';print_r($sql_inner);echo '</pre>';
//                        die();      
                                    $o_item_list = $this->db->query($sql_inner)->result_array();
                            if(!$o_item_list)
                                continue;
                            
                        
                        
                            $k++;
                           // $this->load->model('erpmodel','erpm');
                            $orders=$this->erpm->getordersfortransid($o['transid']);
                           $order=$orders[0];
                            $resonse.='<tr>
                            <td>'.$slno.'</td>
                            <td>'.format_datetime(date('Y-m-d H:i:s',$o['time'])).'</td>
                            <td>
                                    <a href="'.site_url("admin/trans/{$o['transid']}").'" target="_blank">'.$o['transid'].'</a> <br /><br />
                                    Member ID: <a href="'.site_url("admin/pnh_viewmember/{$o['userid']}").'" target="_blank">'.$o['pnh_member_id'].'</a><br/>
                                    '.$order['ship_address'].'<br>
                                    '.$order['ship_city'].'<br>
                                    '.$order['ship_state'].' - '.$order['ship_pincode'].'<br>
                                    '.$order['ship_phone'].'
                            </td>
                            <td>'.round($o['amount'],2).'</td>
                            <td>'.round($o['com'],2).'</td>
                            <td style="padding:0px;">
                                    <table class="subdatagrid" cellpadding="0" cellspacing="0">
                                            <thead>
                                                    <th>OID</th>
                                                    <th>ITEM</th>
                                                    <th>QTY</th>
                                                    <th>MRP</th>
                                                    <th>Amount</th>
                                                    <th>Shipped</th>
                                            </thead>
                                            <tbody>';

                                                $trans_ttl_shipped = 0;
                                                $trans_ttl_cancelled = 0;
                                                $processed_oids = array();
                                                foreach($o_item_list as $o_item) {
                                                        if(!isset($processed_oids[$o_item['id']]))
                                                                $processed_oids[$o_item['id']] = 1;
                                                        else
                                                                continue;

                                                        $ord_status_color = '';
                                                        $is_shipped = 0;
                                                        $is_cancelled = ($o_item['status']==3)?1:0;
                                                        if($is_cancelled)
                                                        {
                                                                $trans_ttl_cancelled += 1;
                                                                $ord_status_color = 'cancelled_ord';
                                                        }else
                                                        {
                                                                $is_shipped = ($o_item['shipped'])?1:0;;
                                                                if($o_item['shipped'] && $o_item['invoice_status'])
                                                                {
                                                                        $trans_ttl_shipped += 1;
                                                                        $ship_dets[$o_item['invoice_no']] = format_date($o_item['shipped_on']);
                                                                        $ord_status_color = 'shipped_ord';
                                                                }else if($o_item['status'] == 0)
                                                                {
                                                                        $ord_status_color = 'pending_ord';
                                                                }
                                                        }
                                                        $is_shipped = ($is_shipped && $o_item['invoice_status']) ?'Yes':'No';
                                                          
                                                $resonse.='<tr class="'.$ord_status_color.'">
                                                        <td width="40">'.$o_item['id'].'</td>
                                                        <td>'.anchor('admin/pnh_deal/'.$o_item['itemid'],$o_item['name'],'  target="_blank" ').'</td>
                                                        <td width="20">'.$o_item['quantity'].'</td>
                                                        <td width="40">'.$o_item['i_orgprice'].'</td>
                                                        <td width="40">'.round($o_item['i_orgprice']-($o_item['i_coup_discount']+$o_item['i_discount']),2).'</td>
                                                        <td width="40" align="center">'.$is_shipped.'</td>
                                                    </tr>';

                                                }

                                                $trans_ttl_orders = count($processed_oids);

                                $resonse.='</tbody>
                                        </table>
                                </td>
                                <td>';

                                if($trans_ttl_orders == $trans_ttl_cancelled)
                                {
                                        $resonse.="Cancelled";
                                }else
                                {
                                        if(($trans_ttl_orders-$trans_ttl_cancelled) == $trans_ttl_shipped)
                                        {
                                                $resonse.='Shipped <br>
                                                    <a href="javascript:void(0)" onclick="get_invoicetransit_log(this,'.trim($o_item['invoice_no']).');" class="btn">View Transit Log</a>';
                                        }else if($trans_ttl_shipped)
                                        {
                                                $resonse.="Partitally Shipped";
                                        }else {
                                                $resonse.="UnShipped";
                                        }
                                }
                                $resonse.='<div style="font-size:11px;margin-top:10px;color:green">';
                                foreach($ship_dets as $s_invno =>$s_shipdate)
                                {
                                        $status_mrp= $this->db->query("select round(sum(nlc*quantity)) as amt from king_invoice a join king_orders b on a.order_id = b.id where a.invoice_no = '".$s_invno."' ")->row()->amt;

                                        $resonse.=' <div style="margin:3px 0px"><a target="_blank" href="'.site_url('admin/invoice/'.$s_invno).'">'.$s_invno.'-'.$s_shipdate.'</a> - Rs.'.$status_mrp.' </div>';
                                }
                                $resonse.='</div>';

                            $actiontime= ($o['actiontime']==0)?"na":format_datetime(date('Y-m-d H:i:s', $o['actiontime'] ) );
                        $resonse.='</td><td>'.$actiontime.'</td></tr>';
                        $slno++;
                    }

                    $resonse.='</tbody> </table>';

                $resonse .= '<div id="orders_status_pagination" class="orders_status_pagination">'.$orders_pagination.'</div>';

                $resonse.='<script type="text/javascript">$(".all_pop").addClass("popbg"); $(".all_pop").html("'.$total_results_all.'");  $(".shipped_pop").addClass("popbg"); $(".shipped_pop").html("'.$total_results_shipped.'");$(".unshipped_pop").addClass("popbg"); $(".unshipped_pop").html("'.$total_results_unshipped.'"); $(".cancelled_pop").addClass("popbg"); $(".cancelled_pop").html("'.$total_results_cancelled.'");  $(".removed_pop").addClass("popbg"); $(".removed_pop").html("'.$total_results_removed.'");</script>';
                   
                }
                echo $resonse;
                
                if(count($fil_menulist) && $menuid==00)
                {
                    asort($fil_menulist);
                    $menulist = '<option value="00">All Menu</option>';
                    foreach($fil_menulist as $fmenu_id=>$fmenu_name)
                    {
                        $menulist .= '<option value="'.$fmenu_id.'">'.$fmenu_name.'</option>';   
                    }
                    echo '<script>$("#sel_menu").html(\''.$menulist.'\')</script>';
                }
                if(count($fil_brandlist) && $brandid==00)
                {
                    asort($fil_brandlist);
                    $brandlist = '<option value="00">All Brands</option>';
                    foreach($fil_brandlist as $fbrandid=>$fbrand_name)
                    {
                        $brandlist .= '<option value="'.$fbrandid.'">'.$fbrand_name.'</option>';   
                    }
                    
                    echo '<script>$("#sel_brands").html(\''.$brandlist.'\')</script>';
                }
                
?>