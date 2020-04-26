<?php
include_once 'IRequest.php';


class Request implements IRequest
{
   private $conn;
  function __construct($param)
  {
    $this->conn = $param;
    $this->bootstrapSelf();
  }

  private function bootstrapSelf()
  {
    foreach($_SERVER as $key => $value)
    {
      $this->{$this->toCamelCase($key)} = $value;
    }
  }

  private function toCamelCase($string)
  {
    $result = strtolower($string);
        
    preg_match_all('/_[a-z]/', $result, $matches);

    foreach($matches[0] as $match)
    {
        $c = str_replace('_', '', strtoupper($match));
        $result = str_replace($match, $c, $result);
    }

    return $result;
  }

  public function getBody()
  {
     $sql = "SELECT * FROM text";
    $result = mysqli_query($this->conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    $answerArray = array();
    if($resultCheck > 0){
        while ($row = mysqli_fetch_assoc($result)){
          $object = (object) ['id' => $row['id'], 'body' => $row['body']];
           array_push($answerArray, $object);
        }
    }
    if($this->requestMethod === "GET")
    {
      return  $answerArray;
    }


    if ($this->requestMethod == "POST")
    {
      $sql = "INSERT INTO text (body) VALUES ('$_POST[text]');";
      $result = mysqli_query($this->conn, $sql);
      return http_response_code(200);
    }
  }
}