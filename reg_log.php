<?php
class Db
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "tura";

    protected $connection;

    public function __construct()
    {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->connection->connect_error) {
            die("Kapcsolódási hiba: " . $this->connection->connect_error);
        }
    }

    public function __destruct()
    {
        $this->connection->close();
    }
}

class Reg extends Db
{
    function regUser($name, $nickname, $phone, $email, $intro, $psw)
    {
        $hashedPassword = password_hash($psw, PASSWORD_DEFAULT);
        $stmt = $this->connection->prepare("INSERT INTO tag 
                                            (nev, becenev, telefon, email, bemutatkozas, jelszo) 
                                            VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $nickname, $phone, $email, $intro, $hashedPassword);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}

class Log extends Db
{
    function logUser($nickname, $psw)
    {
        $stmt = $this->connection->prepare("SELECT jelszo FROM tag WHERE becenev = ?");
        $stmt->bind_param("s", $nickname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($psw, $row['jelszo'])) {
                return true;
            }
        }

        return false;
    }
}

$registration = new Reg();
$registration->regUser("peldanev", "peldabecenev", "peldatelefon", "pelda@example.com", "peldaintro", "jelszo123");

$login = new Log();
$loggedIn = $login->logUser("peldabecenev", "jelszo123");
if ($loggedIn) {
    echo "Sikeres bejelentkezés";
} else {
    echo "Hibás felhasználónév vagy jelszó";
}

/*Az Database osztály tartalmazza az adatbáziskapcsolatot és a 
kapcsolat bezárását végző függvényt. Az osztályváltozók és metódusok 
private vagy protected, hogy csak az osztály belül vagy az osztály 
leszármazottaiban legyenek láthatók.

Az Registration osztály a felhasználók regisztrációját végző függvényt 
tartalmazza. Az osztály extends Database utasítással örököli az 
adatbáziskapcsolatot és a kapcsolat bezárását végző függvény 
A $hashedPassword változó létrehozása a Registration osztály registerUser() 
metódusában történik. Ez a változó a felhasználó jelszavát titkosítja a 
password_hash() függvénnyel, amely az alapértelmezett algoritmust használja a 
jelszó biztonságos tárolásához. Az algoritmus kiválasztása a PASSWORD_DEFAULT 
konstans használatával történik.

A password_hash() függvény a jelszó egy irreverzibilis hash értékét adja vissza, 
amelyet a szerveren tárolnak, és amelyet nem lehet visszafejteni a tényleges jelszóra. 
Ez biztonságosabbá teszi a felhasználó jelszavának tárolását, mivel még akkor sem 
lehet megtudni a jelszót, ha valamilyen módon sikerült megszerezni a titkosított 
jelszót.

A $hashedPassword értéke aztán bekerül a $stmt objektum által előkészített és a 
bind_param() metódussal behelyettesített adatok közé, amelyeket az adatbázisba 
küldenek a felhasználó regisztrációjakor. A jelszó ezen a ponton már titkosítva van, 
és biztonságosan tárolható az adatbázisban.*/