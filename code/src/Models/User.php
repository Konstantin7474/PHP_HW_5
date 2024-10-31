<?php

namespace Geekbrains\Application1\Models;

class User {

    private ?string $userName;
    private ?int $userBirthday;

    private static string $storageAddress = '/storage/birthdays.txt';

    public function __construct(string $name = null, int $birthday = null){
        $this->userName = $name;
        $this->userBirthday = $birthday;
    }

    public function setName(string $userName) : void {
        $this->userName = $userName;
    }

    public function getUserName(): string {
        return $this->userName;
    }

    public function getUserBirthday(): int {
        return $this->userBirthday;
    }

    public function setBirthdayFromString(string $birthdayString) : void {
        $this->userBirthday = strtotime($birthdayString);
    }


    public function save(): bool {
        $address = $_SERVER['DOCUMENT_ROOT'] . self::$storageAddress;
        $userString = $this->userName . "," . date('Y-m-d', $this->userBirthday) . "\n";

        if (file_put_contents($address, $userString, FILE_APPEND | LOCK_EX)) {
            return true;
        } else {
            return false;
        }
    }

    public static function getAllUsersFromStorage(): array|false {
        $address = $_SERVER['DOCUMENT_ROOT'] . self::$storageAddress;
        
        if (file_exists($address) && is_readable($address)) {
            $file = fopen($address, "r");
            
            $users = [];
        
            while (!feof($file)) {
                $userString = fgets($file);
                $userArray = explode(",", $userString);

                if (isset($userArray[1])) {
                    $user = new User($userArray[0]);
                    $user->setBirthdayFromString($userArray[1]);
                    $users[] = $user;
                }
            }
            
            fclose($file);

            return $users;
        }
        else {
            return false;
        }
    }
}