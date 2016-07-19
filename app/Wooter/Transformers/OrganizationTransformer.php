<?php

namespace Wooter\Wooter\Transformers;
use Crypt;
class OrganizationTransformer extends Transformer
{
    public function transform($organization)
    {
    	return [
           'id' => $organization->id,
           'email' => $organization->email,
           'name'=> $organization->name,
           'phone'=> $organization->phone,
           'user_id' => $organization->user_id,
           'created_at'=>$organization->created_at,
           'url'=>$organization->url,
           'code' => Crypt::encrypt($organization->email)
       ];
    }
}