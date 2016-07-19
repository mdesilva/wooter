<?php
namespace Wooter\Wooter\Transformers;
use Crypt;

class OrganizationsTransformer extends Transformer
{
    public function transform($organizations)
    {
      $orgs = [];
    
       foreach($organizations as $organization)
       {
           $orgs[] = [
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
        return $orgs;
    }
}