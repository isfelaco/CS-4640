<?php
/**
 * Database Class
 *
 * Contains connection information to query PostgresSQL.
 */


class Database
{
    private $dbConnector;

    /**
     * Constructor
     *
     * Connects to PostgresSQL
     */
    public function __construct()
    {
        $host = Config::$db["host"];
        $user = Config::$db["user"];
        $database = Config::$db["database"];
        $password = Config::$db["pass"];
        $port = Config::$db["port"];

        $this->dbConnector = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");

        // drop tables
        // $this->dropTables();

        // Create tables if they don't exist
        $this->createTables();

        // insert a user
        $queryCheckEmpty = "SELECT COUNT(*) FROM users";
        $result = $this->query($queryCheckEmpty);

        if ($result[0]['count'] == 0) {
            $this->query(
                "INSERT INTO users (email, password) values ($1, $2);",
                "user1@example.com",
                // Use the hashed password!
                password_hash("pass1", PASSWORD_DEFAULT)
            );
        }

        // insert data from JSON file into apartments table
        $queryCheckEmpty = "SELECT COUNT(*) FROM apartments";
        $result = $this->query($queryCheckEmpty);

        if ($result[0]['count'] == 0) {
            $this->insertApartmentDataFromJson('/opt/src/CVille4Rent/data/apartments.json');
        }

        // insert data from JSON file into ratings table
        $queryCheckEmpty = "SELECT COUNT(*) FROM ratings";
        $result = $this->query($queryCheckEmpty);

        if ($result[0]['count'] == 0) {
            $this->insertRatingsDataFromJson('/opt/src/CVille4Rent/data/ratings.json');
        }

        // insert data from JSON file into favorited_apartments table
        $queryCheckEmpty = "SELECT COUNT(*) FROM favorited_apartments";
        $result = $this->query($queryCheckEmpty);

        if ($result[0]['count'] == 0) {
            $this->insertFavoritedApartmentsDataFromJson('/opt/src/CVille4Rent/data/favorited_apartments.json');
        }
    }


    /**
     * Query
     *
     * Makes a query to posgres and returns an array of the results.
     * The query must include placeholders for each of the additional
     * parameters provided.
     */
    public function query($query, ...$params)
    {
        $res = pg_query_params($this->dbConnector, $query, $params);

        if ($res === false) {
            echo pg_last_error($this->dbConnector);
            return false;
        }

        return pg_fetch_all($res);
    }

    private function createTables()
    {
        $queryCreateUsers = "
          CREATE TABLE IF NOT EXISTS users (
                email VARCHAR(100) PRIMARY KEY,
                password VARCHAR(100)
            )
        ";
        $this->query($queryCreateUsers);

        $queryCreateApartments = "
            CREATE TABLE IF NOT EXISTS apartments (
                name VARCHAR(100) PRIMARY KEY,
                description TEXT,
                address TEXT,
                rent DECIMAL(10, 2),
                bedrooms INT,
                bathrooms INT
            )
        ";
        $this->query($queryCreateApartments);

        $queryCreateRatings = "
          CREATE TABLE IF NOT EXISTS ratings (
                user_email VARCHAR(100),
                title VARCHAR(100),
                apartment_name VARCHAR(100) NOT NULL,
                rating DECIMAL(10, 2),
                rent_paid DECIMAL(10, 2),
                comment TEXT,
                PRIMARY KEY (user_email, title),
                FOREIGN KEY (user_email) REFERENCES users(email),
                FOREIGN KEY (apartment_name) REFERENCES apartments(name)
            )
        ";
        $this->query($queryCreateRatings);

        $queryCreateFavoritedApartments = "
          CREATE TABLE IF NOT EXISTS favorited_apartments (
                user_email VARCHAR(100),
                apartment_name VARCHAR(100),
                PRIMARY KEY (user_email, apartment_name),
                FOREIGN KEY (user_email) REFERENCES users(email),
                FOREIGN KEY (apartment_name) REFERENCES apartments(name)
            )
        ";
        $this->query($queryCreateFavoritedApartments);
    }

