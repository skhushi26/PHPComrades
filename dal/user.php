<?php
require_once "dbhelper.php";
session_start();

class User
{
  protected $user_id;
  protected $name;
  protected $email;
  protected $password;
  protected $phone;
  protected $province;

  protected $errors = [];
  function getErrors()
  {
    return $this->errors;
  }
  function clearErrors()
  {
    $this->errors = [];
  }

  function getUserId()
  {
    return $this->user_id;
  }
  function setUserId($user_id)
  {
    $this->user_id = trim(htmlSpecialChars($user_id));
    if (empty($this->user_id)) {
      $this->errors["user_id"] = "<p>User Id is required.</p>";
    } elseif (!filter_var($user_id, FILTER_VALIDATE_INT)) {
      $this->errors["user_id"] = "<p>User Id is invalid.</p>";
    }
    $this->user_id = (int) $this->user_id;
  }

  function getName()
  {
    return $this->name;
  }
  function setName($name)
  {
    $this->name = trim(htmlSpecialChars($name));
    if (empty($this->name)) {
      $this->errors["name"] = "Name is required.";
    }
  }

  function getEmail()
  {
    return $this->email;
  }
  function setEmail($email)
  {
    $this->email = trim(htmlSpecialChars($email));
    if (empty($this->email)) {
      $this->errors["email"] = "Email is required.";
    } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
      $this->errors["email"] = "Email is invalid.";
    }
  }

  function getPassword()
  {
    return $this->password;
  }
  function setPassword($password)
  {
    $this->password = trim(htmlSpecialChars($password));
    if (empty($this->password)) {
      $this->errors["password"] = "Password is required.";
    }
  }

  function getPhone()
  {
    return $this->phone;
  }
  function setPhone($phone)
  {
    $this->phone = trim(htmlSpecialChars($phone));
    if (empty($this->phone)) {
      $this->errors["phone"] = "Phone is required.";
    }
  }

  function getProvince()
  {
    return $this->province;
  }
  function setProvince($province)
  {
    $this->province = trim(htmlSpecialChars($province));
    if (empty($this->province) || $this->province == "-1") {
      $this->errors["province"] = "Province is required.";
    } elseif (
      !in_array($this->province, [
        "Select a province..",
        "ON",
        "AB",
        "BC",
        "MB",
      ])
    ) {
      $this->errors["province"] = "Province is invalid.";
    }
  }

  function __construct($properties = [])
  {
    if (isset($properties["user_id"])) {
      $this->setUserId($properties["user_id"]);
    }
    if (isset($properties["name"])) {
      $this->setName($properties["name"]);
    }
    if (isset($properties["email"])) {
      $this->setEmail($properties["email"]);
    }
    if (isset($properties["phone"])) {
      $this->setPhone($properties["phone"]);
    }
    if (isset($properties["province"])) {
      $this->setProvince($properties["province"]);
    }
  }

  function find($user_id)
  {
    if (filter_var($user_id, FILTER_VALIDATE_INT)) {
      $sql = new DBHelper();
      $sql
        ->statement("SELECT * FROM users WHERE user_id=:user_id")
        ->params(["user_id" => $this->getUserId()])
        ->execute()
        ->forOne(function ($row, $userDefinedData) {
          $userDefinedData->setUserId($row["user_id"]);
          $userDefinedData->setName($row["name"]);
          $userDefinedData->setEmail($row["email"]);
          $userDefinedData->setPhone($row["phone"]);
          $userDefinedData->setProvince($row["province"]);
        }, $this);
    }
  }

  function insert()
  {
    $sql = new DBHelper();
    $passwordhash = password_hash($this->password, PASSWORD_DEFAULT);
    $sql
      ->statement(
        "INSERT INTO users (name, email, password, phone, province) VALUES (:name, :email, :password, :phone, :province)"
      )
      ->params([
        "name" => $this->getName(),
        "password" => $passwordhash,
        "email" => $this->getEmail(),
        "phone" => $this->getPhone(),
        "province" => $this->getProvince(),
      ])
      ->execute();
    $this->user_id = $sql->getConnection()->lastInsertId();
    return $sql->getRowCount();
  }

  function update()
  {
    $sql = new DBHelper();

    // GET USER ID FROM SESSION WHEN USER LOGGED IN

    $sql
      ->statement(
        "UPDATE users SET name = :name, email = :email, phone = :phone, province = :province WHERE user_id = :user_id"
      )
      ->params([
        "user_id" => $this->getUserId(),
        "name" => $this->getName(),
        "email" => $this->getEmail(),
        "phone" => $this->getPhone(),
        "province" => $this->getProvince(),
      ])
      ->execute();
    return $sql->getRowCount();
  }

  function delete()
  {
    $sql = new DBHelper();
    $sql
      ->statement("DELETE FROM users WHERE user_id=:user_id")
      ->params([
        "user_id" => $this->getUserId(),
      ])
      ->execute();
    return $sql->getRowCount();
  }

  # LOGIN #
  function login($email, $password)
  {
    $sql = new DBHelper();
    $sql
      ->statement("SELECT * FROM users WHERE email=:email")
      ->params([
        "email" => $email,
      ])
      ->execute();

    $result = $sql->getResult();

    if (count($result) == 1) {
      $row = $result[0]; // Access the first row of the result array

      $passwordHash = $row["password"];

      $passwordhash1 = password_hash($password, PASSWORD_DEFAULT);
      echo "Password hash 1 : " . $passwordhash1;
      echo "Password hash 2 : " . $passwordHash;
      if ($passwordhash1 == $passwordHash) {
        session_regenerate_id();
        $_SESSION["user_id"] = $row["user_id"];
        return true;
      } else {
        echo "Passwords not matching";
      }
    }
    //     if (password_verify($password, $passwordHash)) {
    //         session_regenerate_id();
    //         $_SESSION["user_id"] = $row["user_id"];
    //         return true;
    //     }
    //     else
    //     {
    //       echo "Passwords not matching";
    //     }
    // }
    return false;
  }

  #END LOGIN #
}
