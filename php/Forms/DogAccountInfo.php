<?php 
    require_once '../UserHandling/core/init.php';

$user = new User(); //constructor call
$customer = new Customer(); //constructor call 
//checks if user is logged in
if ($user->isLoggedIn()) {

    //Adds Customer NavBar if Customer Acct logged in
    if($user->data()->group == 1){
        include("../Customer Portal/CustNavBar.php");
    }

    //Adds Employee NavBar if Employee Acct logged in
    if($user->data()->group == 2){
        include("../Employee Portal/EmpNavBar.php");

    }

    //Adds Admin NavBar if Admin Acct logged in
    if($user->data()->group == 3 ){
        include("../AdminPortal/AdminNavBar.php");

    }

    //Makes sure form has been submitted
    if(Input::exists()) {
        
        //Checks for Token
        if(Token::check(Input::get('token'))) {

            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                ### Insert rules that acctInfo fields must meet in addition to js validation ###
            ));

            // If all rules are satisfied, create new customer
            if($validation->passed()) {
               // if(){
                    try{
                        //Creates array of all input to be inserted into dog table
                        $dog = new Dog(); //constructor call
                        $customer->findCustInfo($user->data()->id); //Finds matching user id
                        $custid = $customer->data()->CustID; //stores the customer id

                        //Creates array to be added to dog table
                        $dog->create(array(
                            'DogName' => Input::get('DogName'),
                            'Breed' => Input::get('Breed'),
                            'DogDOB' => Input::get('DogDOB'),
                            'Sex' => Input::get('sex'),
                            'isFixed' => Input::get('fixed'),
                            'Weight' => Input::get('DogWeight'),
                            'Color' => Input::get('DogColor'),
                            'DogOtherInfo' => Input::get('DogOtherInfo'),
                            'CustID' => $custid 
                        ));

                        //Returns user to home
                        Redirect::to('../Customer Portal/CustHome.php');

                    }
                    //Error Handling
                    catch(Exception $e) {
                        die($e->getMessage());  
                    }
             //   }    
                }else { ## Is this an error?
                    // output errors
                    foreach ($validation->errors() as $error) {
                        echo $error, '<br>';
                    }   
                }
        }
    }

?>
<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="/PeaceOfHeavenWebPage/css/DogAccountInfo.css">
            <script src="DogAccount.js" defer></script>
        </head>
    
        <body>
            <div class ='content'>
            <form method="POST" class="DogInfo-Form" name=DogAccountInfo onsubmit="return validateForms()">
                <fieldset>
                        <!-- Collects information for Dog Table -->
                        <legend>Dog General Information</legend>
                    <p> 
                            <!-- Gets Dog Name From Input -->
                            <label for="DogName">What is your dog's name? </label>
                            <input type="text" name="DogName" id="DogName" required><br><br>

                            <!-- Gets Dog Breed From Input -->
                            <label for="Breed">What is your dog's breed? </label>
                            <input type="text" name="Breed" id="Breed" required><br><br>

                            <!-- Gets Dog DOB From Input -->
                            <label for="DogDOB">What is your dog's date of birth?</label>
                            <input type="date" name ="DogDOB" id="DogDOB" required><br><br>
                            
                            <!-- Gets Dog Sex from Male and Female Option -->
                            <label for="DogSex">What is the sex of your dog?</label>
                            <input type="radio" id="M" name="sex" value="M" required>
                            <label for="M">Male</label>

                            <input type="radio" id="F" name="sex" value="F">
                            <label for="F">Female</label><br><br>

                            
                            <!-- Gets If the Dog is Fixed from Options -->
                            <label>Has your dog been fixed?</label>
                            <input type="radio" id="T" name="fixed" value="1" required>
                            <label for="T">Fixed</label>

                            <input type="radio" id="F" name="fixed" value="0">
                            <label for="F">Not Fixed</label><br><br>
                            
                            <!-- Gets the Dog's Weight from Input -->
                            <label for="DogWeight"> What is your dog's weight?</label>
                            <input type="number" id="DogWeight" name="DogWeight" required><br><br>

                            <!-- Gets the Dog's Color from Input -->
                            <label for="DogColor">What is your dog's color</label>
                            <input type="text" id="DogColor" name="DogColor" required><br><br>
                            
                            <!-- Gets the Dog's Other Information -->
                            <label for="DogOtherInfo">Is there anything else you would like to tell us about your dog?</label>
                            <input type="text" id="DogOtherInfo" name="DogOtherInfo"><br><br>

                            <!-- Generates token and submits -->
                            <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
                            <input type="submit" value="Complete Dog Account"><br><br>
                        </p>
                </fieldset>
            </form>
</div>
        </body>
    </html>
<?php } ?>