<?php
    require_once '../UserHandling/core/init.php';
        
    if (!Session::exists('home')) {
        echo '<p>'. Session::flash('home') .'</p>';
    }

    $user = new User();
    if($user->isLoggedIn()) {
        
    //Adds Admin NavBar if Admin Acct logged in
    if($user->data()->group == 3) {
        include("../AdminPortal/AdminNavBar.php");

    }

?>
<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/PeaceOfHeavenWebPage/css/MyReservations.css">
    
    <title>Reservation List</title>
</head>
<body>
    <div class = 'content'>
          <!-- Table to show pending reservations -->
  <h2>Boarding and Daycare Reservations</h2>
  <table>
    <thead>
      <tr>
        <th>Date Range</th>
        <th>Dog</th>
        <th>Service</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <tr>
      <?php
                //Constructor Calls
                //Retreives Dog, Customer, and Reservation
                $reservation = new Reservation('service', array());
                $dog = new Dog();
                $customer = new Customer();
                $customer->findCustInfo($user->data()->id);
                // $custid = $customer->data()->CustID;

                //Gathers the data
                $reservation->getAllReservations();
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

                        if($reservation->isApproved == 1 && $reservation->isFinished == 0){

                          echo '<td>Confirmed</td>';

                        }else if($reservation->isApproved == 1 && $reservation->isFinished == 1){
                          echo '<td>Complete</td>';
                        }
                        else if ($reservation->isApproved == 0){
                          echo '<td>Pending</td>';
                        }

                        echo '</tr>';

                    }
                }  ?>
      </tr>
    </tbody>
  </table>
  <br><br>
   
 <!-- Table to show pending reservations -->
 <h2>Grooming Reservations</h2>
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
        // $custid = $customer->data()->CustID; //stores the customer id

        //Finds Unapproved Reservations Linked to Account
        $groomingReservation->getAllGroomingReservations();
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
                   

                    if($reservationGrooming->isApproved == 1 && $reservationGrooming->isFinished == 0){

                      echo '<td>Confirmed</td>';

                    }else if($reservationGrooming->isApproved == 1 && $reservationGrooming->isFinished == 1){
                      echo '<td>Complete</td>';
                    }
                    else if ($reservationGrooming->isApproved == 0){
                      echo '<td>Pending</td>';
                    }


                    echo '</tr>';
             }
            } ?>
      </tr>
    </tbody>
  </table>
  <br><br>
</div>
</body>
</html>
<?php 
    //Gathers Data if anything is submitted
    if(Input::exists()){
        
    }


}else{Redirect::to('../UserHandling/login.php');} ?>