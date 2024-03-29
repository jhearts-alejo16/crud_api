<?php 
namespace App\Controllers; 
use CodeIgniter\RESTful\ResourceController; 
use CodeIgniter\API\ResponseTrait; 
use App\Models\EmployeeModel; 

class Employee extends ResourceController{
    use ResponseTrait; 

    public function index(){
        $model = new EmployeeModel(); 
        $data['employees'] = $model->orderBy('id', 'DESC')->findAll(); 
        return $this->respond($data); 
    }

    public function create(){
        $model = new EmployeeModel(); 
        $data = [
            'name'  => $this->request->getVar('name'), 
            'email' => $this->request->getVar('email')
        ]; 

        $model->inset($data); 
        $response = [
            'status'    => 201, 
            'error'     => null, 
            'messages'  => [
                'success'   => 'Employee created successfuly'
            ]
        ];

        return $this->respondCreated($response); 
    }

    public function show($id = null){
        $model = new EmployeeModel(); 
        $data = $model->where('ID', $id)->first();
        if($data){
            return $this->respond($data); 
        }else{
            return $this->failNotFound('No employee found!'); 
        }
    }

    public function update($id = null){
        $model = new EmployeeModel(); 
        $id = $this->request->getvar('id'); 
        $data = [
            'name'  => $this->request->getVar('name'), 
            'email' => $this->request->getVar('email')
        ];
        $model->update($id, $data); 
        $response = [
            'status'    => 200, 
            'error'     => null, 
            'mesages'   => [
                'success'   => 'Employee updated successfully'
            ]
        ];

        return $this->respond($response); 
    }

    public function delete($id = null){
        $model = new EmployeeModel(); 
        $data = $model->where('id', $id)->delete($id); 
        if($data){
            $model->delete($id); 
            $response = [
                'status'    => 200, 
                'error'     => null, 
                'messages'  => [
                    'success'   => 'Employee successfully deleted'
                ]
            ];
            return $this->respondDeleted($response); 
        }else{
            return $this->failNotFound('No employee found!');
        }
    }
}