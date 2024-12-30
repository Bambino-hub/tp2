<?php

namespace App\core;

defined("ROOTPATH") or exit("access Denied");


abstract class Validation
{
    public const RULE_REQUIRED = "required";
    public const RULE_EMAIL = "email";
    public const RULE_MIN = "min";
    public const RULE_MAX = "max";
    public const RULE_MATCH = "match";
    public const RULE_UNIQUE = "unique";

    private $db;


    /**
     * cette fonction vérifie si les propriétés d'une classe existe avant d'hydrater l'objet
     *
     * @param [type] $data
     * @return void
     */
    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    abstract public function rules(): array;
    abstract public function attributeLabels(): array;

    // on cree un tableau qui contient les errers
    public $errors = [];

    public function isValid()
    {
        // on boucle sur l'ensemble des  règles
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->$attribute;
            foreach ($rules as $rule) {
                $ruleName = $rule;

                //if rule is not a string that's an array
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }
                // on vérifie si la règle est required et il n'y a pas de valeur donc errer
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->aderrorForRules($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->aderrorForRules($attribute, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->aderrorForRules($attribute, self::RULE_MIN, $rule);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->aderrorForRules($attribute, self::RULE_MAX, $rule);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->aderrorForRules($attribute, self::RULE_MATCH, $rule);
                }
                if ($ruleName === self::RULE_UNIQUE) {
                    $this->db = Db::getInstance();
                    $class = $rule['class'];
                    $uniqueAtribute = $rule['attribute'] ?? $attribute;
                    $tableName = $class::table();
                    $query = $this->db->prepare("SELECT * FROM $tableName WHERE $uniqueAtribute = ?");
                    $query->execute([$value]);
                    $record = $query->fetch();
                    if ($record) {
                        $this->aderrorForRules($attribute, self::RULE_UNIQUE, ["field" => $attribute]);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    /**
     * cette fonction ajoute les erreurs dans le tableau d'erreur
     *
     * @param string $attribute
     * @param string $rule
     * @return void
     */
    public function aderrorForRules(string $attribute, string $rule, $params = [])
    {
        $massage = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $massage = str_replace('{' . $key . '}', $value, $massage);
        }
        $this->errors[$attribute][] = $massage;
    }

    public function adError(string $attribute, string $message)
    {
        $this->errors[$attribute][] = $message;
    }

    /**
     * cette fonction nous donne les message d'erreurs  en fonction des règles 
     *
     * @return array
     */
    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => "This field is required",
            self::RULE_EMAIL => "This field must be a valid email adress",
            self::RULE_MIN => "Min length of this field must be {min}",
            self::RULE_MAX => "Max length of this field must be {max}",
            self::RULE_MATCH => "This field must be the same as {match}",
            self::RULE_UNIQUE => "this {field} is already used ",
        ];
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }
    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}
