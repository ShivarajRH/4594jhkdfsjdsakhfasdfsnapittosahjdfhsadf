/* Calls Made*/
select emp.employee_id,emp.name caller,emp.contact_no,exa.callsid,exa.dialwhomno as towhom,exa.status,exa.created_on as calledtime from t_exotel_agent_status exa 
join m_employee_info emp on emp.contact_no = substr(exa.from,2) order by calledtime,callsid ASC limit 0,25

/* Calls received*/
select emp.employee_id,emp.name caller,emp.contact_no,exa.callsid,exa.dialwhomno as towhom,exa.status,exa.created_on as calledtime from t_exotel_agent_status exa 
join m_employee_info emp on emp.contact_no = substr(exa.dialwhomno,2) order by calledtime,callsid ASC limit 0,25

/*and emp.contact_no = '9945071560' */
