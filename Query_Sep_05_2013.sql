select distinct b.transid,sum(o.i_coup_discount) as com,b.amount,o.transid,o.status,o.time,o.actiontime,pu.user_id as userid,pu.pnh_member_id
		from king_orders o 
			join king_transactions b on o.transid = b.transid 
			left join proforma_invoices c on c.order_id = o.id
			left join shipment_batch_process_invoice_link sd on sd.p_invoice_no = c.p_invoice_no and sd.shipped = 0 
			join pnh_member_info pu on pu.user_id=o.userid 
			join pnh_m_franchise_info d on d.franchise_id = b.franchise_id
			join pnh_m_territory_info f on f.id = d.territory_id
			join pnh_towns e on e.id = d.town_id 

			where o.status != 3 and o.actiontime between 1377973800 and 1378405799  
			group by b.transid 
			order by b.init desc

select tr.transid,sum(o.i_coup_discount) as com,tr.amount,o.transid,o.status,o.time,o.actiontime,mi.user_id as userid,mi.pnh_member_id from king_orders o
join king_transactions tr on tr.transid=o.transid
join pnh_member_info mi on mi.user_id=o.userid 
join pnh_m_franchise_info d on d.franchise_id = tr.franchise_id
join pnh_m_territory_info f on f.id = d.territory_id
join pnh_towns e on e.id = d.town_id 
where tr.batch_enabled=0 and o.status=0
group by tr.transid
order by tr.init desc;

select * from king_orders where status=0;



select e.invoice_no,sd.packed,sd.shipped,e.invoice_status,sd.shipped_on,a.status,a.id,a.itemid,b.name,a.quantity,i_orgprice,i_price,i_discount,i_coup_discount 
                                                                        from king_orders a
                                                                        join king_dealitems b on a.itemid = b.id
                                                                        join king_transactions t on t.transid = a.transid   
                                                                        left join proforma_invoices c on c.order_id = a.id 
                                                                        left join shipment_batch_process_invoice_link sd on sd.p_invoice_no = c.p_invoice_no and sd.shipped = 0 
                                                                        left join king_invoice e on e.invoice_no = sd.invoice_no and sd.packed = 1 and sd.shipped = 1 
                                                                where a.transid = 'PNHLWS56433'
                                                                      and sd.shipped_on between from_unixtime(1372617000) and from_unixtime(1378405799)  order by c.p_invoice_no desc