<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscription extends Model
{
    const CREATED_AT = 'subscribed_at';
    const UPDATED_AT = null;

    protected $table = 'newsletter_subscriptions';

    protected $fillable = ['email', 'locale'];

    protected $casts = ['subscribed_at' => 'datetime'];
}
