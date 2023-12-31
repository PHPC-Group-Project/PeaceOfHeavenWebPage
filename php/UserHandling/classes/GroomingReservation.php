<?php
class GroomingReservation {
    private $_db,
            $_groomingReservationData,
            $_sessionName,
            $_cookieName;
    private $service;
    /**
     * @var array
     */
    private $dogs;

    /**
     * @param $service
     * @param array $dogs
     */
    public function __construct($service, array $dogs) {
        $this->_db = DB::getInstance();
        $this->_sessionName = Config::get("session/session_name");
        $this->_cookieName = Config::get("remember/cookie_name");


        $this->service = $service;
        $this->dogs = $dogs;
    }

    /**
     * Summary of createReservation
     * @param mixed $fields
     * @throws \Exception
     * @return void
     */
    public function createReservation($fields) {

        if (!$this->_db->insert('grooming_reservation', $fields)) {
            throw new Exception('There was a problem creating a grooming reservation');
        }
        $this->_groomingReservationData = $fields;
    }


    /**
     * @param mixed $reservationData
     */
    public function setReservationData($reservationData)
    {
        $this->_groomingReservationData = $reservationData;
    }

    /**
     * Used to retrieve grooming Reservation Data
     * @return mixed
     */
    public function getReservationData()
    {
        return $this->_groomingReservationData;
    }

     /**
     * Retrieves all unapproved grooming reservations (Admin Use)
     */
    public function getUnApprovedReservations(){
        //Gathers all data as a string
        $data = $this->_db->get('grooming_reservation', array('isApproved', '=', 0));

        if($data->count() > 0) {
            //Takes all data, sorts into an array so it can be printed in rows
            $this->_groomingReservationData = $data->results();
            return true;
        }else{
            return false;
        }
    }

    /**
     * Gets reservation using GroomResID
     */
    public function getReservationById($reservationId) {
        $fields = 'GroomResID';
        $data = $this->_db->get('grooming_reservation', array($fields, '=', $reservationId));

        if($data->count() > 0) {
            $this->_groomingReservationData = $data->first();
            return true;
        }
        return false;
    }

    /**
     * Get  Grooming Appointments by CustID
     * change name of function
     */
    public function getReservationsWithCustID($customer = null){
        if($customer){
        //Gathers all data as a string
        $whereConditions = array(
            'CustID', '=', $customer  // Assuming $custId is the value you want to match
        );

        $data = $this->_db->get('grooming_reservation', $whereConditions);

        if($data->count() > 0) {
            //Takes all data, sorts into an array so it can be printed in rows
            $this->_groomingReservationData = $data->results();
            return true;
        }else{
            return false;
        }
    }
    }

    /**
     * Gets unapproved reservations with customer id
     */
    public function getUnApprovedReservationsWithCustID($customer = null) {
        if ($customer) {
            $whereConditions = array(
                'isApproved' => 0,
                'CustID' => $customer
            );
    
            $data = $this->_db->selectWhere('grooming_reservation', $whereConditions);
    
            if ($data->count() > 0) {
                $this->_groomingReservationData = $data->results();
                return true;
            } else {
                return false;
            }
        }
    }

        /**
         * Gets confirmed confirmed reservations
         */
    public function getConfirmedGroomingReservations(){
        $whereConditions = array(
            'isApproved' => 1,
            'isFinished' => 0,
        );

        $data = $this->_db->selectWhere('grooming_reservation', $whereConditions);

        if ($data->count() > 0) {
            $this->_groomingReservationData = $data->results();
            return true;
        } else {
            return false;
        }

    }

        /**
         * Gets confirmed confirmed reservations
         */
        public function getConfirmedGroomingReservationsWithCustID($customer){
            $whereConditions = array(
                'isApproved' => 1,
                'isFinished' => 0,
                'CustID' => $customer
            );
    
            $data = $this->_db->selectWhere('grooming_reservation', $whereConditions);
    
            if ($data->count() > 0) {
                $this->_groomingReservationData = $data->results();
                return true;
            } else {
                return false;
            }
    
        }

         /**
         * Gets confirmed confirmed reservations
         */
        public function getAllGroomingReservations(){
            $whereConditions = array(
                1 => 1
            );
    
            $data = $this->_db->selectWhere('grooming_reservation', $whereConditions);
    
            if ($data->count() > 0) {
                $this->_groomingReservationData = $data->results();
                return true;
            } else {
                return false;
            }
    
        }

    /** 
     * Updates Grooming Reservation table
    */
    public function update( $fields, $key, $keyValue) {

        if(!$this->_db->updateTable('grooming_reservation', $fields, $key, $keyValue)) { // if ID provided, update provided user that matches id
            throw new Exception('There was a problem updating this user.');
        }
        return true;
    }

        /**
         * Marks the grooming appointment as complete
         */
        public function completeGroomingAppointment(){

        }
}









