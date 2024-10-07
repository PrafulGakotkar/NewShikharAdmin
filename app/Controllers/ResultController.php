<?php

namespace App\Controllers;

use App\Models\ResultModel;

class ResultController extends BaseController
{
    public function index()
    {

        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        return view('home/resultView');
    }

    function initialCall()
    {
       
        $ResultModel = new ResultModel();
       
        $data = $ResultModel->getResultData('student_results');

        return json_encode($data);
    }


    function saveDataAjax()
    {
        // Collect post data
        // stud_id	stud_name	exam_name	exam_year	college_name	score	image	created_at	
        // student_results
        $postData = [
            'stud_name' => $this->request->getPost('stud_name'),
            'exam_name' => $this->request->getPost('exam_name'),
            'exam_year' => $this->request->getPost('exam_year'),
            'college_name' => $this->request->getPost('college_name'),
            'score' => $this->request->getPost('score'),
        ];

        // Handle file upload
        $imageFile = $this->request->getFile('image');

        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            // Generate a random name for the image
            $fileName = $imageFile->getRandomName();
            // Move the image to the uploads directory
            $imageFile->move('assets/uploads/itemImgs', $fileName);
            // Add image file name to postData
            $postData['image'] = $fileName;
        } else {
            // Handle case where no image is uploaded or invalid file
            $postData['image'] = null; // Or you can set a default image
        }

        // Load ResultModel
        $ResultModel = new ResultModel();

        // Insert data into the database
        if ($ResultModel->saveTableData($postData)) {
            // Get the updated list of student_results
            $data["list"] = $ResultModel->findAll();
            // Send success response with data and status code 200
            return $this->response->setStatusCode(200)->setJSON(['status_code' => 200, 'data' => $data["list"]]);
        } else {
            // Send error response with status code 500
            return $this->response->setStatusCode(500)->setJSON(['status_code' => 500,  'error' => 'Failed to save data.']);
        }
    }

    // *********************** update Data *****************************
    function updateDataAjax()
    {
        // Get the transaction ID
        $id = $this->request->getPost('stud_id');

        // Prepare the post data
        $postData = [
            'stud_name' => $this->request->getPost('stud_name'),
            'exam_name' => $this->request->getPost('exam_name'),
            'exam_year' => $this->request->getPost('exam_year'),
            'college_name' => $this->request->getPost('college_name'),
            'score' => $this->request->getPost('score'),
        ];

        // Handle file upload if a new image is provided
        $imageFile = $this->request->getFile('image');

        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            // Generate a random name for the uploaded file
            $fileName = $imageFile->getRandomName();
            // Move the uploaded file to the destination folder
            if ($imageFile->move('assets/uploads/itemImgs', $fileName)) {
                // Add the uploaded image filename to the post data
                $postData['image'] = $fileName;
            } else {
                // Send error response with status code 500 (File move failure)
                return $this->response->setStatusCode(500)->setJSON(['status_code' => 500, 'error' => 'Failed to move uploaded file.']);
            }
        } elseif ($imageFile && !$imageFile->isValid()) {
            // Log and return error for invalid file
            return $this->response->setStatusCode(400)->setJSON(['status_code' => 400, 'error' => 'Invalid file uploaded.']);
        }

        // Initialize the model
        $ResultModel = new ResultModel();

        // Perform the update operation
        if ($ResultModel->updateItemDetails($postData, $id)) {
            // Get the updated list of student_results
            $data["list"] = $ResultModel->findAll();
            // Send success response with data and status code 200
            return $this->response->setStatusCode(200)->setJSON(['status_code' => 200, 'data' => $data["list"]]);
        } else {
            // Send error response with status code 500 for failed update
            return $this->response->setStatusCode(500)->setJSON(['status_code' => 500,  'error' => 'Failed to save data.']);
        }
    }


    // ********************** delete Data *************************
    public function deleteDataAjax()
    {
        // Get the ID from the request
        $id = $this->request->getPost('stud_id');
       
        // Check if the ID is provided and valid
        if (empty($id)) {
            return $this->response->setStatusCode(400)->setJSON(['status_code' => 400, 'message' => 'ID is required for deletion.']);
        }

        // Initialize the model
        $ResultModel = new ResultModel();

        // Attempt to delete the data
        if ($ResultModel->deleteData($id)) {
            // Successfully deleted the data
            return $this->response->setStatusCode(200)->setJSON(['status_code' => 200, 'message' => 'Successfully deleted the data.']);
        } else {
            // Failed to delete the data
            return $this->response->setStatusCode(500)->setJSON(['status_code' => 500, 'message' => 'Failed to delete the data.']);
        }
    }
}
