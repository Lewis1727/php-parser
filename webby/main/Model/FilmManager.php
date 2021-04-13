<?php

class FilmManager
{

    private $db;

    public function __construct($dbConnection)
    {
        if ($dbConnection instanceof mysqli) {
            $this->db = $dbConnection;
        } else {
            throw new Exception('Connection injected should be of Mysqli object');
        }
    }

    public function findAllFilms()
    {
        $posts = [];
        $query = "SELECT * FROM `films` ORDER BY name ASC";
        $result = $this->db->query($query);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $posts[] = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'year' => $row['year'],
                    'format' => $row['format'],
                    'actors' => $row['actors']
                ];
            }
            $result->close();
        } else {
            echo($this->db->error);
        }
        return $posts;
    }

    public function findFilm($search)
    {
        if ( is_string($search) == true){

                $films = [];


                $query = "SELECT * FROM `films` WHERE name LIKE '%$search%' OR actors LIKE '%$search%' ORDER BY name ASC";
                $result = $this->db->query($query);

                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $films[] = [
                            'id' => $row['id'],
                            'name' => $row['name'],
                            'year' => $row['year'],
                            'format' => $row['format'],
                            'actors' => $row['actors']
                        ];
                    }
                    $result->close();
                } else {
                    echo($this->db->error);
                }

        }       
       
        return $films;
    }

    public function addFilm($name, $year, $format, $actors)
    {
        $query = "INSERT INTO films (
              `name`, `year`, `format`, `actors`
          )
          VALUES (
              '%s', '%s', '%s', '%s'
          )";
        $query = \sprintf($query, $this->db->real_escape_string($name), $this->db->real_escape_string($year), $this->db->real_escape_string($format), $this->db->real_escape_string($actors));
        if ($result = $this->db->query($query)) {
            return true;
        } else {
            die($this->db->error);
        }
    }

    public function deleteFilm($id)
    {
        $query = "DELETE FROM films WHERE id='%s'";
        $query = \sprintf($query, $this->db->real_escape_string($id));
        if ($result = $this->db->query($query)) {
            return true;
        } else {
            die($this->db->error);
        }
    }



}