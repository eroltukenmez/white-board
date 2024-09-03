<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Claims\Collection as ClaimsCollection;
use Tymon\JWTAuth\Claims\Factory as ClaimFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Payload;
use Tymon\JWTAuth\Validators\PayloadValidator;

class Session extends Model {
    public $incrementing = false;
    public $timestamps = false;


    protected function token(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                $payload = json_decode(\Str::fromBase64($attributes['payload']));

                if ($payload !== null){
                    $claimFactory = app(ClaimFactory::class);

                    $claims = collect($payload)->map(function ($value, $key) use ($claimFactory) {
                        return $claimFactory->get($key, $value);
                    })->values()->all();

                    $claimsCollection = new ClaimsCollection($claims);

                    $validator = app(PayloadValidator::class);

                    try {
                        $payload = new Payload($claimsCollection, $validator);
                        return JWTAuth::encode($payload)->get();
                    } catch (JWTException $e) {}
                }

                return null;
            },
        );
    }
}
