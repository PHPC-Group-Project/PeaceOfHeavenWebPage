<?php
    require_once '../UserHandling/core/init.php';
    
    if (!Session::exists('home')) {
        echo '<p>'. Session::flash('home') .'</p>';
    }

    $user = new User();
    if($user->isLoggedIn()) {

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

   
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/PeaceOfHeavenWebPage/css/CustHome.css">

    <title>Customer Portal</title>
</head>
<body> 
<div class=content>
    <!-- Box to style welcome statement -->
    <div class="header">
        <div class="welcome-box">
        <h1>Welcome to the Customer Portal</h1>
        </div>
    </div>

     <!-- Table to showcase Confirm Reservations -->
     <h2>Announcements </h2>
      <?php
      
      //Constructor Call 
      $announcement = new Announcement();

      //Call all relevant Announcements
      $announcement->postAnnouncements();
      $allAnnouncements = $announcement->data();

      //Checks for empty and prints announcement for each 
      if(!empty($allAnnouncements)){
        foreach($allAnnouncements as $announcement){
          
          //Gather data
          $header = $announcement->header;
          $date = $announcement->date;
          $description = $announcement->description;

          echo '<div class="announcement">';
          echo '<h3>'.$header.'</h3>';
          echo '<p class="date">'.$date.'</p>';
          echo '<p class="description">'.$description.'</p>';
          echo '</div>';

        }
      }
      
      ?>
    <div class="view-button-container">
        <a href="/PeaceOfHeavenWebPage/php/Customer Portal/AllAnnouncements.php">
            <button class="view-button">View All Announcements</button>
        </a>
    </div>
  <br><br>

    <!-- Table to showcase Confirmed Daycare and Boarding Reservations -->
        <h2>Confirmed Boarding and Daycare Reservations</h2>
        <table>
        <thead>
          <tr>
            <th>Date Range</th>
            <th>Dog</th>
            <th>Service</th>
            <th>Status</th>
          </tr>
    </thead>
    <!-- Doesn't try to grab info about a customer if the account isn't a customer (Employee/Admin view) -->
  <?php if($user->data()->group == 1 ){ ?>
    <tbody>
                  <?php
                //Constructor Calls
                //Retreives Dog, Customer, and Reservation
                $reservation = new Reservation('service', array());
                $dog = new Dog();
                $customer = new Customer();
                $customer->findCustInfo($user->data()->id);
                $custid = $customer->data()->CustID;

                //Gathers the data
                $reservation->getConfirmedReservationsWithCustID($custid);
                $allReservations = $reservation->getReservationData();

                if(!empty($allReservations)){

                    foreach ($allReservations as $reservation){
                        echo '<tr>';
                        echo '<td>' . $reservation->ResStartTime . '-'.$reservation->ResEndTime.'</td>';

                        //Finds the dog name with their ID
                        $dog->findDogInfoWithDogID($reservation->DogID);
                        $dogName = $dog->data()->DogName;

                        echo '<td>'.$dogName.'</td>';
                        echo '<td>' . $reservation->ServiceType .'</td>';
                        echo '<td> Confirmed </td>';
                        echo '</tr>';

                    }
                }  ?>
    </tbody>
  <?php  } ?>
  </table>
    <div class="view-button-container">
        <a href="/PeaceOfHeavenWebPage/php/Customer Portal/MyReservations.php">
            <button class="view-button">View My Reservations</button>
        </a>
    </div>
  <br><br>

      <!-- Table to showcase Confirmed Grooming Reservations -->
      <h2>Confirmed Grooming Reservations</h2>
    <table>
    <thead>
      <tr>
        <th>Date Range</th>
        <th>Dog</th>
        <th>Desscription</th>
        <th>Service</th>
        <th>Status</th>
      </tr>
    </thead>
  <?php if($user->data()->group == 1 ){ ?>
    <tbody>
    <?php
                //Constructor Calls
                //Retreives Dog, Customer, and Reservation
                $reservation = new GroomingReservation('service', array());
                $dog = new Dog();
                $customer = new Customer();
                $customer->findCustInfo($user->data()->id);
                $custid = $customer->data()->CustID;

                //Gathers the data
                $reservation->getConfirmedGroomingReservationsWithCustID($custid);
                $allReservations = $reservation->getReservationData();

                if(!empty($allReservations)){

                    foreach ($allReservations as $reservation){
                        echo '<tr>';
                        echo '<td>' . $reservation->ResStartDate . '-'.$reservation->ResEndDate.'</td>';

                        //Finds the dog name with their ID
                        $dog->findDogInfoWithDogID($reservation->DogID);
                        $dogName = $dog->data()->DogName;

                        echo '<td>'.$dogName.'</td>';
                        echo '<td>'.$reservation->GroomingDesc . '</td>';
                        echo '<td>Grooming</td>';
                        echo '<td> Confirmed </td>';
                        echo '</tr>';

                    }
                }  ?> 
    </tbody>
  <?php } ?>
  </table>
    <div class="view-button-container">
        <a href="/PeaceOfHeavenWebPage/php/Customer Portal/MyReservations.php">
            <button class="view-button">View My Reservations</button>
        </a>
    </div>
  <br><br>

  <!-- Table to show pending reservations -->
  <h2>Pending Boarding and Daycare Reservations</h2>
  <table>
    <thead>
      <tr>
        <th>Date Range</th>
        <th>Dog</th>
        <th>Service</th>
        <th>Status</th>
      </tr>
    </thead>
  <?php if($user->data()->group == 1 ){ ?>
    <tbody>
      <tr>
      <?php
                //Constructor Calls
                //Retreives Dog, Customer, and Reservation
                $reservation = new Reservation('service', array());
                $dog = new Dog();
                $customer = new Customer();
                $customer->findCustInfo($user->data()->id);
                $custid = $customer->data()->CustID;

                //Gathers the data
                $reservation->getUnApprovedReservationsWithCustID($custid);
                $allReservations = $reservation->getReservationData();

                if(!empty($allReservations)){

                    foreach ($allReservations as $reservation){
                        echo '<tr>';
                        echo '<td>' . $reservation->ResStartTime . '-'.$reservation->ResEndTime.'</td>';

                        //Finds the dog name with their ID
                        $dog->findDogInfoWithDogID($reservation->DogID);
                        $dogName = $dog->data()->DogName;

                        echo '<td>'.$dogName.'</td>';
                        echo '<td>' . $reservation->ServiceType .'</td>';
                        echo '<td> Pending </td>';
                        echo '</tr>';

                    }
                }  ?>
      </tr>
    </tbody>
  <?php } ?>
  </table>
  <br><br>
   
 <!-- Table to show pending reservations -->
 <h2>Pending Grooming Reservations</h2>
  <table>
    <thead>
      <tr>
        <th>Time Range</th>
        <th>Dog</th>
        <th>Description</th>
        <th>Service</th>
        <th>Status</th>
      </tr>
    </thead>
    <?php if($user->data()->group == 1 ){ ?>
    <tbody>
      <tr>
        <!-- Load in Pending Grooming Appointments -->
        <?php
        //Constructor Class Calls
        $groomingReservation = new GroomingReservation('Grooming', array());
        $dog = new Dog();
        $user = new User();
        $customer = new Customer();

        //Find Customer with Customer ID
        $customer->findCustInfo($user->data()->id); //Finds matching user id
        $custid = $customer->data()->CustID; //stores the customer id

        //Finds Unapproved Reservations Linked to Account
        $groomingReservation->getUnApprovedReservationsWithCustID($custid);
        $allGroomingData = $groomingReservation->getReservationData();


            //Checks that query has results
            if(!empty($allGroomingData)){
                //Goes through each table row

                foreach ($allGroomingData as $reservationGrooming){
                    //populates rows
                    echo '<tr>';
                    echo '<td>'. $reservationGrooming->ResStartDate . ' - ' .  $reservationGrooming->ResEndDate.'</td>';

                    //Finds the dog name with their ID
                    $dog->findDogInfoWithDogID($reservationGrooming->DogID);
                    $dogName = $dog->data()->DogName;

                    echo '<td>'. $dogName . '</td>';
                    echo '<td>'. $reservationGrooming->GroomingDesc. '</td>';
                    echo '<td>Grooming</td>';
                    echo '<td>Pending</td>';
                    echo '</tr>';
             }
            } ?>
      </tr>
    </tbody>
  <?php } ?>
  </table>
  <br><br>

  <!-- Table to show all dogs the customer has -->
  <h2>My Dogs</h2>
  <table>
    <thead>
      <tr>
        <!-- Creates Table Headers -->
        <th>Name</th>
        <th>Breed</th>
        <th>DOB</th>
        <th>Sex</th>
        <th>Weight</th>
        <th>Color</th>
        
      </tr>
    </thead>
  <?php if($user->data()->group == 1 ){ ?>
    <tbody>
        <?php 
            //Calls Customer, Links with UserID and Stores CustID
            $customer = new Customer();
            $customer->findCustInfo($user->data()->id);
            $custid = $customer->data()->CustID;

            //Class call
            $dog = new Dog();

            //Finds all Dogs linked by CustID
            $dog->findDogArray($customer->data()->CustID);

            //Stores the Dogs Found
             $dogData = $dog->data();

            //
            if(!empty($dogData)){
            //Lists Each Dog found in the Array
            foreach ($dogData as $dog) {
                    //Populates the rows
                    echo '<tr>';
                    echo '<td>' . $dog->DogName . '</td>';
                    echo '<td>' . $dog->Breed . '</td>';
                    echo '<td>' . $dog->DogDOB . '</td>';
                    echo '<td>' . $dog->Sex . '</td>';
                    echo '<td>' . $dog->Weight . '</td>';
                    echo '<td>' . $dog->Color . '</td>';
                    // Add more columns for other dog details

                    echo '</tr>';
                }
            }

            
        ?>
    </tbody>
  <?php } ?>
  </table>
    <div class="view-button-container">
        <a href="../Customer Portal/CustDogs.php">
            <button class="view-button">View My Dogs</button>
        </a>
    </div>

</div>
</div>
</body>
</html>
<?php } else {
            Redirect ::to('../UserHandling/login.php');
            }
?>