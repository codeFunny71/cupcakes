<?php
/**
 * Created by PhpStorm.
 * User: marcusabsher
 * Date: 2019-01-03
 * Time: 14:21
 *
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="cupcake.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

    <title>Document</title>

    <?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL | E_STRICT);
    ?>

</head>
<body>
    <?php
        $cupcakeFlavors = array("grasshopper" => "The Grasshopper", "maple" => "Whiskey Maple Bacon",
            "carrot" => "Carrot Walnut","caramel" => "Salted Caramel Cupcake","velvet" => "Red Velvet",
            "lemon" => "Lemon Drop","tiramisu" => "Tiramisu");
    ?>

    <?php
        //Initialize variables
        $formOk = true;
        $count = 0;
        $nameError = "";
        $cupcakeError = "";
        $name = "";
        $cupcake = "";

        function test_input($data){
            $data = trim($data);
            $data = stripcslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        //Form Validation
        if(isset($_POST['submit'])){
            if(empty($_POST['name'])){
                $nameError = "Name is required";
                $formOk = false;
            }else{
                $name = test_input($_POST['name']);
                //check name only contains letters and whitespace
                if(!preg_match("/^[a-zA-Z]*$/", $name)) {
                    $nameError = "Only letters and white space allowed";
                    $formOk = false;
                }
            }
            if(empty($_POST['flavors'])){
                $cupcakeError = "Cupcake choice is required";
            }else{
                foreach ($_POST['flavors'] as $flavor){
                    $cupcake = test_input($flavor);
                }
            }
        }
    ?>
    <div class="padding">
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <h2>Cupcake Order Form</h2>
        <span class="error">* required fields.</span><br><br>
        Name:
        <br>
        <input class="input" name="name" type="text" value="<?php if ( isset( $_POST["name"] ) ) echo $_POST["name"]?>">
        <span class="error">* <?php echo $nameError;?></span>
        <br>
        <?php
            foreach($cupcakeFlavors as $key => $value){
                echo '<label><input class="checkbox" type="checkbox" name="flavors[]" ';
                if(isset($_POST["flavors"])){if(in_array($key, $_POST["flavors"])){
                    echo  'checked="checked"'; }};
                echo ' value="'.$key.'">  '.$value.'</label>';
                echo '<br>';
            }
        ?>
        <span class="error">*<?php echo $cupcakeError;?></span><br>
        <input class="submit" name="submit" type="submit" value="Submit" />
    </form>

    <div>
        <?php
            if(isset($_POST["submit"])){
                if($formOk){
                    $total = sizeof($_POST["flavors"])*3.50;
                    $total = money_format('%.2n', $total);
                    echo '<br><br>';
                    echo 'Thank you, '.$name.', for your order!';
                    echo '<br><br>';
                    echo '<p>Order Summary:</p>';
                    echo '<ul>';
                    foreach ($_POST["flavors"] as $flavor){
                        echo '<li>'.$cupcakeFlavors[$flavor].'</li>';
                    }
                    echo '</ul>';
                    echo '<p>Order Total:    $'.$total.'</p>';
                }
            }
        ?>
    </div>
    </div>
</body>
</html>




