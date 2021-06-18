<?php
    session_start();
?>

<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<!--

   uses: hsu_conn_sess.php
         destroy_and_exit.php
         create_login.php
         create_empl_dropdown.php
         get_empl_titles.php
         name-pwd-fieldset.html
         328footer.html
         328footer-plus-end.html
         custom-start.css

-->

<head>
    <title> Annual Raises </title>
    <meta charset="utf-8" />

    <?php
	require_once("hsu_conn_sess.php");
        require_once("destroy_and_exit.php");
        require_once("create_login.php");
        require_once("create_empl_dropdown.php");
        require_once("get_empl_titles.php");
    ?>

    <link href="http://users.humboldt.edu/smtuttle/styles/normalize.css"
          type="text/css" rel="stylesheet" />
    <link href="custom.css" type="text/css"
          rel="stylesheet" />
</head>

<body>
    <h1> Pet Care Boarding - Annual Raises! </h1>
 <p> <img src="https://www.nationaldebtrelief.com/wp-content/uploads/2015/10/The-Real-Effect-Of-A-Salary-Increase-On-Your-Life.jpg"
 alt="Hand pushing a search button for salary increase" />
 </p>
    <?php

    if (! array_key_exists("next_state", $_SESSION))
    {
     	create_login();
        $_SESSION['next_state'] = 'create_empl_dropdown';
    }

    elseif ($_SESSION['next_state'] == 'create_empl_dropdown')
    {
     	if ( (! array_key_exists('username', $_POST)) or
             (trim($_POST['username']) == "") or
             (! isset($_POST['username'])) )
        {
            destroy_and_exit("no username entered");
        }

	if ( (! array_key_exists('password', $_POST)) or
             (trim($_POST['password']) == "") or
             (! isset($_POST['password'])) )
        {
            destroy_and_exit("no password entered");
        }

	$username = strip_tags($_POST["username"]);
        $password = $_POST['password'];
        $_SESSION["username"] = $username;
        $_SESSION["password"] = $password;
        create_empl_dropdown($username, $password);
        $_SESSION["next_state"] = "empl_chosen";
    }

    elseif (($_SESSION['next_state'] == "is_user_done") &&
            (array_key_exists("another_salary", $_POST)))
     {
     	$username = $_SESSION["username"];
        $password = $_SESSION["password"];
        create_empl_dropdown($username, $password);
        $_SESSION["next_state"] = "empl_chosen";
    }

    elseif (($_SESSION['next_state'] == "is_user_done") &&
            (array_key_exists("no_more_empl", $_POST)))
    {
     	session_destroy();

        ?>
	<p> Click
            <a href="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">
            here </a> to start over
        </p>
	<?php
    }

    elseif ($_SESSION["next_state"] == "empl_chosen")
    {
     	get_empl_titles();
        $_SESSION['next_state'] = "is_user_done";
    }

    else
    {
     	create_login();
        session_destroy();
        session_regenerate_id(TRUE);    //             line 114
        session_start();

        $_SESSION['next_state'] = 'create_empl_dropdown';
    }

    require_once("328footer.html");
?>
</body>
</html>
