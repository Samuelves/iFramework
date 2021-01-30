<?php

/*
  MIT License

  Copyright (c) 2021 Ives Samuel

  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
  SOFTWARE.
 */

namespace Core;
use PDO;
use PDOException;
/**
 * Description of DataBase
 *
 * @author Ives Samuel
 */
class DataBase 
{
    public function getDataBase($param)
    {
        $conf = include_once __DIR__."/../app/database.php";
        if($conf['driver'] == 'sqlite')
        {
            $sqlite = __DIR__."/../storage/database/{$conf['sqlite']['host']}";
            $sqlite = "sqlite:" . $sqlite;

            try
            {
                $pdo = new PDO($sqlite);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                return $pdo;
            } catch (PDOException $ex) {
                echo $ex->getMessage();
            }
        }elseif($conf['mysql'] == 'mysql')
        {
           $host = $conf['mysql']['host'];
           $database = $conf['mysql']['database'];
           $user = $conf['mysql']['user'];
           $pass = $conf['mysql']['pass'];
           $charset = $conf['mysql']['charset'];
           $collation = $conf['mysql']['collation'];
           try
           {
                $pdo = new PDO("mysql:host=$host;dbname=$database;charset=$charset",$user,$pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND,"SET NAMES '$charset' COLLATE '$collation'");
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                return $pdo;
           } catch (PDOException $ex) {
               echo $ex->getMessage();
           }
        }
    }
}
