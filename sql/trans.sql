=================== a ========================================
select cu_name as Name, count(*) as Orders
from orders, customers
where cu_id = o_cu_id
group by o_cu_id 
order by Orders desc 
limit 5;

========================= b ==========================
-- view that shows countries with most orders
create view best_countries as
select cu_cou_id
from orders, customers
where cu_id = o_cu_id
group by cu_cou_id
order by count(*) desc
limit 5;

-- Name of countie with spessific
select cou_name from countries where cou_id = 812;

-- 3 best coustomers of a country
select cu_name as Name, count(*) as Orders
from orders, customers
where cu_id = o_cu_id and cu_cou_id = 799
group by o_cu_id 
order by Orders desc 
limit 3;

================= c =====================================
create view lola as 
select distinct ol_o_id, ol_status
from order_lines
where ol_status = "Ok";

create view lola2 as 
select distinct ol_o_id, ol_status
from order_lines
where ol_status = "Pending";

create view epitelous as
select distinct o_id, o_date
from orders
where o_date > DATE_SUB(CURDATE(),INTERVAL 2 YEAR) AND o_id not in
(select ol_o_id
 from lola)
and o_id in(select ol_o_id
 from lola2
	)
order by o_date desc;


limit 20;

select ol_o_id, count(*)
from order_lines
where ol_status = "Pending"
group by ol_o_id;
