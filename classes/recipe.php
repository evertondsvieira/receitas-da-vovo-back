<?php

class Recipe
{
    private $conn;
    private $table = 'recipes';

    public $id;
    public $name;
    public $ingredients;
    public $preparation;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = "SELECT * FROM " . $this->table;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function read_single()
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
        $this->ingredients = $row['ingredients'];
        $this->preparation = $row['preparation'];
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table . " SET name = :name, ingredients = :ingredients, preparation = :preparation";
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->ingredients = htmlspecialchars(strip_tags($this->ingredients));
        $this->preparation = htmlspecialchars(strip_tags($this->preparation));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':ingredients', $this->ingredients);
        $stmt->bindParam(':preparation', $this->preparation);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function update()
    {
        $query = "UPDATE " . $this->table . "
                  SET name = :name, ingredients = :ingredients, preparation = :preparation
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->ingredients = htmlspecialchars(strip_tags($this->ingredients));
        $this->preparation = htmlspecialchars(strip_tags($this->preparation));

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':ingredients', $this->ingredients);
        $stmt->bindParam(':preparation', $this->preparation);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}