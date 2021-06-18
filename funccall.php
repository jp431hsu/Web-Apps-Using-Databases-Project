<?php

/* This function expects $empl_choice = empl_lname, from that it selects the
   employee ID into $empl_id, passing the ID into the function from HW2, which
   returns the employee salary + $2. */

function funccall($username, $password, $empl_choice, $response)
{
   if ($response == "no")
   {
      destroy_and_exit("no employee selected");
   }

   $conn = hsu_conn_sess($username, $password);

   $empl_id = "select empl_id
               from employee
               where empl_lname = :empl_choice";

   $looky = oci_parse($conn, $empl_id);
   oci_bind_by_name($looky, ":empl_choice", $empl_choice);
   oci_execute($looky, OCI_DEFAULT);
   oci_fetch($looky);
   $temp = oci_result($looky, "EMPL_ID");
   oci_commit($conn);
   oci_free_statement($looky);
?>
   <p> Employee Last Name: <?= $empl_choice ?> </p>
   <p> Employee ID: <?= $temp ?> </p>
<?php
    $funct = 'begin :result := give_raise(:new_empl_id);
                               end;';

   $parsey = oci_parse($conn, $funct);

// bind variable for the argument:

   oci_bind_by_name($parsey, ":new_empl_id", $temp);

//bind variable for the result:

   oci_bind_by_name($parsey, ":result", $result, 2);

   oci_execute($parsey, OCI_DEFAULT);
   $lastly = oci_result($parsey, 1);
   oci_commit($conn);
   oci_free_statement($parsey);
   oci_close($conn);
   ?>
   <p> Employee Salary: <?= $result ?> </p>
<?php
}
?>

