<?php
class DB
{
    private static $instance = null;
    private $conn = null;
    private function __construct()
    {
        $servername = "localhost";
        $username = "root";
        $password = "159753258000kK";
        $database = "weatherservice";
        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $this->conn = $conn;
    }

    public static function GetInstance()
    {
        if (self::$instance == null) {
            self::$instance = new DB();
        }
        return self::$instance;
    }
    public function LoginUser($email, $password)
    {

        $sql = "SELECT * FROM User WHERE email=? AND password=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows < 1) {
            throw new Exception("Invalid credentials");
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function RegisterUser($email, $password, $name)
    {

        $sql = "INSERT INTO User (email,password,name) VALUES (?,?,?)";
        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param("sss", $email, $password, $name);
            $stmt->execute();
            $result = $stmt->insert_id;
            $stmt->close();
            if (!$result) {
                throw new Exception();
            } else {
                return $result;
            }
        } else {
            $this->displayError();
        };
    }
    public function GetUserLocations($id)
    {
        $sql = "SELECT * FROM Location WHERE userID=?";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function DeleteLocation($id, $userID)
    {
        $sql = "DELETE FROM Location WHERE id=? and userid=?";
        $stmt = $this->conn->prepare($sql);
        $this->displayError();
        $stmt->bind_param("ii", $id, $userID);
        $stmt->execute();
        $rows = $stmt->affected_rows;
        echo $rows;
        $stmt->close();
        return  $rows;
    }
    public function RegisterLocation($name, $userID, $coordX, $coordY, $fullAddress)
    {

        $sql = "INSERT INTO Location (name,userID,coordX,coordY,fullAddress) VALUES (?,?,?,?,?)";
        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param("siiis", $name, $userID, $coordX, $coordY, $fullAddress);
            $stmt->execute();
            $result = $stmt->insert_id;
            $stmt->close();
            $this->displayError();
            if (!$result) {
                throw new Exception();
            } else {
                return $result;
            }
        } else {
            $this->displayError();
        };
    }

    private function displayError()
    {
        $error = $this->conn->errno . ' ' . $this->conn->error;
        echo $error;
    }
    public function __clone()
    {
        throw new Exception("Not allowed");
    }
}
