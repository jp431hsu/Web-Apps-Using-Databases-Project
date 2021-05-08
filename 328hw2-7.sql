/* This function adds $2 to an employee's salary as part of the first year's
   raise when an employee passes review */

create or replace function give_raise(emp int)
   return integer as

temp_salary integer;

begin
   select salary
   into temp_salary
   from Employee
   where emp = empl_id;

   temp_salary := temp_salary + 2;

   return temp_salary;

end;
/
show errors

var emp number

exec :emp := give_raise(1)

print emp

exec :emp := give_raise(9)

print emp

spool off
