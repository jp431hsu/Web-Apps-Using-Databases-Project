<!--
This function expects a username, password, salary choice, and employee choice.
It then updates the employee table for the salary field.
-->
<?php

function update_salary($username, $password, $salary_update, $empl_choice)
{
   // try to connect to Oracle

   $conn = hsu_conn_sess($username, $password);

   $empl_salary_update_query = 'update employee
                                set salary = :salary_update
                                where empl_lname = :empl_choice';

   $empl_salary_update_stmt = oci_parse($conn, $empl_salary_update_query);

   $salary_update = $_SESSION["salary"];

   oci_bind_by_name($empl_salary_update_stmt, ":salary_update",
                    $salary_update);

   oci_bind_by_name($empl_salary_update_stmt, ":empl_choice",
                    $empl_choice);

   oci_execute($empl_salary_update_stmt, OCI_DEFAULT);

   oci_commit($conn);

   oci_free_statement($empl_salary_update_stmt);

// display the update via select extra credit

   $empl_salary_display_query = 'select salary
                                 from employee
                                 where empl_lname = :empl_choice';

   $empl_salary_display_stmt = oci_parse($conn, $empl_salary_display_query);
   oci_bind_by_name($empl_salary_display_stmt, ":empl_choice",
                    $empl_choice);
   oci_execute($empl_salary_display_stmt, OCI_DEFAULT);
   oci_fetch($empl_salary_display_stmt);
   $variable = oci_result($empl_salary_display_stmt, "SALARY");
   oci_free_statement($empl_salary_display_stmt);

?>

<p> The updated salary is now: <?= $variable ?> </p>

<?php

// end extra credit

   oci_close($conn);


}

?>
