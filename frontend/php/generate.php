<?php
// Этот скрипт создает 105 выдуманных пользователей
// и сохраняет их в users.json

$avatars = ["👨", "👩", "🧑", "🧔", "🧓", "🕵️‍♂️", "👮‍♀️", "👷", "👸", "🧙‍♂️", "🧛‍♀️", "🧟", "🤖", "👽"];
$names = ["Alex", "Jordan", "Casey", "Taylor", "Morgan", "Jamie", "Riley", "Avery"];
$surnames = ["Smith", "Doe", "Johnson", "Brown", "Williams", "Jones", "Garcia", "Miller"];

$users = [];

for ($i = 1; $i <= 105; $i++) {
    // Случайный выбор аватара и имени
    $rand_avatar = $avatars[array_rand($avatars)];
    $rand_name = $names[array_rand($names)] . " " . $surnames[array_rand($surnames)];
    
    $users[] = [
        "id" => uniqid(),
        "name" => $rand_name . " (" . $i . ")", // Добавляем номер, чтобы различать их
        "email" => "user" . $i . "@example.com",
        "avatar" => $rand_avatar
    ];
}

// Превращаем массив в JSON и сохраняем в файл
file_put_contents("users.json", json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo "<h1>Готово!</h1>";
echo "<p>Создано 105 пользователей. Теперь открой <a href='index.php'>index.php</a>.</p>";
?>