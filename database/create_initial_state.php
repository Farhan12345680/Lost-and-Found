<?php
    if(session_status() === PHP_SESSION_NONE){
        session_start();

    }   
class PDO_ {

    private static $init = null;
    public $pdo;

    public static function initializer() {
        if (self::$init !== null) {
            return self::$init;
        }
        self::$init = new PDO_();
        return self::$init;
    }

    private function __construct() {
        $this->pdo = new PDO("mysql:host=localhost;port=3306;charset=utf8mb4", 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->pdo->exec("CREATE DATABASE IF NOT EXISTS UIU_LOST_AND_FOUND CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");

        $this->pdo = new PDO("mysql:host=localhost;port=3306;dbname=UIU_LOST_AND_FOUND;charset=utf8mb4", 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->createTables();
    }


    private function createTables() {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS users (
                user_id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
                name VARCHAR(128) NOT NULL,
                email VARCHAR(128) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                workTitle VARCHAR(150) DEFAULT 'User',
                Address VARCHAR(150) DEFAULT 'Not given',
                Phone VARCHAR(150) DEFAULT 'Not given',
                JoinedDate DATETIME DEFAULT CURRENT_TIMESTAMP,
                Description VARCHAR(300) DEFAULT 'Normal User',
                imageURL VARCHAR(256) NOT NULL DEFAULT 'https://res.cloudinary.com/dvpwqtobj/image/upload/v1757076286/user_xhxvc9.png'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS items (
                item_id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
                posterGmail VARCHAR(128) NOT NULL,
                title VARCHAR(300) NOT NULL,
                keywords VARCHAR(300),
                description VARCHAR(500),
                imageURL VARCHAR(200) DEFAULT 'https://static.thenounproject.com/png/default-image-icon-4595376-512.png',
                itemType VARCHAR(100) DEFAULT 'Found',
                isResolved VARCHAR(30) DEFAULT 'OPEN',
                PostDate DATETIME DEFAULT CURRENT_TIMESTAMP,
                location VARCHAR(200) DEFAULT 'Dhaka, Bangladesh',
                latitude DECIMAL(10,8),
                longitude DECIMAL(11,8),
                CONSTRAINT fk_user_email
                    FOREIGN KEY (posterGmail) REFERENCES users(email)
                    ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS messages (
                message_id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
                sender_email VARCHAR(128) NOT NULL,
                receiver_email VARCHAR(128) NOT NULL,
                item_id CHAR(36) NOT NULL,
                message TEXT NOT NULL,
                sent_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT fk_sender_email_msg
                    FOREIGN KEY (sender_email) REFERENCES users(email)
                    ON DELETE CASCADE,
                CONSTRAINT fk_receiver_email_msg
                    FOREIGN KEY (receiver_email) REFERENCES users(email)
                    ON DELETE CASCADE,
                CONSTRAINT fk_message_item
                    FOREIGN KEY (item_id) REFERENCES items(item_id)
                    ON DELETE CASCADE,
                INDEX(sender_email),
                INDEX(receiver_email),
                INDEX(item_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");
    }

    public function  checkSameMail(string $email): bool
    {
        $stmt = $this->pdo->prepare("SELECT 1 FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);

        return $stmt->fetchColumn() !== false;
    }

    public function InsertNewUser($name ,$email , $password){

        if ($name === "" || $email === "" || $password === "") {
            $status = "error";
            $message = "All fields are required.";
            $_SESSION['error']=$message;
            header("Location: error_page.php");
            exit();
        } else {
            $result = $this->NewUser(['name'=>$name,'email'=>$email,'password'=> $password]); 
            if ($result['status'] === "error") {
                $status = "error";
                $message = $result['message'];
                $_SESSION['error']=$message;
                header("Location: error_page.php");
                exit();
            } else {
                $status = "success";
                $message = "Account created successfully!";
                header("Location: ./../index.php");
                exit();
            }
        }
    }

    public function NewUser(array $data): array
    {
        $name=$data['name'];
        $email=$data['email'];
        $password=$data['password'];

        if ($name === '' || $email === '' || $password === '') {
            return [
                'status' => 'error',
                'message' => 'All fields are required'
            ];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'status' => 'error',
                'message' => 'Invalid email format'
            ];
        }

        if (strlen($password) < 6) {
            return [
                'status' => 'error',
                'message' => 'Password must be at least 6 characters'
            ];
        }

        try {


            if ($this->checkSameMail($email )) {
                return [
                    'status' => 'error',
                    'message' => 'Email already exists'
                ];
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $defaultImage = "https://res.cloudinary.com/dvpwqtobj/image/upload/v1757076286/user_xhxvc9.png";

            $stmt =  $this->pdo->prepare(
                "INSERT INTO users (name, email, password, imageURL, JoinedDate)
                VALUES (:name, :email, :password, :imageURL, :joined)"
            );

            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':imageURL' => $defaultImage,
                ':joined' => date("Y-m-d")
            ]);

            $_SESSION['gmail']=$email;
            $_SESSION['password'] = $hashedPassword;
            $_SESSION['userimage']=$defaultImage;
            $_SESSION['username']=$name;
            $_SESSION['user_id']=($this->pdo->prepare("SELECT user_id FROM users WHERE email = '$email'"))->execute();

            return 
                [
                    'error' => 'success'
                
                ]
            ;

        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }

    public function checkLogin($email, $password): array
    {
        if ($email === '' || $password === '') {
            return [
                'status' => 'error',
                'message' => 'Email and password are required'
            ];
        }

        try {
            $stmt = $this->pdo->prepare(
                "SELECT user_id, name, email, password, imageURL 
                FROM users 
                WHERE email = ? LIMIT 1"
            );
            $stmt->execute([$email]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return [
                    'status' => 'error',
                    'message' => 'User not found'
                ];
            }

            if (!password_verify($password, $user['password'])) {
                return [
                    'status' => 'error',
                    'message' => 'Invalid password'
                ];
            }

            $_SESSION['user_id']  = $user['user_id'];
            $_SESSION['gmail']    = $user['email'];
            $_SESSION['username'] = $user['name'];
            $_SESSION['userimage']= $user['imageURL'];

            return [
                'status' => 'success',
                'message' => 'Login successful'
            ];

        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }
  

}
