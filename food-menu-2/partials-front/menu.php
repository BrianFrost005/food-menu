<?php include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/chatbot.css">
</head>

<body>
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
            
            <div class="menu text-right">
                <ul>
                    <li>
                        <a href="<?php echo HOMEURL; ?>">Home</a>
                    </li>
                    <li>
                        <a href="<?php echo HOMEURL; ?>categories.php">Categories</a>
                    </li>
                    <li>
                        <a href="<?php echo HOMEURL; ?>foods.php">Food</a>
                    </li>
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Navbar Section Ends Here -->