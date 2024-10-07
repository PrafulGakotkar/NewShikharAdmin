<?php

namespace App\Models;

use CodeIgniter\Model;

class ResultModel extends Model
{
    protected $table = 'student_results'; // Specify the table name
    protected $primaryKey = 'id'; // Specify the primary key if different from 'id'

    // stud_id	stud_name	exam_name	exam_year	college_name	score	image	created_at	
    // student_results

    // Define allowed fields here
    protected $allowedFields = ['stud_name', 'exam_name', 'exam_year', 'college_name', 'score', 'image'];

    // This method can be used to save data if needed
    public function saveTableData($data)
    {
        return $this->insert($data); // Use the insert method directly
    }

    public function getResultData()
    {
        return $this->findAll(); // Fetch all records from the table
    }

    function updateItemDetails($data, $id)
    {
        // Start a database transaction
        $this->db->transStart();

        // stud_id	stud_name	exam_name	exam_year	college_name	score	image	created_at	
        // Prepare item table data
        $idata['stud_name'] = $data['stud_name'];
        $idata['exam_name'] = $data['exam_name'];
        $idata['exam_year'] = $data['exam_year'];
        $idata['college_name'] = $data['college_name'];
        $idata['score'] = $data['score'];

        // Only set the image field if it's present in the data
        if (isset($data['image'])) {
            $idata['image'] = $data['image'];
        }

        // Update item details in the database
        $this->db->table('student_results')->where('stud_id', $id)->update($idata);

        // Complete the transaction
        $this->db->transComplete();

        // Debug: Log the last SQL query for checking if everything is correct
        error_log($this->db->getLastQuery());

        // Return the transaction status (true or false)
        return $this->db->transStatus();
    }


    function deleteData($id)
    {
        $this->db->transStart();

        $this->db->table('student_results')->where('stud_id', $id)->delete();

        $this->db->transComplete();

        return $this->db->transStatus();
    }
}
