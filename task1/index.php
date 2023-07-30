<?php

require_once('DataBase.php');

$route = explode('/', $_SERVER['REQUEST_URI']);
$method  = $_SERVER['REQUEST_METHOD'];
$body = file_get_contents('php://input');
header('Access-Control-Allow-Origin: *');


if ($route[1] === 'api') {
    if ($route[2] === 'position') {
        // --- list
        if ($route[3] === 'list' && count($route) === 4) {
            getPositionList();
        } // --- create
        elseif ($route[3] === 'create' && count($route) === 4) {
            if($method !== 'POST') {
                print 'only post is allowed!';
                exit;
            }
            createPosition($body);
        } // --- get
        elseif (count($route) === 4 && is_numeric($route[3])) {
            getPosition($route[3]);
        }  // --- update
        elseif ($route[3] === 'update' && count($route) === 5 && is_numeric($route[4])) {
            if($method !== 'POST') {
                print 'only post is allowed!';
                exit;
            }
            updatePosition($route[4], $body);
        }  // --- delete
        elseif ($route[3] === 'delete' && count($route) === 5 && is_numeric($route[4])) {
            deletePosition($route[4]);
        }
    }
}

print json_encode(['status' => 404]);


function createPosition($request) {
    $data = json_decode(trim($request), true);
    $con = (new DataBase())->getConnection();
    if (is_null($con)) {
        print 'No DB connection!';
        exit;
    }

    $date = (new DateTime())->format('Y-m-d');

    $sql = "INSERT INTO position (date, sum, comment) values (:date, :sum, :comment);";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':date' ,$date);
    $stmt->bindParam(':sum' ,$data['sum']);
    $stmt->bindParam(':comment' ,$data['comment']);
    if($stmt->execute()) {
        print json_encode(['success' => true, 'notification' => ['title' => 'Позиция добавлена', 'type' => 'success']]);
    }else {
        print json_encode(['success' => false, 'notification' => ['title' => 'Что то пошло не так', 'type' => 'failure']]);
    }
    exit;
}

function getPositionList() {
    $con = (new DataBase())->getConnection();
    if (is_null($con)) {
        print 'No DB connection!';
        exit;
    }
    $sql = 'SELECT * FROM position;';
    $stmt = $con->query($sql);
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print json_encode($res);
    exit;
}

function getPosition(int $id) {
    $con = (new DataBase())->getConnection();
    if (is_null($con)) {
        print 'No DB connection!';
        exit;
    }
    $sql = "SELECT * FROM position WHERE id = $id;";
    $stmt = $con->query($sql);
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print json_encode($res);
    exit;
}

function updatePosition(int $id, $request) {
    $data = json_decode(trim($request), true);
    $con = (new DataBase())->getConnection();
    if (is_null($con)) {
        print 'No DB connection!';
        exit;
    }
    $sql = "UPDATE position SET date = :date, sum = :sum, comment = :comment WHERE id = :id;";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':id' ,$id);
    $stmt->bindParam(':date' ,$data['date']);
    $stmt->bindParam(':sum' ,$data['sum']);
    $stmt->bindParam(':comment' ,$data['comment']);
    header('Access-Control-Allow-Origin: *');
    if($stmt->execute()) {
        print json_encode(['success' => true, 'notification' => ['title' => 'Изменения сохранены', 'type' => 'success']]);
    }else {
        print json_encode(['success' => false, 'notification' => ['title' => 'Что то пошло не так', 'type' => 'failure']]);
    }
    exit;
}

function deletePosition(int $id) {
    $con = (new DataBase())->getConnection();
    if (is_null($con)) {
        print 'No DB connection!';
        exit;
    }
    $stmt = $con->query("SELECT id FROM position WHERE id = $id");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row) {
        $sql = "DELETE FROM position WHERE id = $id;";
        if (!$con->query($sql)) {
            print json_encode(['success' => false, 'notification' => ['title' => 'Что то пошло не так', 'type' => 'failure']]);
        }
        print json_encode(['success' => true, 'notification' => ['title' => 'Позиция удалена', 'type' => 'success']],  JSON_UNESCAPED_UNICODE);
        exit;
    }
    print json_encode(['success' => false, 'notification' => ['title' => 'Позиция не существует', 'type' => 'failure']], JSON_UNESCAPED_UNICODE);
    exit;
}