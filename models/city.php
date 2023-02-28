<?php
    class City {
        private ?PDO $conn;
        private string $table_name = "city";
        public int $id;
        public string $name;
        
        public function __construct($db) {
            $this->conn = $db;
        }

        public function getId(): int | bool {
            $query = "SELECT id FROM " . $this->table_name . " WHERE name=:name";
            $stmt = $this->conn->prepare($query);
            $this->name = htmlspecialchars(strip_tags($this->name));
            $stmt->bindParam(":name", $this->name);
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num > 0) {
                $city_arr = array();
                $city_arr["cities"] = array();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                extract($row);
                return $id;
            }
            return false;
        }

        public function get(): bool | PDOStatement {
            $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        function create(): bool {
            $query = "INSERT INTO " . $this->table_name . " SET name=:name";
            $stmt = $this->conn->prepare($query);
            $this->name = htmlspecialchars(strip_tags($this->name));
            $stmt->bindParam(":name", $this->name);
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
            $query = "UPDATE " . $this->table_name . " SET name = :name WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->id = htmlspecialchars(strip_tags($this->id));
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":id", $this->id);
            if ($stmt->execute()) {
                return true;
            }
            return false;
        }
    }
?>