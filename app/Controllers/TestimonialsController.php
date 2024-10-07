<?php

namespace App\Controllers;

use App\Models\TestimonialsModel;

class TestimonialsController extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/');
        }


        return view('home/testimonailsView');
    }

    function initialCall()
    {
        // `mst_financial_year`(`id`, `name`, `start_date`, `end_date`, `status`) ;
        $TransactionModel = new TestimonialsModel();
        // $data["tnxTypes"] = tnxType;
        $data = $TransactionModel->getResultData('testimonials');

        return json_encode($data);
    }


    function saveDataAjax()
    {
        // Collect post data
        $postData = [
            'username' => $this->request->getPost('name'),
            'designation' => $this->request->getPost('designation'),
            'description' => $this->request->getPost('description'),
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

        // Load TestimonialsModel
        $TestimonialsModel = new TestimonialsModel();

        // Insert data into the database
        if ($TestimonialsModel->insert($postData)) {
            // Get the updated list of testimonials
            $data["list"] = $TestimonialsModel->findAll();
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
        $id = $this->request->getPost('id');

        // Prepare the post data
        $postData = [
            'username' => $this->request->getPost('name'),
            'designation' => $this->request->getPost('designation'),
            'description' => $this->request->getPost('description'),
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
        $TestimonialsModel = new TestimonialsModel();

        // Perform the update operation
        if ($TestimonialsModel->updateItemDetails($postData, $id)) {
            // Get the updated list of testimonials
            $data["list"] = $TestimonialsModel->findAll();
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
        $id = $this->request->getPost('id');

        // Check if the ID is provided and valid
        if (empty($id)) {
            return $this->response->setStatusCode(400)->setJSON(['status_code' => 400, 'message' => 'ID is required for deletion.']);
        }

        // Initialize the model
        $TestimonialsModel = new TestimonialsModel();

        // Attempt to delete the data
        if ($TestimonialsModel->deleteData($id)) {
            // Successfully deleted the data
            return $this->response->setStatusCode(200)->setJSON(['status_code' => 200, 'message' => 'Successfully deleted the data.']);
        } else {
            // Failed to delete the data
            return $this->response->setStatusCode(500)->setJSON(['status_code' => 500, 'message' => 'Failed to delete the data.']);
        }
    }
}
