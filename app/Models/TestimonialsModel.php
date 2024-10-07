<?php

namespace App\Models;

use CodeIgniter\Model;

class TestimonialsModel extends Model
{
    protected $table = 'testimonials'; // Specify the table name
    protected $primaryKey = 'id'; // Specify the primary key if different from 'id'

    // Define allowed fields here
    protected $allowedFields = ['username', 'designation', 'description', 'image'];

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

        // Prepare item table data
        $idata['username'] = $data['username'];
        $idata['designation'] = $data['designation'];
        $idata['description'] = $data['description'];

        // Only set the image field if it's present in the data
        if (isset($data['image'])) {
            $idata['image'] = $data['image'];
        }

        // Update item details in the database
        $this->db->table('testimonials')->where('Id', $id)->update($idata);

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

        $this->db->table('testimonials')->where('id', $id)->delete();

        $this->db->transComplete();

        return $this->db->transStatus();
    }
}
