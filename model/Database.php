<?php

namespace model;

use Exception;

class Database
{
  // * se crean dos atributos privados $instance se utiliza para guardar una instacia unica de la clase y $Dbpdo se utiliza para guardar la conexion con la base de datos
  public $Dbpdo;
  // * la palabra static se coloca para poder acceder a este atributo sin intancear la clase
  static private $instance;

  //* Se crea la clase __construct() de forma privada para evitar crear mas de una instancia de esta clase
  private function __construct($dns, $user, $pass)
  {
    try {
      $this->Dbpdo = new \PDO($dns, $user, $pass);
    } catch (\PDOException $th) {
      throw new \Exception($th->getMessage());
    }
  }

  // * para poder obtener la instacia de esta clase se utiliza el metodo getInstance para retornar la instancia unica o crearla
  static public function getInstance(): Database
  {
    if (!isset(self::$instance)) {
      self::$instance = new static(getenv("DB_NAME"), getenv("DB_USER"), getenv("DB_PASS"));
    }
    return self::$instance;
  }

  private function parametros(array $datos, string $inter)
  {
    $compare = '';
    $id = array_keys($datos);

    for ($i = 0; $i < count($datos); $i++) {
      if ($i !== 0) {
        $compare .= " $inter ";
      }
      $compare .= $id[$i] . "=:" . $id[$i] . "";
    }
    return $compare;
  }

  /** 
   * ejecuta las consultas sql a la base de datos
   * @param string $text sentencia sql de tipo select para consultar los datos
   * @param array  $params los parametros a bindear dentro de la sentencia sql
   * @param bool $notacion establece el tipo de bindo a manejar 
   * @return array retorna un array con los resultados de la consulta
   */
  public function query(string $text, array $params = [], $notacion = false): array
  {
    try {
      $statement = $this->Dbpdo->prepare("$text");
      if (!empty($params)) {
        $counter = 1;
        foreach ($params as $key => $value) {
          $type = \PDO::PARAM_STR;
          if (is_int($value)) {
            $type = \PDO::PARAM_INT;
          }
          if (is_bool($value)) {
            $type = \PDO::PARAM_BOOL;
          }
          $identificador = ($notacion == false) ? $counter : $key;
          $statement->bindValue($identificador, $value, $type);
          $counter = $counter + 1;
        }
      }
      $statement->execute();
      $res = $statement->fetchAll(\PDO::FETCH_ASSOC);
      return $res;
    } catch (\PDOException $th) {
      throw new \Exception($th->getMessage());
    }
  }


  /** 
   * realiza modificaciones a la base de datos medianten el uso del la funcion query y los transaction
   * @param string $text sentencia sql de tipo select para consultar los datos
   * @param array  $params los parametros a bindear dentro de la sentencia sql
   * @return mixed retorna un mensaje de success
   */
  public function modify(string $text, array $params = [], $notacion = false)
  {
    try {
      $this->Dbpdo->beginTransaction();
      $res = $this->query($text, $params, $notacion);
      $this->Dbpdo->commit();
      return $res;
    } catch (\PDOException $th) {
      $this->Dbpdo->rollBack();
      throw new \Exception($th->getMessage());
    }
  }

  public function readMany(string $table)
  {
    try {
      $statement = $this->Dbpdo->prepare("Select * from $table");
      $statement->execute();
      $res = $statement->fetchAll(\PDO::FETCH_ASSOC);
      return $res;
    } catch (\PDOException $th) {
      throw new \Exception($th->getMessage());
    }
  }

  /**
   * Obtiene datos de la base de datos en modo solo lectura.
   * @param string $table el nombre de la tabla a consultar
   * @param array $datos elementos para filtar la consulta, entra como array asociativo ["indice" => valor], el indice tiene que ser el nombre de la columna
   * @param bool $varianze false trae solo el primer resultado, true trae todos los resultados, default = false
   * @return array|false devuelve un array en caso de encontrar algun resultado, en caso de no encontrar nada se devolvera false
   */

  public function readOnly(string $table, array $datos, $varianze = false): array|false
  {
    $keys = array_keys($datos);
    $value = array_values($datos);
    $compare = $this->parametros($datos, "AND");
    try {
      $statement = $this->Dbpdo->prepare("Select * from $table where $compare");
      for ($i = 0; $i < count($datos); $i++) {
        $statement->bindParam($keys[$i], $value[$i]);
      }
      $statement->execute();
      if ($varianze) {
        $res = $statement->fetchAll(\PDO::FETCH_ASSOC);
      } else {
        $res = $statement->fetch(\PDO::FETCH_ASSOC);
      }
      return $res;
    } catch (\PDOException $th) {
      throw new \Exception($th->getMessage());
    }
  }

  public function trasaction(string $option)
  {
    try {
      switch ($option) {
        case "begin":
          $this->Dbpdo->beginTransaction();
          break;
        case "commit":
          $this->Dbpdo->commit();
          break;
        case "back":
          $this->Dbpdo->rollBack();
          break;
        default:
          throw new Exception("Opcion no valida");
      }
    } catch (Exception) {
    }
  }

  public function insert($table, $datos)
  {
    $keys = array_keys($datos);
    $values = array_values($datos);
    try {
      $this->Dbpdo->beginTransaction();
      $statement = $this->Dbpdo->prepare(
        "insert into $table (" . implode(",", $keys) . ") values(:" . implode(",:", $keys) . ")"
      );
      for ($i = 0; $i < count($datos); $i++) {
        $statement->bindParam($keys[$i], $values[$i]);
      }
      $statement->execute();
      $res = $this->Dbpdo->lastInsertId();
      $this->Dbpdo->commit();
      return $res;
    } catch (\PDOException $th) {
      $this->Dbpdo->rollBack();
      throw new \Exception($th->getMessage());
    }
  }

  public function update($table, $where, $datos)
  {
    $whereId =  array_key_first($where);
    $whereValue = array_shift($where);
    $keys = array_keys($datos);
    $value = array_values($datos);
    try {
      $this->Dbpdo->beginTransaction();
      $parametros = $this->parametros($datos, ',');
      $statement = $this->Dbpdo->prepare(
        "UPDATE $table set $parametros WHERE " . $whereId . "=:" . $whereId
      );
      for ($i = 0; $i < count($datos); $i++) {
        $statement->bindParam($keys[$i], $value[$i]);
      }
      $statement->bindParam($whereId, $whereValue);
      $statement->execute();
      $res = $statement->fetch();
      $this->Dbpdo->commit();
      return $res;
    } catch (\PDOException $th) {
      $this->Dbpdo->rollBack();
      throw new \Exception($th->getMessage());
    }
  }
  public function delete($table, $where)
  {
    $whereId =  array_key_first($where);
    $whereValue = array_shift($where);
    try {
      $statement = $this->Dbpdo->prepare(
        "DELETE FROM $table  WHERE " . $whereId . "=:" . $whereId
      );
      $statement->bindParam($whereId, $whereValue);
      $statement->execute();
      $res = $statement->fetch();
      return $res;
    } catch (\PDOException $th) {
      throw new \Exception($th->getMessage());
    }
  }
}
