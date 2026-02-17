<?php


function checkSameMail(string $email, PDO $pdo): bool
{
    $stmt = $pdo->prepare("SELECT 1 FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);

    return $stmt->fetchColumn() !== false;
}
