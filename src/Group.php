<?php

namespace app\src;

use app\db\Database;

class Group extends Model
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

//    public function index()
//    {
//        $statement = $this->db->pdo->prepare(
//            "SELECT * FROM `groups` ORDER BY created_at DESC");
//        $statement->execute();
//        $result = $statement->fetchAll(\PDO::FETCH_OBJ);
//
//        http_response_code(200);
//        echo json_encode($result);
//    }

    public function show($id)
    {
        $group = parent::findOne($id);
        if (!$group) {
            http_response_code(404);
            echo 'Not Found!';
            exit();
        }
        $interns = parent::find('interns', ['group_id' => $id]);
        $mentors = parent::find('mentors', ['group_id' => $id]);
        echo json_encode([$group, 'interns' => $interns, 'mentors' => $mentors]);
    }

    public function tableName(): string
    {
        return 'groups';
    }

    public function attributes(): array
    {
        //
    }
}