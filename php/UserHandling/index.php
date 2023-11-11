<?php 
/*
    Example user portal calling user class.
*/
require_once 'core/init.php';


if (!Session::exists('home')) {
    echo '<p>'. Session::flash('home') .'</p>';
}


$user = new User();
if($user->isLoggedIn()) {
?>
    <p>Hello <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->username); ?></a>!</p>

    <ul>
        <li><a href="logout.php">Log out</a></li>
        <li><a href="update.php">Update Details</a></li>
        <li><a href="changepassword.php">Change Password</a></li>
        <li><a href="acctinfo.php">Create Customer account</a></li>
    </ul>
<?php 

    $customer = new Customer();
    $customer = $customer->data($user->data()->id);
    $customer->data();

    echo 'hi';
    print_r($customer);

    if($user->hasPermission("admin")) {
        echo '<p>You are an administrator!</p>';

    }
    
} else {
    echo "<p>You need to <a href='login.php'>Log in</a> or <a href='register.php'>register</a></p>";
}

$allGroomingData ->getUnapprovedReservations();
$allGroomingData
