<?php
require_once('abstractDAO.php');
require_once('./model/coop.php');

class coopDAO extends abstractDAO {
        
    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    }  
    
    public function getCoop($coopId){
        $query = 'SELECT * FROM coop WHERE id = ?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $coopId);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $temp = $result->fetch_assoc();
            $coop = new Coop($temp['id'],$temp['title'], $temp['link'], $temp['source'], $temp['pubDate']);
            $result->free();
            return $coop;
        }
        $result->free();
        return false;
    }


    public function getCoops(){
        //The query method returns a mysqli_result object
        $result = $this->mysqli->query('SELECT * FROM coop');
        $movies = Array();
        
        if($result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                //Create a new movie object, and add it to the array.
                $coop = new Coop($row['id'], $row['title'], $row['link'], $row['source'], $row['pubDate']);
                $coops[] = $coop;
            }
            $result->free();
            return $coops;
        }
        $result->free();
        return false;
    }   
    
    public function addCoop($coop){
        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
			$query = 'INSERT INTO coop (title, link, source, pubDate) VALUES (?,?,?,?)';
			$stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $title = $coop->getTitle();
			        $link = $coop->getLink();
                    $source = $coop->getSource();
                    $pubDate = $coop->getPubDate();
                  
			        $stmt->bind_param('ssss', 
				        $title,
				        $link,
                        $source,
                        $pubDate,
			        );    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $coop->getTitle() . ' added successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }   

    public function deletecoop($coopId){
        if(!$this->mysqli->connect_errno){
            $query = 'DELETE FROM movies WHERE id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $coopId);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
?>