<?php
namespace Hasinur\LoginActivityTracker\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Contact Model
 *
 * Represents a contact in the phonebook.
 *
 * @package Hasinur\LoginActivityTracker\Models
 * @since 1.0.0
 */
class Contact extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'address', 'company', 'job_title', 'type'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email'     => 'array',
        'phone'     => 'array',
        'address'   => 'array',
    ];
}
