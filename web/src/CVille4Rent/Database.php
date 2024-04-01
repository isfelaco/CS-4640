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


        $queryCheckEmpty = "SELECT COUNT(*) FROM apartments";
        $result = $this->query($queryCheckEmpty);

        if ($result[0]['count'] == 0) {
            // Insert data from JSON file
            $this->insertDataFromJson('/opt/src/CVille4Rent/data/apartments.json');
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
        $queryCreateTable = "
            CREATE TABLE IF NOT EXISTS apartments (
                id SERIAL PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                description TEXT,
                address TEXT,
                rent DECIMAL(10, 2),
                bedrooms INT,
                bathrooms INT
            )
        ";

        $this->query($queryCreateTable);
    }

    private function insertDataFromJson($jsonFile)
    {
        // Read and parse the JSON file
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

    public function dropTables()
    {
        // Drop the apartments table
        $queryDropApartmentsTable = "DROP TABLE IF EXISTS apartments";
        $this->query($queryDropApartmentsTable);

        echo "Tables dropped successfully.";
    }


    public function getApartment($apartmentName)
    {
        $query = "
            SELECT * FROM apartments WHERE name = $1
        ";
        $result = $this->query($query, $apartmentName);
        return $result;
    }
}
