<?php 
include "../../config/connect.php";

class reservation {
    private $conn;

    public function __construct () {
        $db = new Database();
        $this->conn = $db->getdatabase();
    }

    public function affAllReservation () {
        try {
            $query = "SELECT * FROM reservation";
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            $reservation = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $reservation;
        } catch (Exception $e) {
            throw new Error("cannot get reservation:" . $e->getMessage());
        }
    }

    public function bookRes ($user_id, $vehicule_id, $date_rsv) {
        try {
            $query = "INSERT INTO reservation (user_id, vehicule_id, date_rsv) VALUE (:user_id, :vehicule_id, :date_rsv)";
            $stmt = $this->conn->prepare($query);

            $param = [
                        ":user_id" => $user_id,
                        ":vehicule_id" => $vehicule_id,
                        ":date_rsv" => $date_rsv];
            
            $stmt->execute($param);
        } catch (Exception $e) {
            throw new Error("cannot book reservation:" . $e->getMessage());
        }

    }

    public function cancelRes ($res_id) {
        try {
            $id = htmlspecialchars(intval($res_id));
            $query = "DELETE FROM reservation WHERE res_id = :id";
            $stmt = $this->conn->prepare($query);

            $param = [":id" => $id];

            $stmt->execute($param);
        } catch (Exception $e) {
            throw new Error("cannot cancel reservation:" . $e->getMessage());
        }
    }
}

$rsv = new reservation();
$res = $rsv->bookRes(7, 2, "2021-06-01");