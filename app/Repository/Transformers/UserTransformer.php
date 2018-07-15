<?php
/**
 * Created by PhpStorm.
 * User: d.adelekan
 * Date: 24/08/2016
 * Time: 01:57
 */

namespace App\Repository\Transformers;


class UserTransformer extends Transformer{

    public function transform($user){

        return [
            'fullname' => $user->name,
            'email' => $user->email,
            'api_token' => $user->api_token,
        ];

    }

}