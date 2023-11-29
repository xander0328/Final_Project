<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RestFul\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Users;
use App\Models\Timeline;

class MainController extends ResourceController
{
    public $user, $timeline;
    public function __construct()
    {
      $this->user = new Users();
      $this->timeline = new Timeline();
    }

    public function getClerkTask()
    {
      //User Verify
      $data['verify'] = $this->user->where('verified', 'false')->find();

      //Reciept
      // $data['receipt'] =
      return $this->respond($data, 200);
    }

    public function getClientData()
    {
      $json = $this->request->getJSON();
      $id = $json->id;
      $data = $this->user->where('acc_id', $id)->first();
      return $this->respond(['data' => $data], 200);
    }

    public function approveClient(){
      $json = $this->request->getJSON();
      $id = $json->id;
      $message = $json->message;
      $verify = $json->verify;
      if($verify == "true"){
        $data = [
          'phase' => 'Account Verification',
          'type' => 'success',
          'message' => $message,
          'acc_id' => $id,
        ];
        $this->timeline->save($data);
        $this->user->set(['verified' => 'true'])->where('acc_id', $id)->update();
        return $this->respond(['message' => 'approved'], 200);
      }else{
        $data = [
          'phase' => 'Account Verification',
          'type' => 'failed',
          'message' => $message,
          'acc_id' => $id,
        ];
        $this->timeline->save($data);
        // $this->user->set(['verified' => 'true'])->where('acc_id', $id)->update();
        return $this->respond(['message' => 'declined'], 200);
      }
    }

}
