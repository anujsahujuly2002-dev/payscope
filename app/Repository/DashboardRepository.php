<?php

namespace App\Repository;

class DashboardRepository {

    public function logout($type) {
        if($type=='mobile-api'):
            $token = auth()->user()->token();
            $tokens = request()->bearerToken();
            $token->revoke();
        endif;

        $response['status']=true;
        $response['message']="You have been successfully logged out.";
        return $response;
    }
}
