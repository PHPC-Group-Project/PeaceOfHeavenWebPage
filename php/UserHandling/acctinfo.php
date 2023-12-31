<?php
require_once 'core/init.php';

$user = new User();

if ($user->isLoggedIn()) {

    ## Include acct info view here ##
if($user->data()->isComplete == 0 ) 
{
    if(Input::exists()) {
        if(Token::check(Input::get('token'))) {
            
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                ### Insert rules that acctInfo fields must meet in addition to js validation ###
            ));

            // If all rules are satisfied, create new customer
            if($validation->passed()) {
                $customer = new Customer(); // constructor call

                try {
                    $customer->create(array( // NOTE:: DB table names might be case sensitive if this doesn't work.
                        'CustFirstName' => Input::get('custFirstName'),
                        'CustLastName' => Input::get('custLastName'),
                        'CustPhone' => Input::get('custPhone'),
                        'AcctEmail' => Input::get('email'),
                        'CustAddress'=> Input::get('address'),
                        'CustCity' => Input::get('city'),
                        'CustState'=> Input::get('state'),
                        'CustZip' => Input::get('zip'),
                        'User_ID' => $user->data()->id
                    ));

                  
                    //Session::flash('#page', '#message');

                    // First, you need to create an instance of the DB class.
                    $db = DB::getInstance();

                    // Define the table, row id, and fields you want to update.
                    $table = 'users';
                    $id = $user->data()->id;
                    $fields = array(
                            'isComplete' => 1,
                        );

                    //Updates isComplete now that account has been completed
                     $db->update($table, $id, $fields);

                    //Takes account to customer portal
                    Redirect::to('../Customer Portal/CustHome.php');
                   


                }catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                // output errors
                foreach ($validation->errors() as $error) {
                    echo $error, '<br>';
                 }
             }
         }
     }
    }else{
        Redirect::to('../Customer Portal/CustHome.php');
    }
    

    /*
    session_start(); //Starts the session -- REQUIRED ON EVERY PAGE --

        //include("connection.php"); //Needed for making login required, calls other php page
    // include("functions.php");//Needed for making login required, calls other php page
    // include("/xampp/htdocs/PeaceOfHeavenWebPage/php/Core/init.php");

        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
                //Pulls input into variables
                $custFirstName = $_POST['custFirstName'];
                $custLastName = $_POST['custLastName'];
                $custPhone = $_POST['cell_phone'];
                $acctEmail = $_POST['email'];
                $address = $_POST['address'];
                $city = $_POST['city'];
                $state = $_POST['state'];
                $zip = $_POST['zip'];

                //Posts to Database
                //JON FIX THIS WITH DB CLASS
                $query = "UPDATE customer JOIN login ON customer.User_ID = login.User_ID 
                        SET CustFirstName = '$custFirstName', CustLastName = '$custLastName', CustPhone = '$custPhone', AcctEmail='$acctEmail', CustAddress='$address', CustState='$state', CustCity='$city', CustZip='$zip'";        
                mysqli_query($connection, $query);

                //Redirects
                header("Location: login.php");
                die;

        }
    */
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/PeaceOfHeavenWebPage/css/AcctInfo.css">
</head>

<body>
    <form method="POST" class="CustInfo-Form">
        <fieldset>

            <legend>Customer Account Signup Information</legend>
            <p>
                <label for="custFirstName">First Name:</label>
                <input type="text" name="custFirstName" id="custFirstName" required>
            
                <label for="custLastName">Last Name:</label> <!-- In the form there is an option for more than one -->
                <input type="text" name="custLastName" id="custLastName" required>

                <label for="custPhone"><br>Cell Phone:</label>
                <input type="tel" id="custPhone" name="custPhone" placeholder="(123)-456-678" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" required>

                <label for="email"><br>Email:</label>
                <input type="email" id="email" name="email" required> <!-- There is a multiple keyword that will allow multiple addresses-->

                <label for="address"><br>Address:</label>
                <input type="text" name="address" id="address" required>

                <label for="city"><br>City:</label>
                <input type="text" name="city" id="city" required>

                <label for="state">State:</label>
                <input type="text" name="state" id="state" required>

                <label for="zip">Zip:</label>
                <input type="text" name="zip" id="zip" required><br>

                <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
                <input type="submit" value="Complete Signup"><br><br>
                

</p>
        </fieldset>
    </form>

</body>
    
</html>