<?php
require_once __DIR__ . '/../autoload.php';

class VehicleController
{

    public function listVehicles()
    {
        session_start();
        $vehicles = (new Vehicle())->getAllVehicles();
        return  $vehicles;
    }

    public function showVehicle($id)
    {
        session_start();
        $vehicle = (new Vehicle())->getVehicle($id);
        return $vehicle;
    }

    public function storeVehicle()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryId = (int)$_POST['vehicleIdCategory'];

            $vehicle = new Vehicle();
            $vehicle->vehicleImage = $_POST['vehicleImage'];
            $vehicle->vehicleModel = htmlspecialchars($_POST['vehicleModel']);
            $vehicle->vehicleDescription = htmlspecialchars($_POST['vehicleDescription']);
            $vehicle->vehiclePricePerDay = (float)$_POST['vehiclePricePerDay'];
            $vehicle->vehicleAvailability = isset($_POST['vehicleAvailability']);
            $vehicle->vehicleIdCategory = $_POST['vehicleIdCategory'];

            $result = $vehicle->addVehicle();
            return $result;
        }
    }


    public function updateVehicle($id)
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryId = (int)$_POST['vehicleIdCategory'];

            $vehicle = new Vehicle();
            $vehicle->vehicleImage = $_POST['vehicleImage'];
            $vehicle->vehicleModel = htmlspecialchars($_POST['vehicleModel']);
            $vehicle->vehicleDescription = htmlspecialchars($_POST['vehicleDescription']);
            $vehicle->vehiclePricePerDay = (float)$_POST['vehiclePricePerDay'];
            $vehicle->vehicleAvailability = isset($_POST['vehicleAvailability']) ? 1 : 0;
            $vehicle->vehicleIdCategory = $categoryId;

            $result = $vehicle->updateVehicle($id);
            return $result;
        }
    }

    public function deleteVehicle($id)
    {
        session_start();

        $result = (new Vehicle())->deleteVehicle($id);
        return $result;
    }
}