    private function insertApartmentDataFromJson($jsonFile)
    {
        $apartmentsJson = file_get_contents($jsonFile);
        $apartmentsData = json_decode($apartmentsJson, true);

        foreach ($apartmentsData as $apartment) {
            $queryInsert = "
                INSERT INTO apartments (name, description, address, rent, bedrooms, bathrooms)
                VALUES ($1, $2, $3, $4, $5, $6)
            ";
            $params = [
                $apartment['name'],
                $apartment['description'],
                $apartment['address'],
                $apartment['rent'],
                $apartment['bedrooms'],
                $apartment['bathrooms']
            ];
            $this->query($queryInsert, ...$params);
        }
    }


    private function insertRatingsDataFromJson($jsonFile)
    {
        $ratingsJSON = file_get_contents($jsonFile);
        $ratingsData = json_decode($ratingsJSON, true);

        foreach ($ratingsData as $rating) {
            $queryInsert = "
                INSERT INTO ratings (user_email, title, apartment_name, rating, rent_paid, comment)
                VALUES ($1, $2, $3, $4, $5, $6)
            ";
            $params = [
                $rating['user_email'],
                $rating['title'],
                $rating['apartment_name'],
                $rating['rating'],
                $rating['rent_paid'],
                $rating['comment']
            ];
            $this->query($queryInsert, ...$params);
        }
    }

    private function insertFavoritedApartmentsDataFromJson($jsonFile)
    {
        $favoritesJSON = file_get_contents($jsonFile);
        $favoritesData = json_decode($favoritesJSON, true);

        foreach ($favoritesData as $favorite) {
            $queryInsert = "
                INSERT INTO favorited_apartments (user_email, apartment_name)
                VALUES ($1, $2)
            ";
            $params = [
                $favorite['user_email'],
                $favorite['apartment_name']
            ];
            $this->query($queryInsert, ...$params);
        }
    }

    public function dropTables()
    {
        $queryDropTables = "DROP TABLE IF EXISTS ratings, favorited_apartments, apartments, users CASCADE;";
        $this->query($queryDropTables);
        echo "Tables dropped successfully.";
    }

    /**
     * Get all apartments
     */
    public function getApartments()
    {
        $query = "SELECT * FROM apartments";
        $result = $this->query($query);
        return $result;
    }

    /**
     * Get paginated apartments
     */
    public function getApartmentsPaginated($page = 1, $perPage = 3)
    {
        // Calculate the offset based on the current page and items per page
        $offset = ($page - 1) * $perPage;

        // Prepare the SQL query with LIMIT and OFFSET clauses
        $query = "SELECT * FROM apartments LIMIT $perPage OFFSET $offset";
        $result = $this->query($query);
        return $result;
    }

    /**
     * Get apartment by apartment name
     */
    public function getApartment($apartmentName)
    {
        $query = "SELECT * FROM apartments WHERE name = $1";
        $result = $this->query($query, $apartmentName);
        return $result;
    }

    /**
     * Get ratings by apartment name
     */
    public function getRatings($apartmentName)
    {
        $query = "SELECT * FROM ratings WHERE apartment_name = $1";
        $result = $this->query($query, $apartmentName);
        return $result;
    }

    /**
     * Get apartments favorited by the user
     */
    public function getFavoritedApartments($user)
    {
        $query = "SELECT a.* 
            FROM favorited_apartments fa
            JOIN apartments a ON fa.apartment_name = a.name
            WHERE fa.user_email = $1;";
        $result = $this->query($query, $user);
        return $result;
    }

    /**
     * Get ratings posted by a user
     */
    public function getUserRatings($user)
    {
        $query = "SELECT * FROM ratings WHERE user_email = $1";
        $result = $this->query($query, $user);
        return $result;
    }

    /**
     * Favorite an apartment
     */
    public function favoriteApartment($user_email, $apartment_name)
    {
        $query = "INSERT INTO favorited_apartments(user_email, apartment_name) VALUES ($1, $2)";
        $this->query($query, $user_email, $apartment_name);
    }

    /**
     * Un-favorite an apartment
     */
    public function unfavoriteApartment($user_email, $apartment_name)
    {
        $query = "DELETE FROM favorited_apartments WHERE user_email = $1 AND apartment_name = $2";
        $this->query($query, $user_email, $apartment_name);
    }
}
