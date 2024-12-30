<?php

namespace App\models;

use App\core\Db;
use App\core\Validation;

abstract class Model extends Validation
{
    // Instance de Db
    private $db;

    protected $table;

    abstract public function colums(): array;

    public function create($data)
    {

        /** remove unwanted data **/
        if (!empty($this->colums())) {
            foreach ($data as $key => $value) {

                //on enlève les colonne qu'on aime pas dans la table
                if (!in_array($key, $this->colums())) {
                    unset($data[$key]);
                }
            }
        }

        $keys = array_keys($data);
        return $this->requete("INSERT INTO $this->table (" . implode(",", $keys) . ") values (:" . implode(",:", $keys) . ")", $data);
    }

    // function display all annonce
    public function  findAll()
    {
        $query = $this->requete('SELECT*FROM ' . $this->table);
        return $query->fetchAll();
    }
    /** */
    public function find(int $id):object
    {
        return $this->requete("SELECT * FROM  $this->table WHERE id = $id")->fetch();
    }

    // fonction qui permet de supprimer une annonce
    public function delete(int $id)
    {
        return $this->requete('DELETE FROM ' . $this->table . ' WHERE id = ?', [$id]);
    }

    /**
     *  cette fonction nous permet de preparer une requête ou de l'exécuter
     *
     * @param string $sql
     * @param array|null $attributs
     * @return void
     */
    public function requete(string $sql, array $attributs = null): object
    {
        // on recupère l'instance de Db
        $this->db = Db::getInstance();

        // on verifie si on a des attributs 
        if ($attributs !== null) {

            // on prépare la requête
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;
        } else {
            // Requête simple
            return $this->db->query($sql);
        }
    }


    //fonction qui nous permet de faire de l'hydratation
    public function hydrate($donnees)
    {
        foreach ($donnees as $key => $value) {
            // on recupère le nom du setter correspondant à la clé  ($key)
            $setter = 'set' . ucfirst($key);

            // on verifie si le setter existe
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }
        return $this;
    }
}
