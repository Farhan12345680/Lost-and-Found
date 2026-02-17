<?php

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
}
