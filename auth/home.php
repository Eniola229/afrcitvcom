<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home | AfricTv</title>
    <link rel="stylesheet" type="text/css" href="index.css">
   
</head>
<body>
    <header>
        <h1>AfricTv</h1>
            <?php if (isset($_SESSION['user_id'])) { ?>
            <p class="username">Welcome <?php echo isset($_SESSION['name']) ? $_SESSION['name'] : 'Error';
	            if ($_SESSION['Verification_status'] == 0) {
	        		echo "";
	        	}
	        	else
	        	{
	        		echo "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"1em\" height=\"1em\" viewBox=\"0 0 24 24\"><path fill=\"currentColor\" d=\"m8.6 22.5l-1.9-3.2l-3.6-.8l.35-3.7L1 12l2.45-2.8l-.35-3.7l3.6-.8l1.9-3.2L12 2.95l3.4-1.45l1.9 3.2l3.6.8l-.35 3.7L23 12l-2.45 2.8l.35 3.7l-3.6.8l-1.9 3.2l-3.4-1.45zm2.35-6.95L16.6 9.9l-1.4-1.45l-4.25 4.25l-2.15-2.1L7.4 12z\"/></svg>";
	        	}
             ?></p>
            <nav>
                <a href="includes/logout.inc.php">Logout</a>
            </nav>
        <?php } else { ?>
            <a href="register.php"><button>Signup</button></a>
            <a href="index.php"><button>Login</button></a>
        <?php } ?>
    </header>



<style>
	 body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color:; /* Green background color */
            color: #333;
        }

     
        hr {
            border: none;
            height: 1px;
            background-color: #ccc;
            margin: 20px 0;
        }



        h3 {
            color: #4caf50; /* Instagram Green */
        }

        p {
            margin-bottom: 20px;
            font-family: cursive;
        }
    </style>
</head>
<body>
    <header>
        <!-- <h1><?php echo $_SESSION['useruid']; ?></h1> -->
    </header>

    <div style="text-align: center; margin-top: 20px;">
      <a href="profilesettings.php">
        <button>Profile Settings</button>
    </a>
    </div>

    <hr>

    <div style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <h3>About</h3>
        <p>Name: <?php echo $_SESSION['name']; ?></p></p>
        <p>Email: <?php echo $_SESSION['email']; ?></p>
        <p>Unique Id: <?php echo $_SESSION['unix_id']; ?></p>
        <p>Phone Number: <?php echo $_SESSION['phone_number']; ?></p>
        <p>Subscription_plan: <?php echo $_SESSION['Subscription_plan']; ?></p>
        <p>Verification_status: <?php
        	if ($_SESSION['Verification_status'] == 0) {
        		echo "";
        	}
        	else
        	{
        		echo "Verified";
        	}
         ?></p>
        <p>joined: <?php echo $_SESSION['joined_at']; ?></p>
    </div>
   
</body>
</html>