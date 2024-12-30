<?php

namespace App\models;


class UsresModel extends Model
{


    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public string $password = '';
    public string $passwordConfirm = '';
    protected $roles;

    public function __construct()
    {
        $this->table();
    }

    public function table()
    {
        return $this->table = "users";
    }

    /**
     * cette donne les règles de chaque attributs
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_UNIQUE, 'class' => self::class,
            ]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
            'passwordConfirm' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
    }

    /**
     * cette fonction nous permet de définir les colonnes dans la table users 
     *
     * @return array
     */
    public function colums(): array
    {
        return [
            'firstname',
            'lastname',
            'email',
            'password',
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
            'firstname' => 'First name ',
            'lastname' => 'Last name ',
            'email' => 'Email',
            'password' => 'Password',
            'passwordConfirm' => 'Confirm password',
        ];
    }

    /**
     * cette fonction nous permet d'inserer les données dans la table users_verify
     *
     * @param [type] $data
     * @return void
     */
    public function creat_verify($data)
    {
        $keys = array_keys($data);
        return $this->requete("INSERT INTO users_verify (" . implode(",", $keys) . ") values (:" . implode(",:", $keys) . ")", $data);
    }

    /**
     * Get the value of firstname
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
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
     * Get the value of passwordConfirm
     */
    public function getPasswordConfirm(): string
    {
        return $this->passwordConfirm;
    }

    /**
     * Set the value of passwordConfirm
     */
    public function setPasswordConfirm(string $passwordConfirm): self
    {
        $this->passwordConfirm = $passwordConfirm;

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
