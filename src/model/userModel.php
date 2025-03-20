<?php
require_once '../../config/database.php';

class UserModel extends Database {

    public function login($data) {
        $connection = parent::openConnection();
        
        try {
            $connection->beginTransaction();
            
            $stmt = $connection->prepare("SELECT * FROM users WHERE user_email = ?");
            $stmt->bindParam(1, $data['email']);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($data['password'], $user['user_password'])) {
                $connection->commit();
                return $user;
            } else {
                $connection->rollBack();
                return false;
            }
            
        } catch (PDOException $e) {
            $connection->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            parent::closeConnection();
        }
    }



    public function register($data) {
        $connection = parent::openConnection();
        
        try {
            // Hash the password before storing it
            $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
            
            $stmt = $connection->prepare("INSERT INTO users (user_email,user_password,user_type) VALUES (?,?,?)");
            $stmt->bindParam(1, $data['email']);
            $stmt->bindParam(2, $hashedPassword);
            $stmt->bindParam(3, $data['user_type']);
            $stmt->execute();
            
            return 200;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            parent::closeConnection();
        }
    }

    public function update($data) {
        $connection = parent::openConnection();
        try {
            $connection->beginTransaction();
            $stmt = $connection->prepare("UPDATE users
                            SET user_type = ?
                            WHERE id = ?");

            $stmt->bindParam(1, $data['user_type']);
            $stmt->bindParam(2, $data['id'], PDO::PARAM_INT);
            $stmt->execute();
            $connection->commit();
            return 200;
        } catch (PDOException $e) {
            $connection->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            parent::closeConnection();
        }
    }

    public function delete($id){
        $connection = parent::openConnection();
        try {
            $stmt = $connection->prepare("UPDATE users set is_deleted = 1 WHERE id = ? ");
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return 200;
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
        } finally {
            parent::closeConnection();  
        }
    }


    public function updateAccessControll($data) {
        $connection = parent::openConnection();
        try {
            $connection->beginTransaction();
            if ($data['user_status'] === 'Enable') {
                $newStatus = 'Disable';
            } else {
                $newStatus = 'Enable';
            }
            $stmt = $connection->prepare("UPDATE users
                            SET user_status = ?
                            WHERE id = ?");

            $stmt->bindParam(1, $newStatus);
            $stmt->bindParam(2, $data['id'], PDO::PARAM_INT);
            $stmt->execute();
            $connection->commit();
            return 200;
        } catch (PDOException $e) {
            $connection->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            parent::closeConnection();
        }
    }

    

}
