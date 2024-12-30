<?php

namespace App\models;

class LoginModel extends Model
{
    protected int $id;
    public string $email = '';
    public string $password = '';
    public string $number = '';
    protected $roles;

    public function __construct()
    {
        $this->table();
    }

    public function table()
    {
        return $this->table = "users";
    }

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
        ];
    }

    /**
     *  cette fonction nous permet de mettre les labels des attributs
     *
     * @return array
     */
    public function attributeLabels(): array
    {
        return [

            'email' => 'Email',
            'password' => 'Password',
            'number' => 'Code de verification',
        ];
    }

    public function colums(): array
    {
        return [];
    }

    /**
     * cette fonction permet de définir une session d'utilsateur
     *
     * @return void
     */
    public function setSession()
    {
        $_SESSION['user'] = [
            'id' => $this->id,
            'email' => $this->email,
            'roles' => $this->roles
        ];
    }

    /**
     * function to get email for one user
     *
     * @param string $email
     * @return object
     */
    public function findOneByEmail(string $email)
    {
        return $this->requete("SELECT * FROM $this->table WHERE email= ?", [$email])->fetch();
    }

    /**
     * function to get email for one user
     *
     * @param string $email
     * @return void
     */
    public function findOneByCode(string $email)
    {
        return $this->requete("SELECT * FROM users_verify WHERE email= ?", [$email])->fetch();
    }

    /**
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of roles
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        $roles[] = 'ROLE_USER';

        // array_unique nous permet ne pas avoir de doublons dans le tableau
        return array_unique($roles);
    }

    /**
     * Set the value of roles
     */
    public function setRoles($roles): self
    {
        $this->roles = json_decode($roles);

        return $this;
    }
}
