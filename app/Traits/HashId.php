<?php


namespace App\Traits;

use Hashids\Hashids;

trait HashId
{

    private function key(){
        return new Hashids('Techmozzo', 62);
    }

    public function encrypt($id){
        $data = ['message' => 'Data id is invalid'];
        if(is_numeric($id)){
            $data = [
                'message' => 'encryption successful',
                'data_token' => $this->key()->encode($id)
            ];
        }
        return $data;
    }

    public function decrypt($token){
        $data = ['message' => 'Data does not exist'];
        $result = $this->key()->decode($token);
        if(!empty($result)){
            $data = ['message' => 'Data exist', 'data_id' => $result[0]];
        }
        return $data ;
    }
}
