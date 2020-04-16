<?php
'SELECT 
*
from 
'.MAIN_CATEGORY.' c
inner join 
'.SUB_CATEGORY.' s on c.c_id = s.c_name
inner join 
'.PAGES.' p on s.c_id = p.category
WHERE
( c.status!=2 and c.c_id IN ('.$mainCats.') and c.c_name like "%'.$keyword.'" ) or
( s.status!=2 and s.c_name IN ('.$mainCats.') and  s.c_id IN ('.$subCateIDs.') and s.sc_name like "%'.$keyword.'" ) or
( p.page_status!=2 and p.category ('.$subCateIDs.') and  p.p_id IN ('.$pageIDs.' and p.title like "%'.$keyword.'" ) ) 
order by c.c_name ASC';



