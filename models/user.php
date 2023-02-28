<?php
    class User {
        private ?PDO $conn;
        private string $table_name = "user";
        public int $id;
        public string $username;
        public string $city;
        public string $name;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function get(): bool|PDOStatement {
            $query = "SELECT usr.id, usr.name, usr.username, ct.name as city FROM " . $this->table_name . " usr" . " JOIN city ct ON usr.city_id=ct.id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        function create(): bool {
            $query = "INSERT INTO " . $this->table_name . " SET name=:name, city_id=:city, username=:username";
            $stmt = $this->conn->prepare($query);

            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->city = htmlspecialchars(strip_tags($this->city));
            $this->username = htmlspecialchars(strip_tags($this->username));

            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":city", $this->city);
            $stmt->bindParam(":username", $this->username);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        }

        function delete(): bool {
            $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
            $stmt = $this->conn->prepare($query);
            $this->id = htmlspecialchars(strip_tags($this->id));
            $stmt->bindParam(":id", $this->id);
            if ($stmt->execute()) {
                return true;
            }
            return false;
        }

        function update(): bool {
            $query = "UPDATE " . $this->table_name . " SET name=:name, username=:username, city_id=:city_id" . " WHERE id=" . $this->id;
            $stmt = $this->conn->prepare($query);

            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->city = htmlspecialchars(strip_tags($this->city));

            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":city_id", $this->city);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        }
    }
?>